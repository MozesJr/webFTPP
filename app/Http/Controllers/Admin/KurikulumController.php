<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class KurikulumController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'prodi', 'academic_year']);

        $kurikulums = Kurikulum::query()
            ->with(['programStudi'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('academic_year', 'like', '%' . $search . '%')
                    ->orWhereHas('programStudi', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->when($filters['prodi'] ?? null, function ($query, $prodi) {
                $query->where('prodi_id', $prodi);
            })
            ->when($filters['academic_year'] ?? null, function ($query, $year) {
                $query->where('academic_year', $year);
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Kurikulum/Index', [
            'kurikulums' => $kurikulums,
            'programStudis' => ProgramStudi::where('is_active', true)->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Kurikulum/Create', [
            'programStudis' => ProgramStudi::where('is_active', true)->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'prodi_id' => [
                    'required',
                    'exists:program_studis,id'
                ],
                'name' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255'
                ],
                'academic_year' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/'
                ],
                'total_credits' => [
                    'required',
                    'integer',
                    'min:120',
                    'max:200'
                ],
                'document_url' => [
                    'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:5120' // 5MB
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                'prodi_id.required' => 'Program studi wajib dipilih.',
                'prodi_id.exists' => 'Program studi tidak valid.',
                'name.required' => 'Nama kurikulum wajib diisi.',
                'name.min' => 'Nama kurikulum minimal 5 karakter.',
                'name.max' => 'Nama kurikulum maksimal 255 karakter.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'academic_year.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2023/2024).',
                'total_credits.required' => 'Total SKS wajib diisi.',
                'total_credits.min' => 'Total SKS minimal 120.',
                'total_credits.max' => 'Total SKS maksimal 200.',
                'document_url.file' => 'File harus berupa dokumen.',
                'document_url.mimes' => 'Format dokumen harus PDF, DOC, atau DOCX.',
                'document_url.max' => 'Ukuran dokumen maksimal 5MB.',
                'description.max' => 'Deskripsi maksimal 1000 karakter.',
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

            $validated['is_active'] = $request->boolean('is_active', true);

            Kurikulum::create($validated);

            return redirect()->route('admin.kurikulum.index')
                ->with('message', 'Kurikulum berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating kurikulum: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit(Kurikulum $kurikulum): Response
    {
        $kurikulum->load(['programStudi']);

        return Inertia::render('Admin/Kurikulum/Edit', [
            'kurikulum' => $kurikulum,
            'programStudis' => ProgramStudi::where('is_active', true)->get()
        ]);
    }

    public function update(Request $request, Kurikulum $kurikulum): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'prodi_id' => [
                    'required',
                    'exists:program_studis,id'
                ],
                'name' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255'
                ],
                'academic_year' => [
                    'required',
                    'string',
                    'regex:/^\d{4}\/\d{4}$/'
                ],
                'total_credits' => [
                    'required',
                    'integer',
                    'min:120',
                    'max:200'
                ],
                'document_url' => [
                    'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:5120'
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                // Same error messages as store
                'prodi_id.required' => 'Program studi wajib dipilih.',
                'prodi_id.exists' => 'Program studi tidak valid.',
                'name.required' => 'Nama kurikulum wajib diisi.',
                'name.min' => 'Nama kurikulum minimal 5 karakter.',
                'name.max' => 'Nama kurikulum maksimal 255 karakter.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'academic_year.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2023/2024).',
                'total_credits.required' => 'Total SKS wajib diisi.',
                'total_credits.min' => 'Total SKS minimal 120.',
                'total_credits.max' => 'Total SKS maksimal 200.',
                'document_url.file' => 'File harus berupa dokumen.',
                'document_url.mimes' => 'Format dokumen harus PDF, DOC, atau DOCX.',
                'document_url.max' => 'Ukuran dokumen maksimal 5MB.',
                'description.max' => 'Deskripsi maksimal 1000 karakter.',
            ]);

            // Handle document upload
            if ($request->hasFile('document_url')) {
                try {
                    // Delete old document
                    if ($kurikulum->document_url) {
                        $this->deleteDocument($kurikulum->document_url);
                    }
                    $validated['document_url'] = $this->uploadDocument($request->file('document_url'));
                } catch (\Exception $e) {
                    Log::error('Document upload failed during update: ' . $e->getMessage());
                    return back()->withErrors(['document_url' => 'Gagal mengunggah dokumen.'])->withInput();
                }
            } else {
                unset($validated['document_url']);
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $kurikulum->update($validated);

            return redirect()->route('admin.kurikulum.index')
                ->with('message', 'Kurikulum berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating kurikulum: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(Kurikulum $kurikulum): RedirectResponse
    {
        try {
            // Check if kurikulum has related mata kuliah
            if ($kurikulum->mataKuliahs()->count() > 0) {
                return back()->with('error', 'Kurikulum tidak dapat dihapus karena masih memiliki mata kuliah.');
            }

            // Delete associated document
            if ($kurikulum->document_url) {
                $this->deleteDocument($kurikulum->document_url);
            }

            $kurikulum->delete();

            return redirect()->route('admin.kurikulum.index')
                ->with('message', 'Kurikulum berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting kurikulum: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Upload document to public/storage/assets/docs/kurikulum/
     */
    private function uploadDocument($file): string
    {
        try {
            $uploadPath = public_path('storage/assets/docs/kurikulum');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'kurikulum_' . time() . '_' . uniqid() . '.' . $extension;

            $file->move($uploadPath, $filename);

            return 'assets/docs/kurikulum/' . $filename;
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
