<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Pick;
use App\Models\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function index(): View
    {
        return view('modules.index', [
            'stats' => [
                'picks' => Pick::count(),
                'support_tickets' => SupportTicket::count(),
                'contests' => Contest::count(),
            ],
        ]);
    }

    public function tickets(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        return view('modules.tickets', [
            'tickets' => SupportTicket::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query
                        ->where('subject', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%");
                })
                ->orderByDesc('id')
                ->paginate(10)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function contests(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        return view('modules.contests', [
            'contests' => Contest::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('contest_type', 'like', "%{$search}%");
                })
                ->orderByDesc('id')
                ->paginate(10)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function updateTicketStatus(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,pending,resolved,closed'],
        ]);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('modules.tickets', $request->only('q', 'page'))
            ->with('status', "Ticket #{$ticket->id} status updated.");
    }

    public function updateContestStatus(Request $request, Contest $contest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,active,paused,inactive,completed'],
        ]);

        $contest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('modules.contests', $request->only('q', 'page'))
            ->with('status', "Contest #{$contest->id} status updated.");
    }
}
