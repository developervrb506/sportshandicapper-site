<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContestController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $statusFilter = $request->query('status', '');

        $contests = Contest::query()
            ->when($search !== '', function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('contest_type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($statusFilter !== '', function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('contests.index', [
            'contests' => $contests,
            'search' => $search,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function create(): View
    {
        return view('contests.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contest_type' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'status' => ['required', 'in:draft,active,paused,inactive,completed'],
        ]);

        Contest::create($validated);

        return redirect()->route('contests.index')->with('success', 'Contest created successfully.');
    }

    public function show(Contest $contest): View
    {
        return view('contests.show', [
            'contest' => $contest,
        ]);
    }

    public function edit(Contest $contest): View
    {
        return view('contests.edit', [
            'contest' => $contest,
        ]);
    }

    public function update(Request $request, Contest $contest): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contest_type' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'status' => ['required', 'in:draft,active,paused,inactive,completed'],
        ]);

        $contest->update($validated);

        return redirect()->route('contests.show', $contest)->with('success', 'Contest updated successfully.');
    }

    public function destroy(Contest $contest): RedirectResponse
    {
        $contest->delete();

        return redirect()->route('contests.index')->with('success', 'Contest deleted successfully.');
    }
}
