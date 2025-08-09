<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use App\Models\MataKuliah;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class JadwalKuliahController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'mata_kuliah', 'academic_year', 'semester', 'day']);

        $jadwalKuliahs = JadwalKuliah::query()
            ->with(['mataKuliah.kurikulum.programStudi', 'dosen'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('class_name', 'like', '%' . $search . '%')
                    ->orWhere('room', 'like', '%' . $search . '%')
                    ->orWhereHas('mataKuliah', function ($q) use ($search) {
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
            ->when($filters['academic_year'] ?? null, function ($query, $year) {
                $query->where('academic_year', $year);
            })
            ->when($filters['semester'] ?? null, function ($query, $semester) {
                $query->where('semester', $semester);
            })
            ->when($filters['day'] ?? null, function ($query, $day) {
                $query->where('day', $day);
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/JadwalKuliah/Index', [
            'jadwalKuliahs' => $jadwalKuliahs,
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/JadwalKuliah/Create', [
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'dosens' => Team::where('is_active', true)->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'mata_kuliah_id' => [
                    'required',
                    'exists:mata_kuliahs,id'
                ],
                'dosen_id' => [
                    'required',
                    'exists:teams,id'
                ],
                'academic_year' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/'
                ],
                'semester' => [
                    'required',
                    'in:Ganjil,Genap'
                ],
                'class_name' => [
                    'required',
                    'string',
                    'min:1',
                    'max:50'
                ],
                'day' => [
                    'required',
                    'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'
                ],
                'start_time' => [
                    'required',
                    'date_format:H:i'
                ],
                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time'
                ],
                'room' => [
                    'required',
                    'string',
                    'max:50'
                ],
                'capacity' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:100'
                ],
                'enrolled_students' => [
                    'nullable',
                    'integer',
                    'min:0',
                    'max:100'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
                'mata_kuliah_id.exists' => 'Mata kuliah tidak valid.',
                'dosen_id.required' => 'Dosen wajib dipilih.',
                'dosen_id.exists' => 'Dosen tidak valid.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'academic_year.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2023/2024).',
                'semester.required' => 'Semester wajib dipilih.',
                'semester.in' => 'Semester harus Ganjil atau Genap.',
                'class_name.required' => 'Nama kelas wajib diisi.',
                'class_name.max' => 'Nama kelas maksimal 50 karakter.',
                'day.required' => 'Hari wajib dipilih.',
                'day.in' => 'Hari tidak valid.',
                'start_time.required' => 'Waktu mulai wajib diisi.',
                'start_time.date_format' => 'Format waktu mulai harus HH:MM.',
                'end_time.required' => 'Waktu selesai wajib diisi.',
                'end_time.date_format' => 'Format waktu selesai harus HH:MM.',
                'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
                'room.required' => 'Ruangan wajib diisi.',
                'room.max' => 'Nama ruangan maksimal 50 karakter.',
                'capacity.required' => 'Kapasitas wajib diisi.',
                'capacity.min' => 'Kapasitas minimal 1.',
                'capacity.max' => 'Kapasitas maksimal 100.',
                'enrolled_students.min' => 'Jumlah mahasiswa terdaftar minimal 0.',
                'enrolled_students.max' => 'Jumlah mahasiswa terdaftar maksimal 100.',
            ]);

            // Validate time conflict
            $this->checkTimeConflict($validated, null);

            // Set default values
            $validated['enrolled_students'] = $validated['enrolled_students'] ?? 0;
            $validated['is_active'] = $request->boolean('is_active', true);

            JadwalKuliah::create($validated);

            return redirect()->route('admin.jadwal-kuliah.index')
                ->with('message', 'Jadwal kuliah berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating jadwal kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit(JadwalKuliah $jadwalKuliah): Response
    {
        $jadwalKuliah->load(['mataKuliah.kurikulum.programStudi', 'dosen']);

        return Inertia::render('Admin/JadwalKuliah/Edit', [
            'jadwalKuliah' => $jadwalKuliah,
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'dosens' => Team::where('is_active', true)->get()
        ]);
    }

    public function update(Request $request, JadwalKuliah $jadwalKuliah): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'mata_kuliah_id' => [
                    'required',
                    'exists:mata_kuliahs,id'
                ],
                'dosen_id' => [
                    'required',
                    'exists:teams,id'
                ],
                'academic_year' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/'
                ],
                'semester' => [
                    'required',
                    'in:Ganjil,Genap'
                ],
                'class_name' => [
                    'required',
                    'string',
                    'min:1',
                    'max:50'
                ],
                'day' => [
                    'required',
                    'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'
                ],
                'start_time' => [
                    'required',
                    'date_format:H:i'
                ],
                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time'
                ],
                'room' => [
                    'required',
                    'string',
                    'max:50'
                ],
                'capacity' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:100'
                ],
                'enrolled_students' => [
                    'nullable',
                    'integer',
                    'min:0',
                    'max:100'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                // Same error messages as store
                'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
                'mata_kuliah_id.exists' => 'Mata kuliah tidak valid.',
                'dosen_id.required' => 'Dosen wajib dipilih.',
                'dosen_id.exists' => 'Dosen tidak valid.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'academic_year.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2023/2024).',
                'semester.required' => 'Semester wajib dipilih.',
                'semester.in' => 'Semester harus Ganjil atau Genap.',
                'class_name.required' => 'Nama kelas wajib diisi.',
                'class_name.max' => 'Nama kelas maksimal 50 karakter.',
                'day.required' => 'Hari wajib dipilih.',
                'day.in' => 'Hari tidak valid.',
                'start_time.required' => 'Waktu mulai wajib diisi.',
                'start_time.date_format' => 'Format waktu mulai harus HH:MM.',
                'end_time.required' => 'Waktu selesai wajib diisi.',
                'end_time.date_format' => 'Format waktu selesai harus HH:MM.',
                'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
                'room.required' => 'Ruangan wajib diisi.',
                'room.max' => 'Nama ruangan maksimal 50 karakter.',
                'capacity.required' => 'Kapasitas wajib diisi.',
                'capacity.min' => 'Kapasitas minimal 1.',
                'capacity.max' => 'Kapasitas maksimal 100.',
                'enrolled_students.min' => 'Jumlah mahasiswa terdaftar minimal 0.',
                'enrolled_students.max' => 'Jumlah mahasiswa terdaftar maksimal 100.',
            ]);

            // Validate time conflict (exclude current schedule)
            $this->checkTimeConflict($validated, $jadwalKuliah->id);

            $validated['enrolled_students'] = $validated['enrolled_students'] ?? 0;
            $validated['is_active'] = $request->boolean('is_active', true);

            $jadwalKuliah->update($validated);

            return redirect()->route('admin.jadwal-kuliah.index')
                ->with('message', 'Jadwal kuliah berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating jadwal kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(JadwalKuliah $jadwalKuliah): RedirectResponse
    {
        try {
            $jadwalKuliah->delete();

            return redirect()->route('admin.jadwal-kuliah.index')
                ->with('message', 'Jadwal kuliah berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting jadwal kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Check for time conflicts
     */
    private function checkTimeConflict(array $data, ?int $excludeId = null): void
    {
        $query = JadwalKuliah::where('academic_year', $data['academic_year'])
            ->where('semester', $data['semester'])
            ->where('day', $data['day'])
            ->where(function ($q) use ($data) {
                $q->where(function ($subQ) use ($data) {
                    // Check if start_time is between existing schedule
                    $subQ->where('start_time', '<=', $data['start_time'])
                        ->where('end_time', '>', $data['start_time']);
                })->orWhere(function ($subQ) use ($data) {
                    // Check if end_time is between existing schedule
                    $subQ->where('start_time', '<', $data['end_time'])
                        ->where('end_time', '>=', $data['end_time']);
                })->orWhere(function ($subQ) use ($data) {
                    // Check if new schedule covers existing schedule
                    $subQ->where('start_time', '>=', $data['start_time'])
                        ->where('end_time', '<=', $data['end_time']);
                });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Check room conflict
        $roomConflict = $query->where('room', $data['room'])->exists();
        if ($roomConflict) {
            throw ValidationException::withMessages([
                'room' => 'Ruangan sudah digunakan pada waktu tersebut.'
            ]);
        }

        // Check dosen conflict
        $dosenConflict = $query->where('dosen_id', $data['dosen_id'])->exists();
        if ($dosenConflict) {
            throw ValidationException::withMessages([
                'dosen_id' => 'Dosen sudah mengajar pada waktu tersebut.'
            ]);
        }
    }
}
