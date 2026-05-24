<?php

namespace App\Services;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get statistics for the Admin Dashboard.
     */
    public function getAdminStats(): array
    {
        // Run on-the-fly overdue check first
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        $totalUsers = User::count();
        $totalLibrarians = User::whereHas('role', function ($query) {
            $query->where('name', 'librarian');
        })->count();
        $totalMembers = User::whereHas('role', function ($query) {
            $query->where('name', 'member');
        })->count();
        $totalActivityLogs = ActivityLog::count();
        
        $recentUsers = User::with('role')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Server stats
        $dbDriver = DB::connection()->getDriverName();
        $dbEngine = match ($dbDriver) {
            'sqlite' => 'SQLite (' . (DB::select('select sqlite_version() as version')[0]->version ?? 'unknown') . ')',
            'mysql' => 'MySQL (' . (DB::select('select version() as version')[0]->version ?? 'unknown') . ')',
            default => ucfirst($dbDriver)
        };

        $serverStats = [
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'db_engine' => $dbEngine,
        ];

        return [
            'total_users' => $totalUsers,
            'total_librarians' => $totalLibrarians,
            'total_members' => $totalMembers,
            'total_activity_logs' => $totalActivityLogs,
            'active_fine_rate' => 2000,
            'total_reports_available' => 4,
            'server_stats' => $serverStats,
            'recent_users' => $recentUsers,
        ];
    }

    /**
     * Get statistics for the Librarian Dashboard.
     */
    public function getLibrarianStats(): array
    {
        // Run on-the-fly overdue check first
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        $totalBooks = Book::count();
        $pendingApproval = Borrowing::where('status', 'requested')->count();
        $overdueBooks = Borrowing::where('status', 'overdue')->count();
        $totalFinesProcessed = Fine::whereIn('status', ['paid', 'waived'])->sum('amount');

        $pendingQueue = Borrowing::with(['user', 'book'])
            ->where('status', 'requested')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->whereIn('activity_type', ['borrow_request', 'approval', 'return', 'fine_payment'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return [
            'total_books' => $totalBooks,
            'pending_approval' => $pendingApproval,
            'overdue_books' => $overdueBooks,
            'total_fines_processed' => $totalFinesProcessed,
            'pending_queue' => $pendingQueue,
            'recent_activities' => $recentActivities,
            'late_fine_rules' => 2000,
        ];
    }

    /**
     * Get statistics for a specific Member.
     */
    public function getMemberStats(int $userId): array
    {
        // Run on-the-fly overdue check first
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        $catalogAvailable = Book::where('stock', '>', 0)->count();
        $booksBorrowed = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->count();
        $completedHistory = Borrowing::where('user_id', $userId)
            ->where('status', 'returned')
            ->count();

        $activeFinesUnpaid = Fine::whereHas('borrowing', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where('status', 'unpaid')
        ->sum('amount');

        $activeBorrowings = Borrowing::with('book')
            ->where('user_id', $userId)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->get();

        return [
            'catalog_available' => $catalogAvailable,
            'books_borrowed' => $booksBorrowed,
            'completed_history' => $completedHistory,
            'active_fines_unpaid' => $activeFinesUnpaid,
            'active_borrowings' => $activeBorrowings,
        ];
    }

    /**
     * Get data for Reports.
     */
    public function getReports(): array
    {
        // Run on-the-fly overdue check first
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', today())
            ->update(['status' => 'overdue']);

        // 1. Borrowing Trend (Database Agnostic Collection Grouping)
        $lastYear = now()->subMonths(12)->startOfMonth();
        $trendData = Borrowing::where('created_at', '>=', $lastYear)
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function ($borrowing) {
                return Carbon::parse($borrowing->created_at)->translatedFormat('F Y');
            })
            ->map(function ($group) {
                return $group->count();
            });

        // 2. Most Borrowed Books
        $mostBorrowed = Book::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->take(5)
            ->get();

        // 3. Overdue Statistics
        $totalOverdue = Borrowing::where('status', 'overdue')->count();
        $totalUnpaidFines = Fine::where('status', 'unpaid')->sum('amount');
        $averageLateDays = round(Fine::avg('late_days') ?? 0, 1);

        // 4. Most Active Members
        $activeMembers = User::whereHas('role', function ($query) {
                $query->where('name', 'member');
            })
            ->withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->take(5)
            ->get();

        return [
            'borrowing_trend' => $trendData,
            'most_borrowed_books' => $mostBorrowed,
            'overdue_stats' => [
                'total_overdue' => $totalOverdue,
                'total_unpaid_fines' => $totalUnpaidFines,
                'average_late_days' => $averageLateDays,
            ],
            'active_members' => $activeMembers,
        ];
    }
}
