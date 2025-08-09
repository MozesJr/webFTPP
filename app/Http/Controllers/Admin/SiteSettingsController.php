<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SiteSettingsController extends Controller
{
    public function index(Request $request)
    {
        $query = SiteSetting::orderBy('group')->orderBy('key_name');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('key_name', 'like', "%{$search}%")
                    ->orWhere('value', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by group
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $settings = $query->paginate(15)->withQueryString();

        // Get unique groups for filter
        $groups = SiteSetting::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group')
            ->filter()
            ->values();

        // Get unique types for filter
        $types = SiteSetting::select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type')
            ->filter()
            ->values();

        return Inertia::render('Admin/SiteSettings/Index', [
            'settings' => $settings,
            'filters' => $request->only(['search', 'group', 'type']),
            'groups' => $groups,
            'types' => $types,
        ]);
    }

    public function create()
    {
        // Get existing groups for dropdown
        $groups = SiteSetting::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group')
            ->filter()
            ->values();

        $typeOptions = [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'email' => 'Email',
            'url' => 'URL',
            'file' => 'File',
            'number' => 'Number',
            'boolean' => 'Boolean',
            'color' => 'Color',
        ];

        return Inertia::render('Admin/SiteSettings/Create', [
            'groups' => $groups,
            'typeOptions' => $typeOptions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'key_name' => 'required|string|max:100|unique:site_settings',
            'value' => 'nullable|string',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'group' => 'required|string|max:50',
            'file_upload' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:5120', // 5MB
        ]);

        $data = $request->except(['file_upload']);

        // Handle file upload for file types
        if ($request->type === 'file' && $request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filename, 'public');
            $data['value'] = $path;
        }

        // Handle boolean conversion
        if ($request->type === 'boolean') {
            $data['value'] = $request->value ? '1' : '0';
        }

        SiteSetting::create($data);

        return redirect()->route('admin.site-settings.index')
            ->with('message', 'Pengaturan berhasil ditambahkan.');
    }

    public function show(SiteSetting $siteSetting)
    {
        return Inertia::render('Admin/SiteSettings/Show', [
            'setting' => $siteSetting,
        ]);
    }

    public function edit(SiteSetting $siteSetting)
    {
        // Get existing groups for dropdown
        $groups = SiteSetting::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group')
            ->filter()
            ->values();

        $typeOptions = [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'email' => 'Email',
            'url' => 'URL',
            'file' => 'File',
            'number' => 'Number',
            'boolean' => 'Boolean',
            'color' => 'Color',
        ];

        return Inertia::render('Admin/SiteSettings/Edit', [
            'setting' => $siteSetting,
            'groups' => $groups,
            'typeOptions' => $typeOptions,
        ]);
    }

    public function update(Request $request, SiteSetting $siteSetting)
    {
        $request->validate([
            'key_name' => 'required|string|max:100|unique:site_settings,key_name,' . $siteSetting->id,
            'value' => 'nullable|string',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'group' => 'required|string|max:50',
            'file_upload' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:5120', // 5MB
        ]);

        $data = $request->except(['file_upload']);

        // Handle file upload for file types
        if ($request->type === 'file' && $request->hasFile('file_upload')) {
            // Delete old file if exists
            if ($siteSetting->value && $siteSetting->type === 'file') {
                Storage::disk('public')->delete($siteSetting->value);
            }

            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filename, 'public');
            $data['value'] = $path;
        }

        // Handle boolean conversion
        if ($request->type === 'boolean') {
            $data['value'] = $request->value ? '1' : '0';
        }

        $siteSetting->update($data);

        return redirect()->route('admin.site-settings.index')
            ->with('message', 'Pengaturan berhasil diperbarui.');
    }

    public function destroy(SiteSetting $siteSetting)
    {
        try {
            // Delete file if exists
            if ($siteSetting->value && $siteSetting->type === 'file') {
                Storage::disk('public')->delete($siteSetting->value);
            }

            $siteSetting->delete();

            return redirect()->route('admin.site-settings.index')
                ->with('message', 'Pengaturan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.site-settings.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pengaturan.');
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.id' => 'required|exists:site_settings,id',
            'settings.*.value' => 'nullable',
        ]);

        foreach ($request->settings as $settingData) {
            $setting = SiteSetting::find($settingData['id']);

            if ($setting) {
                // Handle boolean conversion
                if ($setting->type === 'boolean') {
                    $value = isset($settingData['value']) && $settingData['value'] ? '1' : '0';
                } else {
                    $value = $settingData['value'] ?? '';
                }

                $setting->update(['value' => $value]);
            }
        }

        return redirect()->route('admin.site-settings.index')
            ->with('message', 'Pengaturan berhasil diperbarui secara bulk.');
    }

    public function getByGroup($group)
    {
        $settings = SiteSetting::where('group', $group)
            ->orderBy('key_name')
            ->get();

        return response()->json($settings);
    }

    public function getSetting($key)
    {
        $setting = SiteSetting::where('key_name', $key)->first();

        if (!$setting) {
            return response()->json(['error' => 'Setting not found'], 404);
        }

        // Format file URLs
        if ($setting->type === 'file' && $setting->value) {
            $setting->file_url = asset('storage/' . $setting->value);
        }

        return response()->json($setting);
    }
}
