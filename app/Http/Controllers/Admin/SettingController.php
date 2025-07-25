<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function index(): Response
    {
        $settings = SiteSetting::getAllGrouped();

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        foreach ($request->all() as $key => $value) {
            if ($key !== '_token' && $key !== '_method') {
                SiteSetting::set($key, $value);
            }
        }

        return redirect()->back()
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
