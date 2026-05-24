<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of registered users.
     */
    public function index(): View
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isLibrarian()) {
            abort(403, 'Akses ditolak.');
        }

        $users = User::with('role')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Delete the specified user from storage (Admin only).
     */
    public function destroy(User $user): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya Administrator yang memiliki akses untuk menghapus pengguna.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Log action before deletion
        \App\Models\ActivityLog::log(
            Auth::id(),
            'approval',
            "Administrator menghapus akun pengguna {$user->name} (Email: {$user->email})."
        );

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }
}
