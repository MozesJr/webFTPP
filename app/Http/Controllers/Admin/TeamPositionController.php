<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamPosition;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamPositionController extends Controller
{
    public function index(Request $request)
    {
        $query = TeamPosition::withCount('teams')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->when($request->level, function ($q) use ($request) {
                $q->where('level', $request->level);
            })
            ->orderBy('level')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/TeamPosition/Index', [
            'positions' => $query,
            'filters' => $request->only(['search', 'level']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/TeamPosition/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:team_positions,name',
            'level' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string|max:1000',
        ]);

        TeamPosition::create($request->all());

        return redirect()
            ->route('admin.team-position.index')
            ->with('message', 'Posisi tim berhasil ditambahkan.');
    }

    public function show(TeamPosition $teamPosition)
    {
        $teamPosition->loadCount('teams');
        $teamPosition->load(['teams' => function ($query) {
            $query->with('programStudi')->orderBy('order_index');
        }]);

        return Inertia::render('Admin/TeamPosition/Show', [
            'position' => $teamPosition,
        ]);
    }

    public function edit(TeamPosition $teamPosition)
    {
        return Inertia::render('Admin/TeamPosition/Edit', [
            'position' => $teamPosition,
        ]);
    }

    public function update(Request $request, TeamPosition $teamPosition)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:team_positions,name,' . $teamPosition->id,
            'level' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string|max:1000',
        ]);

        $teamPosition->update($request->all());

        return redirect()
            ->route('admin.team-position.index')
            ->with('message', 'Posisi tim berhasil diperbarui.');
    }

    public function destroy(TeamPosition $teamPosition)
    {
        // Check if position has teams
        if ($teamPosition->teams()->count() > 0) {
            return redirect()
                ->route('admin.team-position.index')
                ->with('error', 'Posisi tidak dapat dihapus karena masih memiliki anggota tim.');
        }

        $teamPosition->delete();

        return redirect()
            ->route('admin.team-position.index')
            ->with('message', 'Posisi tim berhasil dihapus.');
    }
}
