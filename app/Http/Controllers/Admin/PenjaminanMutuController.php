<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenjaminanMutu;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PenjaminanMutuController extends Controller
{
    public function index(Request $request)
    {
        $query = PenjaminanMutu::with('programStudi')
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('document_type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('programStudi', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by program studi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter by document type
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $penjaminanMutus = $query->paginate(10)->withQueryString();

        // Get program studi for filter options
        $programStudis = ProgramStudi::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Document types for filter (sesuai dengan ENUM di database)
        $documentTypes = [
            'borang_akreditasi' => 'Borang Akreditasi',
            'evaluasi_diri' => 'Evaluasi Diri',
            'sop' => 'Standard Operating Procedure',
            'panduan' => 'Panduan',
            'laporan_penjaminan_mutu' => 'Laporan Penjaminan Mutu'
        ];

        // Status options for filter (sesuai dengan ENUM di database)
        $statusOptions = [
            'draft' => 'Draft',
            'active' => 'Active',
            'obsolete' => 'Obsolete'
        ];

        return Inertia::render('Admin/PenjaminanMutu/Index', [
            'penjaminanMutus' => $penjaminanMutus,
            'filters' => $request->only(['search', 'prodi_id', 'document_type', 'status']),
            'programStudis' => $programStudis,
            'documentTypes' => $documentTypes,
            'statusOptions' => $statusOptions,
        ]);
    }

    public function create()
    {
        $programStudis = ProgramStudi::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $documentTypes = [
            'borang_akreditasi' => 'Borang Akreditasi',
            'evaluasi_diri' => 'Evaluasi Diri',
            'sop' => 'Standard Operating Procedure',
            'panduan' => 'Panduan',
            'laporan_penjaminan_mutu' => 'Laporan Penjaminan Mutu'
        ];

        $statusOptions = [
            'draft' => 'Draft',
            'active' => 'Active',
            'obsolete' => 'Obsolete'
        ];

        return Inertia::render('Admin/PenjaminanMutu/Create', [
            'programStudis' => $programStudis,
            'documentTypes' => $documentTypes,
            'statusOptions' => $statusOptions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prodi_id' => 'required|exists:program_studis,id',
            'document_type' => 'required|in:borang_akreditasi,evaluasi_diri,sop,panduan,laporan_penjaminan_mutu',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'version' => 'required|string|max:20',
            'effective_date' => 'required|date',
            'review_date' => 'nullable|date',
            'status' => 'required|in:draft,active,obsolete',
            'approved_by' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['document_file']);
        $data['created_by'] = auth()->user()->name;

        // Handle file upload
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents/penjaminan-mutu', $filename, 'public');
            $data['document_url'] = $path;
        }

        // Set approved_at if status is active
        if ($request->status === 'active' && $request->approved_by) {
            $data['approved_at'] = now();
        }

        PenjaminanMutu::create($data);

        return redirect()->route('admin.penjaminan-mutu.index')
            ->with('message', 'Dokumen Penjaminan Mutu berhasil ditambahkan.');
    }

    public function show(PenjaminanMutu $penjaminanMutu)
    {
        $penjaminanMutu->load('programStudi');

        return Inertia::render('Admin/PenjaminanMutu/Show', [
            'penjaminanMutu' => $penjaminanMutu,
        ]);
    }

    public function edit(PenjaminanMutu $penjaminanMutu)
    {
        $penjaminanMutu->load('programStudi');

        $programStudis = ProgramStudi::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $documentTypes = [
            'borang_akreditasi' => 'Borang Akreditasi',
            'evaluasi_diri' => 'Evaluasi Diri',
            'sop' => 'Standard Operating Procedure',
            'panduan' => 'Panduan',
            'laporan_penjaminan_mutu' => 'Laporan Penjaminan Mutu'
        ];

        $statusOptions = [
            'draft' => 'Draft',
            'active' => 'Active',
            'obsolete' => 'Obsolete'
        ];

        return Inertia::render('Admin/PenjaminanMutu/Edit', [
            'penjaminanMutu' => $penjaminanMutu,
            'programStudis' => $programStudis,
            'documentTypes' => $documentTypes,
            'statusOptions' => $statusOptions,
        ]);
    }

    public function update(Request $request, PenjaminanMutu $penjaminanMutu)
    {
        $request->validate([
            'prodi_id' => 'required|exists:program_studis,id',
            'document_type' => 'required|in:borang_akreditasi,evaluasi_diri,sop,panduan,laporan_penjaminan_mutu',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'version' => 'required|string|max:20',
            'effective_date' => 'required|date',
            'review_date' => 'nullable|date',
            'status' => 'required|in:draft,active,obsolete',
            'approved_by' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['document_file']);

        // Handle file upload
        if ($request->hasFile('document_file')) {
            // Delete old file if exists
            if ($penjaminanMutu->document_url) {
                $oldPath = str_replace('storage/', '', parse_url($penjaminanMutu->document_url, PHP_URL_PATH));
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('document_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents/penjaminan-mutu', $filename, 'public');
            $data['document_url'] = $path;
        }

        // Set approved_at if status changed to active
        if ($request->status === 'active' && $request->approved_by && $penjaminanMutu->status !== 'active') {
            $data['approved_at'] = now();
        } elseif ($request->status !== 'active') {
            $data['approved_at'] = null;
        }

        $penjaminanMutu->update($data);

        return redirect()->route('admin.penjaminan-mutu.index')
            ->with('message', 'Dokumen Penjaminan Mutu berhasil diperbarui.');
    }

    public function destroy(PenjaminanMutu $penjaminanMutu)
    {
        try {
            // Delete file if exists
            if ($penjaminanMutu->document_url) {
                $path = str_replace('storage/', '', parse_url($penjaminanMutu->document_url, PHP_URL_PATH));
                Storage::disk('public')->delete($path);
            }

            $penjaminanMutu->delete();

            return redirect()->route('admin.penjaminan-mutu.index')
                ->with('message', 'Dokumen Penjaminan Mutu berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.penjaminan-mutu.index')
                ->with('error', 'Terjadi kesalahan saat menghapus dokumen.');
        }
    }

    public function download(PenjaminanMutu $penjaminanMutu)
    {
        if (!$penjaminanMutu->document_url) {
            return redirect()->back()->with('error', 'File tidak tersedia.');
        }

        $path = str_replace('storage/', '', parse_url($penjaminanMutu->document_url, PHP_URL_PATH));

        if (!Storage::disk('public')->exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($path, $penjaminanMutu->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}
