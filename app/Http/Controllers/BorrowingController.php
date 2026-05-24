<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Redirect users to their respective borrowing panel based on role.
     */
    public function index(): RedirectResponse
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isLibrarian()) {
            return redirect()->route('borrowings.manage');
        }
        return redirect()->route('borrowings.history');
    }

    /**
     * Member requests to borrow a book.
     */
    public function requestBorrow(Book $book): RedirectResponse
    {
        $user = Auth::user();

        // 1. Stock check
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Buku sedang tidak tersedia (stok habis).');
        }

        // 2. Active borrowing redundancy check
        $hasActiveBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['requested', 'approved', 'borrowed', 'overdue'])
            ->exists();

        if ($hasActiveBorrowing) {
            return redirect()->back()->with('error', 'Anda masih memiliki permohonan atau peminjaman aktif untuk buku ini.');
        }

        // 3. Max active loans/requests limit check (maximum 3)
        $activeCount = Borrowing::where('user_id', $user->id)
            ->whereIn('status', ['requested', 'approved', 'borrowed', 'overdue'])
            ->count();

        if ($activeCount >= 3) {
            return redirect()->back()->with('error', 'Batas maksimal peminjaman aktif adalah 3 buku. Selesaikan peminjaman Anda saat ini terlebih dahulu.');
        }

        // 4. Create requested borrowing
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'requested',
        ]);

        \App\Models\ActivityLog::log(
            $user->id,
            'borrow_request',
            "Anggota {$user->name} mengajukan peminjaman buku: '{$book->title}'."
        );

        return redirect()->route('borrowings.history')->with('success', 'Permintaan peminjaman berhasil diajukan! Menunggu persetujuan pustakawan.');
    }

    /**
     * Member cancels their own pending borrowing request.
     */
    public function cancel(Borrowing $borrowing): RedirectResponse
    {
        // Safety check
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowing->status !== 'requested') {
            return redirect()->back()->with('error', 'Permintaan tidak dapat dibatalkan karena sudah diproses.');
        }

        $borrowing->delete();
        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil dibatalkan.');
    }

    /**
     * Member views their borrowing history with filtering.
     */
    public function history(Request $request): View
    {
        $query = Borrowing::with('book.category')
            ->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('borrowings.history', compact('borrowings'));
    }

    /**
     * Librarian/Admin manages requests and active loans with filtering.
     */
    public function manage(Request $request): View
    {
        // On-the-fly overdue check for active loans
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        $pendingQuery = Borrowing::with(['user', 'book'])->where('status', 'requested');
        $activeQuery = Borrowing::with(['user', 'book'])->whereIn('status', ['approved', 'borrowed', 'overdue']);
        $pastQuery = Borrowing::with(['user', 'book'])->whereIn('status', ['returned', 'rejected']);

        // Filter by member name/email
        if ($request->filled('member')) {
            $member = $request->member;
            $pendingQuery->whereHas('user', fn($q) => $q->where('name', 'like', "%{$member}%")->orWhere('email', 'like', "%{$member}%"));
            $activeQuery->whereHas('user', fn($q) => $q->where('name', 'like', "%{$member}%")->orWhere('email', 'like', "%{$member}%"));
            $pastQuery->whereHas('user', fn($q) => $q->where('name', 'like', "%{$member}%")->orWhere('email', 'like', "%{$member}%"));
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $pendingQuery->whereDate('created_at', '>=', $request->date_from);
            $activeQuery->whereDate('created_at', '>=', $request->date_from);
            $pastQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $pendingQuery->whereDate('created_at', '<=', $request->date_to);
            $activeQuery->whereDate('created_at', '<=', $request->date_to);
            $pastQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'requested') {
                $activeQuery->whereRaw('1 = 0');
                $pastQuery->whereRaw('1 = 0');
            } elseif (in_array($status, ['approved', 'borrowed', 'overdue'])) {
                $pendingQuery->whereRaw('1 = 0');
                $activeQuery->where('status', $status);
                $pastQuery->whereRaw('1 = 0');
            } elseif (in_array($status, ['returned', 'rejected'])) {
                $pendingQuery->whereRaw('1 = 0');
                $activeQuery->whereRaw('1 = 0');
                $pastQuery->where('status', $status);
            }
        }

        $pendingRequests = $pendingQuery->orderBy('created_at', 'asc')->paginate(10, ['*'], 'pending_page')->withQueryString();
        $activeLoans = $activeQuery->orderBy('due_date', 'asc')->paginate(10, ['*'], 'active_page')->withQueryString();
        $pastLogs = $pastQuery->orderBy('updated_at', 'desc')->paginate(10, ['*'], 'past_page')->withQueryString();

        return view('borrowings.manage', compact('pendingRequests', 'activeLoans', 'pastLogs'));
    }

    /**
     * Librarian approves a borrowing request.
     */
    public function approve(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'requested') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $book = $borrowing->book;

        // Stock check
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Persetujuan gagal. Stok buku sudah habis.');
        }

        // Decrement stock upon approval
        $book->decrement('stock');

        $borrowing->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
        ]);

        \App\Models\ActivityLog::log(
            Auth::id(),
            'approval',
            "Pustakawan menyetujui peminjaman buku '{$borrowing->book->title}' untuk anggota {$borrowing->user->name}."
        );

        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil disetujui!');
    }

    /**
     * Librarian rejects a borrowing request.
     */
    public function reject(Request $request, Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'requested') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $borrowing->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'notes' => $request->notes ?? 'Ditolak oleh pustakawan.',
        ]);

        \App\Models\ActivityLog::log(
            Auth::id(),
            'approval',
            "Pustakawan menolak peminjaman buku '{$borrowing->book->title}' untuk anggota {$borrowing->user->name}. Catatan: " . ($request->notes ?? 'Ditolak oleh pustakawan.')
        );

        return redirect()->back()->with('success', 'Permintaan peminjaman ditolak.');
    }

    /**
     * Librarian marks request as borrowed (member picks up physical book).
     */
    public function markAsBorrowed(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'approved') {
            return redirect()->back()->with('error', 'Buku belum disetujui untuk diambil.');
        }

        // Sets borrow date to now, and due date to now + 7 days
        $borrowing->update([
            'status' => 'borrowed',
            'borrow_date' => today(),
            'due_date' => today()->addDays(7),
        ]);

        \App\Models\ActivityLog::log(
            Auth::id(),
            'approval',
            "Pustakawan menyerahkan buku fisik '{$borrowing->book->title}' kepada anggota {$borrowing->user->name}."
        );

        return redirect()->back()->with('success', 'Buku berhasil diserahkan kepada anggota! Batas waktu pengembalian diatur 7 hari.');
    }

    /**
     * Librarian marks active loan as returned.
     */
    public function markAsReturned(Borrowing $borrowing): RedirectResponse
    {
        if (!in_array($borrowing->status, ['borrowed', 'overdue'])) {
            return redirect()->back()->with('error', 'Peminjaman tidak dalam status aktif.');
        }

        // Increment stock back
        $borrowing->book->increment('stock');

        $returnDate = today();
        $dueDate = $borrowing->due_date ? \Carbon\Carbon::parse($borrowing->due_date)->startOfDay() : null;
        $fineMsg = '';

        if ($dueDate && $returnDate->greaterThan($dueDate)) {
            $lateDays = (int) abs($returnDate->diffInDays($dueDate));
            if ($lateDays > 0) {
                $amount = $lateDays * 2000;
                $borrowing->fine()->create([
                    'late_days' => $lateDays,
                    'amount' => $amount,
                    'status' => 'unpaid',
                ]);
                $fineMsg = ' Terlambat ' . $lateDays . ' hari. Denda Rp' . number_format($amount, 0, ',', '.') . ' otomatis dibuat.';
            }
        }






        $borrowing->update([
            'status' => 'returned',
            'return_date' => $returnDate,
        ]);

        \App\Models\ActivityLog::log(
            Auth::id(),
            'return',
            "Pustakawan memverifikasi pengembalian buku '{$borrowing->book->title}' dari anggota {$borrowing->user->name}." . ($fineMsg ? " Denda dihasilkan." : "")
        );

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan! Stok buku telah ditambahkan.' . $fineMsg);
    }

    /**
     * Librarian/Admin views list of overdue borrowings.
     */
    public function overdue(): View
    {
        // On-the-fly check
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        $overdueBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'overdue')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('borrowings.overdue', compact('overdueBorrowings'));
    }
}

