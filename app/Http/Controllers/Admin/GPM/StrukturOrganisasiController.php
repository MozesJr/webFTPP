<?php

namespace App\Http\Controllers\Admin\GPM;

use App\Http\Controllers\Controller;
use App\Models\GPM\StrukturOrganisasi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StrukturOrganisasi::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan', 'like', "%{$request->jabatan}%");
        }

        // Order
        $query->ordered();

        $strukturOrganisasi = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/GPM/StrukturOrganisasi/Index', [
            'strukturOrganisasi' => $strukturOrganisasi,
            'filters' => $request->only(['search', 'status', 'jabatan']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/GPM/StrukturOrganisasi/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'tugas_fungsi' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Gambar harus berformat: jpeg, jpg, png, gif.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Auto set order
        if (!isset($validated['order'])) {
            $validated['order'] = StrukturOrganisasi::max('order') + 1;
        }

        StrukturOrganisasi::create($validated);

        return redirect()
            ->route('admin.gpm.struktur-organisasi.index')
            ->with('success', 'Data anggota GPM berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrukturOrganisasi $strukturOrganisasi)
    {
        return Inertia::render('Admin/GPM/StrukturOrganisasi/Edit', [
            'strukturOrganisasi' => $strukturOrganisasi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StrukturOrganisasi $strukturOrganisasi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'tugas_fungsi' => 'nullable|string',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Gambar harus berformat: jpeg, jpg, png, gif.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Upload new photo
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($strukturOrganisasi->photo) {
                $this->deletePhoto($strukturOrganisasi->photo);
            }
            $validated['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        $strukturOrganisasi->update($validated);

        return redirect()
            ->route('admin.gpm.struktur-organisasi.index')
            ->with('success', 'Data anggota GPM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StrukturOrganisasi $strukturOrganisasi)
    {
        // Delete photo
        if ($strukturOrganisasi->photo) {
            $this->deletePhoto($strukturOrganisasi->photo);
        }

        $strukturOrganisasi->delete();

        return redirect()
            ->route('admin.gpm.struktur-organisasi.index')
            ->with('success', 'Data anggota GPM berhasil dihapus.');
    }

    /**
     * Update the order of resources.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:gpm_struktur_organisasi,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($validated['items'] as $item) {
            StrukturOrganisasi::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json([
            'message' => 'Urutan berhasil diperbarui.',
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(StrukturOrganisasi $strukturOrganisasi)
    {
        $strukturOrganisasi->update([
            'is_active' => !$strukturOrganisasi->is_active,
        ]);

        $status = $strukturOrganisasi->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Anggota berhasil {$status}.");
    }

    /**
     * Upload photo.
     */
    private function uploadPhoto($file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('assets/gpm/struktur', $filename, 'public');

        return 'storage/' . $path;
    }

    /**
     * Delete photo.
     */
    private function deletePhoto(string $path): void
    {
        $storagePath = str_replace('storage/', '', $path);

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }
}
