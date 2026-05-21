<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExpertController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $experts = Expert::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('specialty', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.experts.index', [
            'experts' => $experts,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.experts.form', [
            'expert' => new Expert(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'specialty' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/experts', 'public');
            $validated['avatar'] = $path;
        }

        Expert::create($validated);

        return redirect()->route('admin.experts.index')->with('success', 'Expert created successfully.');
    }

    public function edit(Expert $expert): View
    {
        return view('admin.experts.form', [
            'expert' => $expert,
        ]);
    }

    public function update(Request $request, Expert $expert): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'specialty' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($expert->avatar) {
                Storage::disk('public')->delete($expert->avatar);
            }
            $path = $request->file('avatar')->store('uploads/experts', 'public');
            $validated['avatar'] = $path;
        }

        $expert->update($validated);

        return redirect()->route('admin.experts.index')->with('success', 'Expert updated successfully.');
    }

    public function destroy(Expert $expert): RedirectResponse
    {
        $expert->delete();

        return redirect()->route('admin.experts.index')->with('success', 'Expert deleted successfully.');
    }
}
