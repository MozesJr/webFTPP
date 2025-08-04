<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProgramStudiController extends Controller
{
    public function index(Request $request): Response
    {
        // Ambil filter dari request.
        // Inertia.js akan mengirimkan parameter 'search' jika pengguna mengetik di input pencarian.
        $filters = $request->only('search');

        $programStudis = ProgramStudi::query()
            // Gunakan when() untuk mengaplikasikan filter 'search' hanya jika ada
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('head_of_program', 'like', '%' . $search . '%');
                // Anda bisa menambahkan kolom lain yang ingin dicari di sini
            })
            ->latest() // Urutkan berdasarkan yang terbaru (atau sesuai kebutuhan Anda)
            ->paginate(10) // Tentukan berapa item per halaman
            ->withQueryString(); // Sangat penting! Ini akan mempertahankan parameter filter saat paginasi

        return Inertia::render('Admin/ProgramStudi/Index', [
            'programStudis' => $programStudis,
            'filters' => $filters, // Kirimkan filter kembali ke frontend agar input pencarian terisi
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ProgramStudi/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'unique:program_studis,name'
                ],
                'code' => [
                    'required',
                    'string',
                    'min:2',
                    'max:10',
                    'regex:/^[A-Z0-9]+$/',
                    'unique:program_studis,code'
                ],
                'degree_level' => [
                    'required',
                    'in:D3,S1,S2,S3'
                ],
                'description' => [
                    'required',
                    'string',
                    'min:10',
                    'max:1000'
                ],
                'overview' => [
                    'nullable',
                    'string',
                    'max:5000'
                ],
                'image_url' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048' // 2MB
                ],
                'accreditation' => [
                    'nullable',
                    'string',
                    'in:Unggul,Baik Sekali,Baik,A,B,C'
                ],
                'accreditation_date' => [
                    'nullable',
                    'date',
                    'before_or_equal:today'
                ],
                'accreditation_expire' => [
                    'nullable',
                    'date',
                    'after:accreditation_date'
                ],
                'head_of_program' => [
                    'nullable',
                    'string',
                    'max:255'
                ],
                'established_year' => [
                    'nullable',
                    'integer',
                    'min:1900',
                    'max:' . date('Y')
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                // Custom error messages
                'name.required' => 'Nama program studi wajib diisi.',
                'name.min' => 'Nama program studi minimal 3 karakter.',
                'name.max' => 'Nama program studi maksimal 255 karakter.',
                'name.unique' => 'Nama program studi sudah digunakan.',

                'code.required' => 'Kode program studi wajib diisi.',
                'code.min' => 'Kode program studi minimal 2 karakter.',
                'code.max' => 'Kode program studi maksimal 10 karakter.',
                'code.regex' => 'Kode harus berupa huruf kapital dan angka.',
                'code.unique' => 'Kode program studi sudah digunakan.',

                'degree_level.required' => 'Jenjang wajib dipilih.',
                'degree_level.in' => 'Jenjang tidak valid.',

                'description.required' => 'Deskripsi wajib diisi.',
                'description.min' => 'Deskripsi minimal 10 karakter.',
                'description.max' => 'Deskripsi maksimal 1000 karakter.',

                'overview.max' => 'Overview maksimal 5000 karakter.',

                'image_url.image' => 'File harus berupa gambar.',
                'image_url.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
                'image_url.max' => 'Ukuran gambar maksimal 2MB.',

                'accreditation.in' => 'Akreditasi tidak valid.',

                'accreditation_date.date' => 'Format tanggal akreditasi tidak valid.',
                'accreditation_date.before_or_equal' => 'Tanggal akreditasi tidak boleh di masa depan.',

                'accreditation_expire.date' => 'Format tanggal kadaluarsa tidak valid.',
                'accreditation_expire.after' => 'Tanggal kadaluarsa harus setelah tanggal akreditasi.',

                'head_of_program.max' => 'Nama kepala program studi maksimal 255 karakter.',

                'established_year.integer' => 'Tahun berdiri harus berupa angka.',
                'established_year.min' => 'Tahun berdiri minimal 1900.',
                'established_year.max' => 'Tahun berdiri tidak boleh melebihi tahun ini.',
            ]);

            // Handle image upload
            if ($request->hasFile('image_url')) {
                try {
                    $validated['image_url'] = $this->uploadImage($request->file('image_url'));
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return back()->withErrors(['image_url' => 'Gagal mengunggah gambar.'])->withInput();
                }
            }

            // Set default values
            $validated['is_active'] = $request->boolean('is_active', true);

            // Create the program studi
            ProgramStudi::create($validated);

            return redirect()->route('admin.program-studi.index')
                ->with('message', 'Program Studi berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating program studi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit(ProgramStudi $programStudi): Response
    {
        return Inertia::render('Admin/ProgramStudi/Edit', [
            'programStudi' => $programStudi
        ]);
    }

    public function update(Request $request, ProgramStudi $programStudi): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'unique:program_studis,name,' . $programStudi->id
                ],
                'code' => [
                    'required',
                    'string',
                    'min:2',
                    'max:10',
                    'regex:/^[A-Z0-9]+$/',
                    'unique:program_studis,code,' . $programStudi->id
                ],
                'degree_level' => [
                    'required',
                    'in:D3,S1,S2,S3'
                ],
                'description' => [
                    'required',
                    'string',
                    'min:10',
                    'max:1000'
                ],
                'overview' => [
                    'nullable',
                    'string',
                    'max:5000'
                ],
                'image_url' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048'
                ],
                'accreditation' => [
                    'nullable',
                    'string',
                    'in:Unggul,Baik Sekali,Baik,A,B,C'
                ],
                'accreditation_date' => [
                    'nullable',
                    'date',
                    'before_or_equal:today'
                ],
                'accreditation_expire' => [
                    'nullable',
                    'date',
                    'after:accreditation_date'
                ],
                'head_of_program' => [
                    'nullable',
                    'string',
                    'max:255'
                ],
                'established_year' => [
                    'nullable',
                    'integer',
                    'min:1900',
                    'max:' . date('Y')
                ],
                'is_active' => [
                    'boolean'
                ]
            ], [
                // Same custom error messages as store method
                'name.required' => 'Nama program studi wajib diisi.',
                'name.min' => 'Nama program studi minimal 3 karakter.',
                'name.max' => 'Nama program studi maksimal 255 karakter.',
                'name.unique' => 'Nama program studi sudah digunakan.',

                'code.required' => 'Kode program studi wajib diisi.',
                'code.min' => 'Kode program studi minimal 2 karakter.',
                'code.max' => 'Kode program studi maksimal 10 karakter.',
                'code.regex' => 'Kode harus berupa huruf kapital dan angka.',
                'code.unique' => 'Kode program studi sudah digunakan.',

                'degree_level.required' => 'Jenjang wajib dipilih.',
                'degree_level.in' => 'Jenjang tidak valid.',

                'description.required' => 'Deskripsi wajib diisi.',
                'description.min' => 'Deskripsi minimal 10 karakter.',
                'description.max' => 'Deskripsi maksimal 1000 karakter.',

                'overview.max' => 'Overview maksimal 5000 karakter.',

                'image_url.image' => 'File harus berupa gambar.',
                'image_url.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
                'image_url.max' => 'Ukuran gambar maksimal 2MB.',

                'accreditation.in' => 'Akreditasi tidak valid.',

                'accreditation_date.date' => 'Format tanggal akreditasi tidak valid.',
                'accreditation_date.before_or_equal' => 'Tanggal akreditasi tidak boleh di masa depan.',

                'accreditation_expire.date' => 'Format tanggal kadaluarsa tidak valid.',
                'accreditation_expire.after' => 'Tanggal kadaluarsa harus setelah tanggal akreditasi.',

                'head_of_program.max' => 'Nama kepala program studi maksimal 255 karakter.',

                'established_year.integer' => 'Tahun berdiri harus berupa angka.',
                'established_year.min' => 'Tahun berdiri minimal 1900.',
                'established_year.max' => 'Tahun berdiri tidak boleh melebihi tahun ini.',
            ]);

            // Handle image upload
            if ($request->hasFile('image_url')) {
                try {
                    // Delete old image
                    if ($programStudi->image_url) {
                        $this->deleteImage($programStudi->image_url);
                    }
                    $validated['image_url'] = $this->uploadImage($request->file('image_url'));
                } catch (\Exception $e) {
                    Log::error('Image upload failed during update: ' . $e->getMessage());
                    return back()->withErrors(['image_url' => 'Gagal mengunggah gambar.'])->withInput();
                }
            } else {
                // Keep existing image
                unset($validated['image_url']);
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $programStudi->update($validated);

            return redirect()->route('admin.program-studi.index')
                ->with('message', 'Program Studi berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating program studi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy(ProgramStudi $programStudi): RedirectResponse
    {
        try {
            // Delete associated image
            if ($programStudi->image_url) {
                $this->deleteImage($programStudi->image_url);
            }

            $programStudi->delete();

            return redirect()->route('admin.program-studi.index')
                ->with('message', 'Program Studi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting program studi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Upload image to public/storage/assets/img/program-studi/
     */
    private function uploadImage($file): string
    {
        try {
            // Create directory if not exists
            $uploadPath = public_path('storage/assets/img/program-studi');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Generate unique filename
            $extension = $file->getClientOriginalExtension();
            $filename = 'prodi_' . time() . '_' . uniqid() . '.' . $extension;

            // Move file to destination
            $file->move($uploadPath, $filename);

            // Return relative path for database storage
            return 'storage/assets/img/program-studi/' . $filename;
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            throw new \Exception('Gagal mengunggah gambar: ' . $e->getMessage());
        }
    }

    /**
     * Delete image from public directory
     */
    private function deleteImage(?string $imagePath): void
    {
        try {
            if ($imagePath) {
                $fullPath = public_path($imagePath);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
        } catch (\Exception $e) {
            Log::error('Image deletion error: ' . $e->getMessage());
            // Don't throw exception for deletion errors, just log them
        }
    }
}
