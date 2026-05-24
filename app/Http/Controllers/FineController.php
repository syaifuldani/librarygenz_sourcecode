<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FineController extends Controller
{
    /**
     * Redirect users to their respective fines panel based on role.
     */
    public function index(): RedirectResponse
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isLibrarian()) {
            return redirect()->route('fines.manage');
        }
        return redirect()->route('fines.history');
    }

    /**
     * Member views their personal active and historical fines.
     */
    public function history(Request $request): View
    {
        $user = Auth::user();

        // Active (unpaid) fines
        $unpaidFines = Fine::whereHas('borrowing', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'unpaid')
        ->with('borrowing.book')
        ->orderBy('created_at', 'desc')
        ->paginate(10, ['*'], 'unpaid_page')
        ->withQueryString();

        // History (paid/waived) fines
        $resolvedFines = Fine::whereHas('borrowing', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereIn('status', ['paid', 'waived'])
        ->with('borrowing.book')
        ->orderBy('updated_at', 'desc')
        ->paginate(10, ['*'], 'resolved_page')
        ->withQueryString();

        return view('fines.history', compact('unpaidFines', 'resolvedFines'));
    }

    /**
     * Librarian/Admin views all active fines, history, and admin analytics with filtering.
     */
    public function manage(Request $request): View
    {
        $user = Auth::user();

        // Run on-the-fly check just in case
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        // Analytics
        $analytics = [
            'total_unpaid' => Fine::where('status', 'unpaid')->sum('amount'),
            'total_paid' => Fine::where('status', 'paid')->sum('amount'),
            'total_waived' => Fine::where('status', 'waived')->sum('amount'),
        ];

        $unpaidQuery = Fine::with(['borrowing.book', 'borrowing.user'])->where('status', 'unpaid');
        $resolvedQuery = Fine::with(['borrowing.book', 'borrowing.user'])->whereIn('status', ['paid', 'waived']);

        // Filter by member
        if ($request->filled('member')) {
            $member = $request->member;
            $unpaidQuery->whereHas('borrowing.user', fn($q) => $q->where('name', 'like', "%{$member}%")->orWhere('email', 'like', "%{$member}%"));
            $resolvedQuery->whereHas('borrowing.user', fn($q) => $q->where('name', 'like', "%{$member}%")->orWhere('email', 'like', "%{$member}%"));
        }

        // Filter resolved by status
        if ($request->filled('resolved_status') && in_array($request->resolved_status, ['paid', 'waived'])) {
            $resolvedQuery->where('status', $request->resolved_status);
        }

        // Filter by overdue duration (late days range)
        if ($request->filled('overdue_duration')) {
            $duration = $request->overdue_duration;
            if ($duration === '1-7') {
                $unpaidQuery->whereBetween('late_days', [1, 7]);
                $resolvedQuery->whereBetween('late_days', [1, 7]);
            } elseif ($duration === '8-14') {
                $unpaidQuery->whereBetween('late_days', [8, 14]);
                $resolvedQuery->whereBetween('late_days', [8, 14]);
            } elseif ($duration === '15+') {
                $unpaidQuery->where('late_days', '>=', 15);
                $resolvedQuery->where('late_days', '>=', 15);
            }
        }

        // List of unpaid fines
        $unpaidFines = $unpaidQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'unpaid_page')->withQueryString();

        // List of resolved fines
        $resolvedFines = $resolvedQuery->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'resolved_page')->withQueryString();

        return view('fines.manage', compact('analytics', 'unpaidFines', 'resolvedFines'));
    }

    /**
     * Process fine payment.
     */
    public function pay(Fine $fine): RedirectResponse
    {
        if ($fine->status !== 'unpaid') {
            return redirect()->back()->with('error', 'Denda sudah diproses sebelumnya.');
        }

        $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        \App\Models\ActivityLog::log(
            Auth::id(),
            'fine_payment',
            "Pustakawan memproses pembayaran denda sebesar Rp" . number_format($fine->amount, 0, ',', '.') . " untuk anggota {$fine->borrowing->user->name} (Buku: '{$fine->borrowing->book->title}')."
        );

        return redirect()->back()->with('success', 'Pembayaran denda berhasil diproses!');
    }

    /**
     * Waive fine.
     */
    public function waive(Request $request, Fine $fine): RedirectResponse
    {
        if ($fine->status !== 'unpaid') {
            return redirect()->back()->with('error', 'Denda sudah diproses sebelumnya.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $fine->update([
            'status' => 'waived',
            'notes' => $request->notes ?? 'Denda dibebaskan oleh pustakawan.',
        ]);

        \App\Models\ActivityLog::log(
            Auth::id(),
            'fine_payment',
            "Pustakawan membebaskan denda sebesar Rp" . number_format($fine->amount, 0, ',', '.') . " untuk anggota {$fine->borrowing->user->name} (Buku: '{$fine->borrowing->book->title}'). Alasan: " . ($request->notes ?? 'Denda dibebaskan oleh pustakawan.')
        );

        return redirect()->back()->with('success', 'Denda berhasil dibebaskan!');
    }
}
