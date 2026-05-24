<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LandingController extends Controller
{
    /**
     * Display the public landing page or redirect authenticated users.
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $stats = [
            'books' => Book::count(),
            'categories' => Category::count(),
            'members' => User::whereHas('role', function ($q) {
                $q->where('name', 'member');
            })->count(),
            'transactions' => Borrowing::whereIn('status', ['borrowed', 'returned', 'overdue'])->count(),
        ];

        return view('welcome', compact('stats'));
    }
}
