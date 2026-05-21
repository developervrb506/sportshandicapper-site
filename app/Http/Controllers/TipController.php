<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $tips = Tip::query()
            ->when($search !== '', function ($query) use ($search) {
                $query
                    ->where('tip_title', 'like', "%{$search}%")
                    ->orWhere('group_name', 'like', "%{$search}%")
                    ->orWhere('expert_name', 'like', "%{$search}%");
            })
            ->orderByDesc('display_date')
            ->paginate(15)
            ->withQueryString();

        return view('modules.tips.index', [
            'tips' => $tips,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('modules.tips.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tip_title' => ['required', 'string', 'max:255'],
            'tip_text' => ['nullable', 'string'],
            'group_name' => ['nullable', 'string', 'max:50'],
            'expert_name' => ['nullable', 'string', 'max:255'],
            'matchup' => ['nullable', 'string', 'max:255'],
            'confidence' => ['nullable', 'integer', 'min:1', 'max:5'],
            'result' => ['nullable', 'string', 'in:win,loss,push,pending'],
            'analysis' => ['nullable', 'string'],
            'display_yearly' => ['nullable', 'boolean'],
            'display_date' => ['nullable', 'date'],
            'shown_date' => ['nullable', 'date'],
            'display_day' => ['nullable', 'integer', 'between:0,31'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['display_yearly'] = $request->boolean('display_yearly');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['added_date'] = now()->toDateString();

        Tip::create($validated);

        return redirect()
            ->route('modules.tips.index')
            ->with('status', 'Pick created successfully.');
    }

    public function edit(Tip $tip): View
    {
        return view('modules.tips.edit', [
            'tip' => $tip,
        ]);
    }

    public function update(Request $request, Tip $tip): RedirectResponse
    {
        $validated = $request->validate([
            'tip_title' => ['required', 'string', 'max:255'],
            'tip_text' => ['nullable', 'string'],
            'group_name' => ['nullable', 'string', 'max:50'],
            'expert_name' => ['nullable', 'string', 'max:255'],
            'matchup' => ['nullable', 'string', 'max:255'],
            'confidence' => ['nullable', 'integer', 'min:1', 'max:5'],
            'result' => ['nullable', 'string', 'in:win,loss,push,pending'],
            'analysis' => ['nullable', 'string'],
            'display_yearly' => ['nullable', 'boolean'],
            'display_date' => ['nullable', 'date'],
            'shown_date' => ['nullable', 'date'],
            'display_day' => ['nullable', 'integer', 'between:0,31'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['display_yearly'] = $request->boolean('display_yearly');
        $validated['is_active'] = $request->boolean('is_active');

        $tip->update($validated);

        return redirect()
            ->route('modules.tips.index')
            ->with('status', 'Pick updated successfully.');
    }

    public function destroy(Tip $tip): RedirectResponse
    {
        $tip->delete();

        return redirect()
            ->route('modules.tips.index')
            ->with('status', 'Pick deleted successfully.');
    }
}
