<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MataKuliahController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'kurikulum', 'semester', 'category']);

        $mataKuliahs = MataKuliah::query()
            ->with(['kurikulum.programStudi'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhereHas('kurikulum', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->when($filters['kurikulum'] ?? null, function ($query, $kurikulum) {
                $query->where('kurikulum_id', $kurikulum);
            })
            ->when($filters['semester'] ?? null, function ($query, $semester) {
                $query->where('semester', $semester);
            })
            ->when($filters['category'] ?? null, function ($query, $category) {
                $query->where('category', $category);
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/MataKuliah/Index', [
            'mataKuliahs' => $mataKuliahs,
            'kurikulums' => Kurikulum::with('programStudi')->where('is_active', true)->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/MataKuliah/Create', [
            'kurikulums' => Kurikulum::with('programStudi')->where('is_active', true)->get(),
            'availableCourses' => MataKuliah::where('is_active', true)->get(['id', 'code', 'name'])
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'kurikulum_id' => [
                    'required',
                    'exists:kurikulums,id'
                ],
                'code' => [
                    'required',
                    'string',
                    'min:3',
                    'max:10',
                    'regex:/^[A-Z0-9]+$/',
                    'unique:mata_kuliahs,code'
                ],
                'name' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255'
                ],
                'credits' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:6'
                ],
                'semester' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:8'
                ],
                'category' => [
                    'required',
                    'in:Wajib,Pilihan,MKWU,MKK,MPB,MKB,MPK'
                ],
                'prerequisite' => [
                    'nullable',
                    'array'
                ],
                'prerequisite.*' => [
                    'exists:mata_kuliahs,code'
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000'
                ],
                'learning_outcomes' => [
                    'nullable',
                    'string',
                    'max:2000'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                'kurikulum_id.required' => 'Kurikulum wajib dipilih.',
                'kurikulum_id.exists' => 'Kurikulum tidak valid.',
                'code.required' => 'Kode mata kuliah wajib diisi.',
                'code.min' => 'Kode mata kuliah minimal 3 karakter.',
                'code.max' => 'Kode mata kuliah maksimal 10 karakter.',
                'code.regex' => 'Kode harus berupa huruf kapital dan angka.',
                'code.unique' => 'Kode mata kuliah sudah digunakan.',
                'name.required' => 'Nama mata kuliah wajib diisi.',
                'name.min' => 'Nama mata kuliah minimal 5 karakter.',
                'name.max' => 'Nama mata kuliah maksimal 255 karakter.',
                'credits.required' => 'Jumlah SKS wajib diisi.',
                'credits.min' => 'Jumlah SKS minimal 1.',
                'credits.max' => 'Jumlah SKS maksimal 6.',
                'semester.required' => 'Semester wajib dipilih.',
                'semester.min' => 'Semester minimal 1.',
                'semester.max' => 'Semester maksimal 8.',
                'category.required' => 'Kategori mata kuliah wajib dipilih.',
                'category.in' => 'Kategori mata kuliah tidak valid.',
                'prerequisite.*.exists' => 'Kode prerequisite tidak valid.',
                'description.max' => 'Deskripsi maksimal 1000 karakter.',
                'learning_outcomes.max' => 'Capaian pembelajaran maksimal 2000 karakter.',
            ]);

            $validated['is_active'] = $request->boolean('is_active', true);

            MataKuliah::create($validated);

            return redirect()->route('admin.mata-kuliah.index')
                ->with('message', 'Mata kuliah berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error Creating mata kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        try {
            // Check if mata kuliah has related records
            if ($mataKuliah->jadwalKuliahs()->count() > 0 || $mataKuliah->rps()->count() > 0) {
                return back()->with('error', 'Mata kuliah tidak dapat dihapus karena masih memiliki jadwal atau RPS.');
            }

            $mataKuliah->delete();

            return redirect()->route('admin.mata-kuliah.index')
                ->with('message', 'Mata kuliah berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting mata kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * API endpoint untuk mendapatkan mata kuliah berdasarkan kurikulum
     */
    public function getByKurikulum(Kurikulum $kurikulum)
    {
        $mataKuliahs = $kurikulum->mataKuliahs()
            ->where('is_active', true)
            ->select('id', 'code', 'name', 'credits', 'semester')
            ->orderBy('semester')
            ->orderBy('code')
            ->get();

        return response()->json($mataKuliahs);
    }


    public function edit(MataKuliah $mataKuliah): Response
    {
        $mataKuliah->load(['kurikulum.programStudi']);

        return Inertia::render('Admin/MataKuliah/Edit', [
            'mataKuliah' => $mataKuliah,
            'kurikulums' => Kurikulum::with('programStudi')->where('is_active', true)->get(),
            'availableCourses' => MataKuliah::where('is_active', true)
                ->where('id', '!=', $mataKuliah->id)
                ->get(['id', 'code', 'name'])
        ]);
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'kurikulum_id' => [
                    'required',
                    'exists:kurikulums,id'
                ],
                'code' => [
                    'required',
                    'string',
                    'min:3',
                    'max:10',
                    'regex:/^[A-Z0-9]+$/',
                    'unique:mata_kuliahs,code,' . $mataKuliah->id
                ],
                'name' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255'
                ],
                'credits' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:6'
                ],
                'semester' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:8'
                ],
                'category' => [
                    'required',
                    'in:Wajib,Pilihan,MKWU,MKK,MPB,MKB,MPK'
                ],
                'prerequisite' => [
                    'nullable',
                    'array'
                ],
                'prerequisite.*' => [
                    'exists:mata_kuliahs,code'
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000'
                ],
                'learning_outcomes' => [
                    'nullable',
                    'string',
                    'max:2000'
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                // Same error messages as store
                'kurikulum_id.required' => 'Kurikulum wajib dipilih.',
                'kurikulum_id.exists' => 'Kurikulum tidak valid.',
                'code.required' => 'Kode mata kuliah wajib diisi.',
                'code.min' => 'Kode mata kuliah minimal 3 karakter.',
                'code.max' => 'Kode mata kuliah maksimal 10 karakter.',
                'code.regex' => 'Kode harus berupa huruf kapital dan angka.',
                'code.unique' => 'Kode mata kuliah sudah digunakan.',
                'name.required' => 'Nama mata kuliah wajib diisi.',
                'name.min' => 'Nama mata kuliah minimal 5 karakter.',
                'name.max' => 'Nama mata kuliah maksimal 255 karakter.',
                'credits.required' => 'Jumlah SKS wajib diisi.',
                'credits.min' => 'Jumlah SKS minimal 1.',
                'credits.max' => 'Jumlah SKS maksimal 6.',
                'semester.required' => 'Semester wajib dipilih.',
                'semester.min' => 'Semester minimal 1.',
                'semester.max' => 'Semester maksimal 8.',
                'category.required' => 'Kategori mata kuliah wajib dipilih.',
                'category.in' => 'Kategori mata kuliah tidak valid.',
                'prerequisite.*.exists' => 'Kode prerequisite tidak valid.',
                'description.max' => 'Deskripsi maksimal 1000 karakter.',
                'learning_outcomes.max' => 'Capaian pembelajaran maksimal 2000 karakter.',
            ]);

            $validated['is_active'] = $request->boolean('is_active', true);

            $mataKuliah->update($validated);

            return redirect()->route('admin.mata-kuliah.index')
                ->with('message', 'Mata kuliah berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating mata kuliah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }
}
