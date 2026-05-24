<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReportExportController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isLibrarian()) {
        return redirect()->route('librarian.dashboard');
    } else {
        return redirect()->route('member.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard routes for each role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/dashboard/librarian', [DashboardController::class, 'librarian'])
        ->middleware('role:librarian')
        ->name('librarian.dashboard');

    Route::get('/dashboard/member', [DashboardController::class, 'member'])
        ->middleware('role:member')
        ->name('member.dashboard');

    // Reports (Admin & Librarian)
    Route::get('/reports', [DashboardController::class, 'reports'])
        ->middleware('role:admin,librarian')
        ->name('reports.index');

    // Activity Logs (Admin only)
    Route::get('/activity-logs', [DashboardController::class, 'activityLogs'])
        ->middleware('role:admin')
        ->name('admin.activity-logs');
});

// Books Public catalog (Accessible to all authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    
    // Member Borrowing Actions
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    Route::post('/borrowings/request/{book}', [BorrowingController::class, 'requestBorrow'])->name('borrowings.request');
    Route::post('/borrowings/{borrowing}/cancel', [BorrowingController::class, 'cancel'])->name('borrowings.cancel');

    // Member Fines Routes
    Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
    Route::get('/fines/history', [FineController::class, 'history'])->name('fines.history');
});

// Admin & Librarian Book/Category Management CRUD
Route::middleware(['auth', 'verified', 'role:admin,librarian'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::resource('categories', CategoryController::class)->except(['show']);

    // Librarian Borrowing Actions
    Route::get('/borrowings/manage', [BorrowingController::class, 'manage'])->name('borrowings.manage');
    Route::get('/borrowings/overdue', [BorrowingController::class, 'overdue'])->name('borrowings.overdue');
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::post('/borrowings/{borrowing}/borrow', [BorrowingController::class, 'markAsBorrowed'])->name('borrowings.borrow');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'markAsReturned'])->name('borrowings.return');

    // Librarian Fines Actions
    Route::get('/fines/manage', [FineController::class, 'manage'])->name('fines.manage');
    Route::post('/fines/{fine}/pay', [FineController::class, 'pay'])->name('fines.pay');
    Route::post('/fines/{fine}/waive', [FineController::class, 'waive'])->name('fines.waive');

    // User Listing Action
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// PDF Export Routes (Admin & Librarian only)
Route::middleware(['auth', 'verified', 'role:admin,librarian'])->prefix('reports/export')->name('reports.export.')->group(function () {
    Route::get('/borrowings', [ReportExportController::class, 'borrowings'])->name('borrowings');
    Route::get('/fines', [ReportExportController::class, 'fines'])->name('fines');
    Route::get('/users', [ReportExportController::class, 'users'])->name('users');
    Route::get('/books', [ReportExportController::class, 'books'])->name('books');
    Route::get('/statistics', [ReportExportController::class, 'statistics'])->name('statistics');
});

// Admin-only System Management Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/settings', [DashboardController::class, 'settings'])->name('admin.settings');

    // Admin User Management (Full CRUD)
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/',                         [AdminUserController::class, 'index'])->name('index');
        Route::get('/create',                   [AdminUserController::class, 'create'])->name('create');
        Route::post('/',                        [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit',              [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}',                   [AdminUserController::class, 'update'])->name('update');
        Route::post('/{user}/toggle-status',    [AdminUserController::class, 'toggleStatus'])->name('toggleStatus');
        Route::post('/{user}/reset-password',   [AdminUserController::class, 'resetPassword'])->name('resetPassword');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('profile.settings');
});

require __DIR__.'/auth.php';
