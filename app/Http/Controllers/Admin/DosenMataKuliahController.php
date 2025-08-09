<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DosenMataKuliah;
use App\Models\MataKuliah;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DosenMataKuliahController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'mata_kuliah', 'dosen', 'academic_year', 'role']);

        $dosenMataKuliahs = DosenMataKuliah::query()
            ->with(['mataKuliah.kurikulum.programStudi', 'dosen'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->whereHas('mataKuliah', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('dosen', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->when($filters['mata_kuliah'] ?? null, function ($query, $mataKuliah) {
                $query->where('mata_kuliah_id', $mataKuliah);
            })
            ->when($filters['dosen'] ?? null, function ($query, $dosen) {
                $query->where('dosen_id', $dosen);
            })
            ->when($filters['academic_year'] ?? null, function ($query, $year) {
                $query->where('academic_year', $year);
            })
            ->when($filters['role'] ?? null, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/DosenMataKuliah/Index', [
            'dosenMataKuliahs' => $dosenMataKuliahs,
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'dosens' => Team::where('is_active', true)->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/DosenMataKuliah/Create', [
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'dosens' => Team::where('is_active', true)->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'dosen_id' => [
                    'required',
                    'exists:teams,id'
                ],
                'mata_kuliah_id' => [
                    'required',
                    'exists:mata_kuliahs,id'
                ],
                'role' => [
                    'required',
                    'in:Koordinator,Pengampu,Asisten'
                ],
                'academic_year' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                'dosen_id.required' => 'Dosen wajib dipilih.',
                'dosen_id.exists' => 'Dosen tidak valid.',
                'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
                'mata_kuliah_id.exists' => 'Mata kuliah tidak valid.',
                'role.required' => 'Role wajib dipilih.',
                'role.in' => 'Role tidak valid.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'academic_year.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2023/2024).',
            ]);

            // Check for duplicate assignment
            $exists = DosenMataKuliah::where('dosen_id', $validated['dosen_id'])
                ->where('mata_kuliah_id', $validated['mata_kuliah_id'])
                ->where('academic_year', $validated['academic_year'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'mata_kuliah_id' => 'Dosen sudah ditugaskan untuk mata kuliah ini pada tahun akademik yang sama.'
                ]);
            }

            // Check if there's already a coordinator for this course
            if ($validated['role'] === 'Koordinator') {
                $hasCoordinator = DosenMataKuliah::where('mata_kuliah_id', $validated['mata_kuliah_id'])
                    ->where('academic_year', $validated['academic_year'])
                    ->where('role', 'Koordinator')
                    ->where('is_active', true)
                    ->exists();

                if ($hasCoordinator) {
                    throw ValidationException::withMessages([
                        'role' => 'Mata kuliah ini sudah memiliki koordinator untuk tahun akademik tersebut.'
                    ]);
                }
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            DosenMataKuliah::create($validated);

            return redirect()->route('admin.dosen-mata-kuliah.index')
                ->with('message', 'Penugasan dosen berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating dosen mata kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit(DosenMataKuliah $dosenMataKuliah): Response
    {
        $dosenMataKuliah->load(['mataKuliah.kurikulum.programStudi', 'dosen']);

        return Inertia::render('Admin/DosenMataKuliah/Edit', [
            'dosenMataKuliah' => $dosenMataKuliah,
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'dosens' => Team::where('is_active', true)->get()
        ]);
    }

    public function update(Request $request, DosenMataKuliah $dosenMataKuliah): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'dosen_id' => [
                    'required',
                    'exists:teams,id'
                ],
                'mata_kuliah_id' => [
                    'required',
                    'exists:mata_kuliahs,id'
                ],
                'role' => [
                    'required',
                    'in:Koordinator,Pengampu,Asisten'
                ],
                'academic_year' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                'dosen_id.required' => 'Dosen wajib dipilih.',
                'dosen_id.exists' => 'Dosen tidak valid.',
                'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
                'mata_kuliah_id.exists' => 'Mata kuliah tidak valid.',
                'role.required' => 'Role wajib dipilih.',
                'role.in' => 'Role tidak valid.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'academic_year.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2023/2024).',
            ]);

            // Check for duplicate assignment (exclude current record)
            $exists = DosenMataKuliah::where('dosen_id', $validated['dosen_id'])
                ->where('mata_kuliah_id', $validated['mata_kuliah_id'])
                ->where('academic_year', $validated['academic_year'])
                ->where('id', '!=', $dosenMataKuliah->id)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'mata_kuliah_id' => 'Dosen sudah ditugaskan untuk mata kuliah ini pada tahun akademik yang sama.'
                ]);
            }

            // Check if there's already a coordinator for this course (exclude current record)
            if ($validated['role'] === 'Koordinator') {
                $hasCoordinator = DosenMataKuliah::where('mata_kuliah_id', $validated['mata_kuliah_id'])
                    ->where('academic_year', $validated['academic_year'])
                    ->where('role', 'Koordinator')
                    ->where('is_active', true)
                    ->where('id', '!=', $dosenMataKuliah->id)
                    ->exists();

                if ($hasCoordinator) {
                    throw ValidationException::withMessages([
                        'role' => 'Mata kuliah ini sudah memiliki koordinator untuk tahun akademik tersebut.'
                    ]);
                }
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $dosenMataKuliah->update($validated);

            return redirect()->route('admin.dosen-mata-kuliah.index')
                ->with('message', 'Penugasan dosen berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating dosen mata kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(DosenMataKuliah $dosenMataKuliah): RedirectResponse
    {
        try {
            $dosenMataKuliah->delete();

            return redirect()->route('admin.dosen-mata-kuliah.index')
                ->with('message', 'Penugasan dosen berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting dosen mata kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * API endpoint untuk mendapatkan dosen aktif
     */
    public function getActiveDosen()
    {
        $dosens = Team::where('is_active', true)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json($dosens);
    }
}
