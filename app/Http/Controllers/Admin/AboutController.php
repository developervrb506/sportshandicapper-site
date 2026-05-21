<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function edit(): View
    {
        return view('admin.about.edit', [
            'aboutContent' => SiteSetting::get('about_content', ''),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'about_content' => ['nullable', 'string'],
        ]);

        SiteSetting::set('about_content', $request->input('about_content', ''));

        return redirect()->route('admin.about.edit')->with('success', 'About Us page updated successfully.');
    }
}
