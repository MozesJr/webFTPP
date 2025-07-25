<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use App\Http\Requests\StoreProgramStudiRequest;
use App\Http\Requests\UpdateProgramStudiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProgramStudiController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ProgramStudi::with(['kurikulums', 'teams']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->degree_level) {
            $query->where('degree_level', $request->degree_level);
        }

        $programStudis = $query->latest()->paginate(10);

        return Inertia::render('Admin/ProgramStudi/Index', [
            'programStudis' => $programStudis,
            'filters' => $request->only(['search', 'degree_level'])
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ProgramStudi/Create');
    }

    public function store(StoreProgramStudiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('program-studi', 'public');
        }

        ProgramStudi::create($data);

        return redirect()->route('admin.program-studi.index')
            ->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function show(ProgramStudi $programStudi): Response
    {
        $programStudi->load([
            'kurikulums.mataKuliahs',
            'teams.position',
            'features',
            'testimonials'
        ]);

        return Inertia::render('Admin/ProgramStudi/Show', [
            'programStudi' => $programStudi
        ]);
    }

    public function edit(ProgramStudi $programStudi): Response
    {
        return Inertia::render('Admin/ProgramStudi/Edit', [
            'programStudi' => $programStudi
        ]);
    }

    public function update(UpdateProgramStudiRequest $request, ProgramStudi $programStudi): RedirectResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('program-studi', 'public');
        }

        $programStudi->update($data);

        return redirect()->route('admin.program-studi.index')
            ->with('success', 'Program Studi berhasil diupdate.');
    }

    public function destroy(ProgramStudi $programStudi): RedirectResponse
    {
        $programStudi->delete();

        return redirect()->route('admin.program-studi.index')
            ->with('success', 'Program Studi berhasil dihapus.');
    }
}
