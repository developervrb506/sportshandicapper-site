<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhalePackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhalePackageController extends Controller
{
    public function index(): View
    {
        $packages = WhalePackage::orderBy('sort_order')->get();
        return view('admin.whale-packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('admin.whale-packages.form', ['package' => new WhalePackage()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:50'],
            'duration_days' => ['nullable', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['features'] = $validated['features'] ? array_filter(array_map('trim', explode("\n", $validated['features']))) : [];
        $validated['is_active'] = $request->boolean('is_active');

        WhalePackage::create($validated);

        return redirect()->route('admin.whale-packages.index')->with('success', 'Whale package created.');
    }

    public function edit(WhalePackage $whalePackage): View
    {
        return view('admin.whale-packages.form', ['package' => $whalePackage]);
    }

    public function update(Request $request, WhalePackage $whalePackage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:50'],
            'duration_days' => ['nullable', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['features'] = $validated['features'] ? array_filter(array_map('trim', explode("\n", $validated['features']))) : [];
        $validated['is_active'] = $request->boolean('is_active');

        $whalePackage->update($validated);

        return redirect()->route('admin.whale-packages.index')->with('success', 'Whale package updated.');
    }

    public function destroy(WhalePackage $whalePackage): RedirectResponse
    {
        $whalePackage->delete();
        return redirect()->route('admin.whale-packages.index')->with('success', 'Whale package deleted.');
    }
}
