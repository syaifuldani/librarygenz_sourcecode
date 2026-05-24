<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportExportController extends Controller
{
    /**
     * Export borrowings report as PDF.
     */
    public function borrowings(Request $request)
    {
        $this->authorizeExport();

        $query = Borrowing::with(['user', 'book.category', 'fine'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $borrowings = $query->get();

        ActivityLog::log(
            Auth::id(),
            'export',
            "Pengguna " . Auth::user()->name . " mengekspor laporan peminjaman (" . $borrowings->count() . " data) ke PDF."
        );

        $pdf = Pdf::loadView('reports.pdf.borrowings', [
            'borrowings' => $borrowings,
            'generatedAt' => now(),
            'generatedBy' => Auth::user()->name,
            'filters' => $request->only(['status', 'date_from', 'date_to']),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export fines report as PDF.
     */
    public function fines(Request $request)
    {
        $this->authorizeExport();

        $query = Fine::with(['borrowing.user', 'borrowing.book'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fines = $query->get();

        ActivityLog::log(
            Auth::id(),
            'export',
            "Pengguna " . Auth::user()->name . " mengekspor laporan denda (" . $fines->count() . " data) ke PDF."
        );

        $pdf = Pdf::loadView('reports.pdf.fines', [
            'fines' => $fines,
            'generatedAt' => now(),
            'generatedBy' => Auth::user()->name,
            'totalUnpaid' => Fine::where('status', 'unpaid')->sum('amount'),
            'totalPaid' => Fine::where('status', 'paid')->sum('amount'),
            'totalWaived' => Fine::where('status', 'waived')->sum('amount'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-denda-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export users report as PDF.
     */
    public function users(Request $request)
    {
        $this->authorizeExport();

        $query = User::with('role')->orderBy('created_at', 'desc');

        if ($request->filled('role')) {
            $query->whereHas('role', fn($q) => $q->where('name', $request->role));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('reg_from')) {
            $query->whereDate('created_at', '>=', $request->reg_from);
        }

        if ($request->filled('reg_to')) {
            $query->whereDate('created_at', '<=', $request->reg_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        ActivityLog::log(
            Auth::id(),
            'export',
            "Pengguna " . Auth::user()->name . " mengekspor daftar pengguna (" . $users->count() . " data) ke PDF."
        );

        $pdf = Pdf::loadView('reports.pdf.users', [
            'users' => $users,
            'generatedAt' => now(),
            'generatedBy' => Auth::user()->name,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('daftar-pengguna-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export books catalog as PDF.
     */
    public function books(Request $request)
    {
        $this->authorizeExport();

        $query = Book::with('category')->orderBy('title');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->availability === 'unavailable') {
                $query->where('stock', 0);
            }
        }

        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', (int) $request->stock_min);
        }

        $books = $query->get();

        ActivityLog::log(
            Auth::id(),
            'export',
            "Pengguna " . Auth::user()->name . " mengekspor katalog buku (" . $books->count() . " data) ke PDF."
        );

        $pdf = Pdf::loadView('reports.pdf.books', [
            'books' => $books,
            'generatedAt' => now(),
            'generatedBy' => Auth::user()->name,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('katalog-buku-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export dashboard statistics as PDF.
     */
    public function statistics()
    {
        $this->authorizeExport();

        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'total_borrowings' => Borrowing::count(),
            'active_borrowings' => Borrowing::whereIn('status', ['borrowed', 'overdue'])->count(),
            'overdue_borrowings' => Borrowing::where('status', 'overdue')->count(),
            'total_fines_unpaid' => Fine::where('status', 'unpaid')->sum('amount'),
            'total_fines_paid' => Fine::where('status', 'paid')->sum('amount'),
            'total_fines_waived' => Fine::where('status', 'waived')->sum('amount'),
            'most_borrowed' => Book::withCount('borrowings')->orderBy('borrowings_count', 'desc')->take(10)->get(),
            'recent_borrowings' => Borrowing::with(['user', 'book'])->orderBy('created_at', 'desc')->take(10)->get(),
        ];

        ActivityLog::log(
            Auth::id(),
            'export',
            "Pengguna " . Auth::user()->name . " mengekspor laporan statistik dashboard ke PDF."
        );

        $pdf = Pdf::loadView('reports.pdf.statistics', [
            'stats' => $stats,
            'generatedAt' => now(),
            'generatedBy' => Auth::user()->name,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('statistik-dashboard-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Authorize export access (Admin & Librarian only).
     */
    private function authorizeExport(): void
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isLibrarian()) {
            abort(403, 'Akses ditolak. Hanya Admin dan Pustakawan yang dapat mengekspor laporan.');
        }
    }
}
