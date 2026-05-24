<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display admin user management listing with role filtering.
     */
    public function index(Request $request): View
    {
        $query = User::with('role')->orderBy('created_at', 'desc');

        if ($request->filled('role')) {
            $query->whereHas('role', fn($q) => $q->where('name', $request->role));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('reg_from')) {
            $query->whereDate('created_at', '>=', $request->reg_from);
        }

        if ($request->filled('reg_to')) {
            $query->whereDate('created_at', '<=', $request->reg_to);
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'role_id'  => ['required', 'exists:roles,id'],
            'status'   => ['required', 'in:active,inactive'],
        ]);

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role_id'           => $validated['role_id'],
            'status'            => $validated['status'],
            'email_verified_at' => now(),
        ]);

        ActivityLog::log(
            Auth::id(),
            'approval',
            "Administrator membuat akun pengguna baru: {$user->name} (Email: {$user->email}, Role: {$user->role->name})."
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pengguna {$user->name} berhasil dibuat.");
    }

    /**
     * Show the form for editing an existing user.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user's information.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'status'  => ['required', 'in:active,inactive'],
        ]);

        // Prevent admin from deactivating themselves
        if ($user->id === Auth::id() && $validated['status'] === 'inactive') {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update($validated);

        ActivityLog::log(
            Auth::id(),
            'approval',
            "Administrator memperbarui akun pengguna: {$user->name} (Email: {$user->email})."
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Toggle user account status between active and inactive.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $label = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::log(
            Auth::id(),
            'approval',
            "Administrator {$label} akun pengguna: {$user->name} (Email: {$user->email})."
        );

        return back()->with('success', "Akun {$user->name} berhasil {$label}.");
    }

    /**
     * Reset the specified user's password.
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'new_password' => ['required', Password::min(8)->letters()->numbers(), 'confirmed'],
        ]);

        $user->update(['password' => Hash::make($validated['new_password'])]);

        ActivityLog::log(
            Auth::id(),
            'approval',
            "Administrator mereset kata sandi akun pengguna: {$user->name} (Email: {$user->email})."
        );

        return back()->with('success', "Kata sandi {$user->name} berhasil direset.");
    }
}
