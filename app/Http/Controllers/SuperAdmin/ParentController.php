<?php
// app/Http/Controllers/SuperAdmin/ParentController.php - Complete CRUD

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParentsStudentsImport;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $query = ParentModel::with(['student'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhereHas('student', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('nim', 'like', '%' . $request->search . '%');
                    });
            })
            ->when($request->relation, function ($q) use ($request) {
                $q->where('relation', $request->relation);
            })
            ->when(isset($request->is_active), function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Add computed properties for frontend
        $query->getCollection()->transform(function ($parent) {
            $parent->relation_label = $this->getRelationLabel($parent->relation);
            $parent->relation_badge = $this->getRelationBadgeClass($parent->relation);
            return $parent;
        });

        return Inertia::render('SuperAdmin/Parents/Index', [
            'parents' => $query,
            'filters' => $request->only(['search', 'relation', 'is_active']),
        ]);
    }

    public function create()
    {
        $students = Student::whereDoesntHave('parent')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'nim', 'name', 'email', 'program_studi', 'address']);

        return Inertia::render('SuperAdmin/Parents/Create', [
            'students' => $students
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:parents,email',
            'phone' => 'nullable|string|max:20',
            'relation' => 'required|in:ayah,ibu,wali',
            'occupation' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Check if student already has a parent
        if (ParentModel::where('student_id', $request->student_id)->exists()) {
            return redirect()->back()
                ->withErrors(['student_id' => 'Siswa ini sudah memiliki akun orang tua.'])
                ->withInput();
        }

        $student = Student::findOrFail($request->student_id);

        $parent = ParentModel::create([
            'student_id' => $request->student_id,
            'username' => $student->nim,
            'password' => $student->nim . '123', // default password
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'relation' => $request->relation,
            'occupation' => $request->occupation,
            'address' => $request->address,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()
            ->route('super-admin.parents.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Akun orang tua berhasil dibuat!'
            ]);
    }

    public function show(ParentModel $parent)
    {
        $parent->load(['student']);

        return Inertia::render('SuperAdmin/Parents/Show', [
            'parent' => $parent
        ]);
    }

    public function edit(ParentModel $parent)
    {
        $parent->load(['student']);

        return Inertia::render('SuperAdmin/Parents/Edit', [
            'parent' => $parent
        ]);
    }

    public function update(Request $request, ParentModel $parent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:parents,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'relation' => 'required|in:ayah,ibu,wali',
            'occupation' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'relation',
            'occupation',
            'address',
            'is_active'
        ]);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $parent->update($data);

        return redirect()
            ->route('super-admin.parents.index')
            ->with('flash', [
                'type' => 'success',
                'message' => 'Data orang tua berhasil diperbarui!'
            ]);
    }

    public function destroy(ParentModel $parent)
    {
        $parentName = $parent->name;
        $parent->delete();

        return redirect()
            ->route('super-admin.parents.index')
            ->with('flash', [
                'type' => 'success',
                'message' => "Akun orang tua \"{$parentName}\" berhasil dihapus!"
            ]);
    }

    // Import functionality
    public function showImport()
    {
        return Inertia::render('SuperAdmin/Parents/Import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            DB::beginTransaction();

            \Log::info('Starting import process', [
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_size' => $request->file('file')->getSize(),
                'mime_type' => $request->file('file')->getMimeType()
            ]);

            $import = new ParentsStudentsImport;
            Excel::import($import, $request->file('file'));

            DB::commit();

            $importedCount = $import->getImportedCount();

            return redirect()
                ->route('super-admin.parents.index')
                ->with('flash', [
                    'type' => 'success',
                    'message' => "Berhasil mengimpor {$importedCount} data!"
                ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollback();

            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }

            \Log::error('Import validation errors', $errorMessages);

            return redirect()
                ->back()
                ->withErrors(['file' => 'Kesalahan validasi: ' . implode(' | ', array_slice($errorMessages, 0, 3))])
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Gagal import karena validasi: ' . implode(' | ', array_slice($errorMessages, 0, 3))
                ]);
        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('Import general error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withErrors(['file' => 'Gagal mengimpor data: ' . $e->getMessage()])
                ->with('flash', [
                    'type' => 'error',
                    'message' => 'Gagal mengimpor data: ' . $e->getMessage()
                ]);
        }
    }

    public function resetPassword(ParentModel $parent)
    {
        $student = $parent->student;
        $newPassword = $student->nim . '123';

        $parent->update([
            'password' => $newPassword
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset ke: ' . $newPassword
        ]);
    }

    public function toggleStatus(ParentModel $parent)
    {
        $parent->update(['is_active' => !$parent->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah.',
            'is_active' => $parent->is_active
        ]);
    }

    // Download Template CSV
    public function downloadTemplate()
    {
        $headers = [
            'nim_siswa',
            'nama_siswa',
            'email_siswa',
            'telepon_siswa',
            'jenis_kelamin',
            'tanggal_lahir',
            'tempat_lahir',
            'alamat_siswa',
            'program_studi',
            'semester',
            'status_siswa',
            'tahun_masuk',
            'nama_orang_tua',
            'email_orang_tua',
            'telepon_orang_tua',
            'hubungan',
            'pekerjaan',
            'alamat_orang_tua'
        ];

        $sampleData = [
            [
                '2023001',
                'Ahmad Fauzi',
                'ahmad@email.com',
                '08123456789',
                'L',
                '15/01/2000',
                'Jakarta',
                'Jl. Merdeka No. 1',
                'Teknik Informatika',
                '3',
                'aktif',
                '2023',
                'Budi Santoso',
                'budi@email.com',
                '08198765432',
                'ayah',
                'Wiraswasta',
                'Jl. Merdeka No. 1'
            ],
            [
                '2023002',
                'Siti Aminah',
                'siti@email.com',
                '08123456790',
                'P',
                '20/03/1999',
                'Surabaya',
                'Jl. Pahlawan No. 5',
                'Manajemen',
                '5',
                'aktif',
                '2023',
                'Sari Dewi',
                'sari@email.com',
                '08198765433',
                'ibu',
                'Guru',
                'Jl. Pahlawan No. 5'
            ]
        ];

        $filename = 'template_import_orang_tua.csv';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);

        $file = fopen($temp_file, 'w');

        // Add BOM for UTF-8
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Add headers
        fputcsv($file, $headers);

        // Add sample data
        foreach ($sampleData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->download($temp_file, $filename, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend(true);
    }

    // Helper methods
    private function getRelationLabel($relation)
    {
        $labels = [
            'ayah' => 'Ayah',
            'ibu' => 'Ibu',
            'wali' => 'Wali',
        ];

        return $labels[$relation] ?? $relation;
    }

    private function getRelationBadgeClass($relation)
    {
        $badges = [
            'ayah' => 'bg-blue-100 text-blue-800',
            'ibu' => 'bg-pink-100 text-pink-800',
            'wali' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$relation] ?? 'bg-gray-100 text-gray-800';
    }
}
