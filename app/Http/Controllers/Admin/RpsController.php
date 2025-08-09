<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rps;
use App\Models\MataKuliah;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RpsController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'mata_kuliah', 'academic_year', 'semester', 'status']);

        $rps = Rps::query()
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
            ->when($filters['academic_year'] ?? null, function ($query, $year) {
                $query->where('academic_year', $year);
            })
            ->when($filters['semester'] ?? null, function ($query, $semester) {
                $query->where('semester', $semester);
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Rps/Index', [
            'rps' => $rps,
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Rps/Create', [
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
                'learning_objectives' => [
                    'required',
                    'string',
                    'max:2000'
                ],
                'learning_outcomes' => [
                    'required',
                    'string',
                    'max:2000'
                ],
                'assessment_methods' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'references' => [
                    'nullable',
                    'string',
                    'max:2000'
                ],
                'document_url' => [
                    'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:5120' // 5MB
                ],
                'status' => [
                    'required',
                    'in:draft,submitted,approved,rejected'
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
                'learning_objectives.required' => 'Tujuan pembelajaran wajib diisi.',
                'learning_objectives.max' => 'Tujuan pembelajaran maksimal 2000 karakter.',
                'learning_outcomes.required' => 'Capaian pembelajaran wajib diisi.',
                'learning_outcomes.max' => 'Capaian pembelajaran maksimal 2000 karakter.',
                'assessment_methods.required' => 'Metode penilaian wajib diisi.',
                'assessment_methods.max' => 'Metode penilaian maksimal 1000 karakter.',
                'references.max' => 'Referensi maksimal 2000 karakter.',
                'document_url.file' => 'File harus berupa dokumen.',
                'document_url.mimes' => 'Format dokumen harus PDF, DOC, atau DOCX.',
                'document_url.max' => 'Ukuran dokumen maksimal 5MB.',
                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status tidak valid.',
            ]);

            // Handle document upload
            if ($request->hasFile('document_url')) {
                try {
                    $validated['document_url'] = $this->uploadDocument($request->file('document_url'));
                } catch (\Exception $e) {
                    Log::error('Document upload failed: ' . $e->getMessage());
                    return back()->withErrors(['document_url' => 'Gagal mengunggah dokumen.'])->withInput();
                }
            }

            Rps::create($validated);

            return redirect()->route('admin.rps.index')
                ->with('message', 'RPS berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating RPS: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit(Rps $rps): Response
    {
        $rps->load(['mataKuliah.kurikulum.programStudi', 'dosen']);

        return Inertia::render('Admin/Rps/Edit', [
            'rps' => $rps,
            'mataKuliahs' => MataKuliah::with('kurikulum.programStudi')->where('is_active', true)->get(),
            'dosens' => Team::where('is_active', true)->get()
        ]);
    }

    public function update(Request $request, Rps $rps): RedirectResponse
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
                'learning_objectives' => [
                    'required',
                    'string',
                    'max:2000'
                ],
                'learning_outcomes' => [
                    'required',
                    'string',
                    'max:2000'
                ],
                'assessment_methods' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'references' => [
                    'nullable',
                    'string',
                    'max:2000'
                ],
                'document_url' => [
                    'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:5120'
                ],
                'status' => [
                    'required',
                    'in:draft,submitted,approved,rejected'
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
                'learning_objectives.required' => 'Tujuan pembelajaran wajib diisi.',
                'learning_objectives.max' => 'Tujuan pembelajaran maksimal 2000 karakter.',
                'learning_outcomes.required' => 'Capaian pembelajaran wajib diisi.',
                'learning_outcomes.max' => 'Capaian pembelajaran maksimal 2000 karakter.',
                'assessment_methods.required' => 'Metode penilaian wajib diisi.',
                'assessment_methods.max' => 'Metode penilaian maksimal 1000 karakter.',
                'references.max' => 'Referensi maksimal 2000 karakter.',
                'document_url.file' => 'File harus berupa dokumen.',
                'document_url.mimes' => 'Format dokumen harus PDF, DOC, atau DOCX.',
                'document_url.max' => 'Ukuran dokumen maksimal 5MB.',
                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status tidak valid.',
            ]);

            // Handle document upload
            if ($request->hasFile('document_url')) {
                try {
                    // Delete old document
                    if ($rps->document_url) {
                        $this->deleteDocument($rps->document_url);
                    }
                    $validated['document_url'] = $this->uploadDocument($request->file('document_url'));
                } catch (\Exception $e) {
                    Log::error('Document upload failed during update: ' . $e->getMessage());
                    return back()->withErrors(['document_url' => 'Gagal mengunggah dokumen.'])->withInput();
                }
            } else {
                unset($validated['document_url']);
            }

            $rps->update($validated);

            return redirect()->route('admin.rps.index')
                ->with('message', 'RPS berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating RPS: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(Rps $rps): RedirectResponse
    {
        try {
            // Delete associated document
            if ($rps->document_url) {
                $this->deleteDocument($rps->document_url);
            }

            $rps->delete();

            return redirect()->route('admin.rps.index')
                ->with('message', 'RPS berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting RPS: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Upload document to public/storage/assets/docs/rps/
     */
    private function uploadDocument($file): string
    {
        try {
            $uploadPath = public_path('storage/assets/docs/rps');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'rps_' . time() . '_' . uniqid() . '.' . $extension;

            $file->move($uploadPath, $filename);

            return 'assets/docs/rps/' . $filename;
        } catch (\Exception $e) {
            Log::error('Document upload error: ' . $e->getMessage());
            throw new \Exception('Gagal mengunggah dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Delete document from public directory
     */
    private function deleteDocument(?string $documentPath): void
    {
        try {
            if ($documentPath) {
                $fullPath = public_path('storage/' . $documentPath);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
        } catch (\Exception $e) {
            Log::error('Document deletion error: ' . $e->getMessage());
        }
    }
}
