<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    /**
     * DashboardController constructor.
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the Admin Dashboard.
     */
    public function admin(): View
    {
        $stats = $this->dashboardService->getAdminStats();
        return view('dashboard.admin', compact('stats'));
    }

    /**
     * Display the Librarian Dashboard.
     */
    public function librarian(): View
    {
        $stats = $this->dashboardService->getLibrarianStats();
        return view('dashboard.librarian', compact('stats'));
    }

    /**
     * Display the Member Dashboard.
     */
    public function member(): View
    {
        $stats = $this->dashboardService->getMemberStats(Auth::id());
        return view('dashboard.member', compact('stats'));
    }

    /**
     * Display System Reports.
     */
    public function reports(): View
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isLibrarian()) {
            abort(403, 'Akses ditolak.');
        }

        $reportData = $this->dashboardService->getReports();
        return view('dashboard.reports', compact('reportData'));
    }

    /**
     * Display System Audit Activity Logs with filtering.
     */
    public function activityLogs(Request $request): View
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya Admin yang dapat mengakses log aktivitas sistem.');
        }

        $query = ActivityLog::with('user.role')->orderBy('created_at', 'desc');

        if ($request->filled('user')) {
            $search = $request->user;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->filled('type')) {
            $query->where('activity_type', $request->type);
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('dashboard.activity-logs', compact('logs'));
    }

    /**
     * Display Admin System Settings.
     */
    public function settings(): View
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        return view('dashboard.settings');
    }
}

