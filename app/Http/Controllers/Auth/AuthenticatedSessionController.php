<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->status === 'inactive') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan. Silakan hubungi Administrator.',
            ]);
        }

        $request->session()->regenerate();
        
        // Log successful login
        $roleName = $user->role?->name ?? 'guest';
        \App\Models\ActivityLog::log(
            $user->id,
            'login',
            "Pengguna {$user->name} ({$roleName}) berhasil masuk ke dalam sistem."
        );

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($user->isLibrarian()) {
            return redirect()->intended(route('librarian.dashboard', absolute: false));
        } else {
            return redirect()->intended(route('member.dashboard', absolute: false));
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            $roleName = $user->role?->name ?? 'guest';
            \App\Models\ActivityLog::log(
                $user->id,
                'logout',
                "Pengguna {$user->name} ({$roleName}) keluar dari sistem."
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
