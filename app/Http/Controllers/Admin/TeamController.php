<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPosition;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::with(['position', 'programStudi'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhereHas('position', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->when($request->position_id, function ($q) use ($request) {
                $q->where('position_id', $request->position_id);
            })
            ->when($request->prodi_id, function ($q) use ($request) {
                $q->where('prodi_id', $request->prodi_id);
            })
            ->when(isset($request->is_active), function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        $positions = TeamPosition::orderBy('level')->get();
        $programStudis = ProgramStudi::active()->orderBy('name')->get();

        return Inertia::render('Admin/Team/Index', [
            'teams' => $query,
            'filters' => $request->only(['search', 'position_id', 'prodi_id', 'is_active']),
            'positions' => $positions,
            'programStudis' => $programStudis,
        ]);
    }

    public function create()
    {
        $positions = TeamPosition::orderBy('level')->get();
        $programStudis = ProgramStudi::active()->orderBy('name')->get();

        return Inertia::render('Admin/Team/Create', [
            'positions' => $positions,
            'programStudis' => $programStudis,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:team_positions,id',
            'prodi_id' => 'nullable|exists:program_studis,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education' => 'nullable|string',
            'expertise' => 'nullable|string',
            'is_active' => 'boolean',
            'order_index' => 'nullable|integer|min:0',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo_url'] = $request->file('photo')->store('teams', 'public');
        }

        // Set order_index if not provided
        if (!$request->order_index) {
            $data['order_index'] = Team::max('order_index') + 1;
        }

        Team::create($data);

        return redirect()
            ->route('admin.team.index')
            ->with('message', 'Tim berhasil ditambahkan.');
    }

    public function show(Team $team)
    {
        $team->load(['position', 'programStudi']);

        return Inertia::render('Admin/Team/Show', [
            'team' => $team,
        ]);
    }

    public function edit(Team $team)
    {
        $positions = TeamPosition::orderBy('level')->get();
        $programStudis = ProgramStudi::active()->orderBy('name')->get();

        return Inertia::render('Admin/Team/Edit', [
            'team' => $team,
            'positions' => $positions,
            'programStudis' => $programStudis,
        ]);
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:team_positions,id',
            'prodi_id' => 'nullable|exists:program_studis,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education' => 'nullable|string',
            'expertise' => 'nullable|string',
            'is_active' => 'boolean',
            'order_index' => 'nullable|integer|min:0',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($team->photo_url && Storage::disk('public')->exists($team->photo_url)) {
                Storage::disk('public')->delete($team->photo_url);
            }

            $data['photo_url'] = $request->file('photo')->store('teams', 'public');
        }

        $team->update($data);

        return redirect()
            ->route('admin.team.index')
            ->with('message', 'Tim berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        // Delete photo if exists
        if ($team->photo_url && Storage::disk('public')->exists($team->photo_url)) {
            Storage::disk('public')->delete($team->photo_url);
        }

        $team->delete();

        return redirect()
            ->route('admin.team.index')
            ->with('message', 'Tim berhasil dihapus.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'teams' => 'required|array',
            'teams.*.id' => 'required|exists:teams,id',
            'teams.*.order_index' => 'required|integer|min:0',
        ]);

        foreach ($request->teams as $teamData) {
            Team::where('id', $teamData['id'])
                ->update(['order_index' => $teamData['order_index']]);
        }

        return response()->json(['message' => 'Urutan berhasil diperbarui.']);
    }
}
