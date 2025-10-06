<?php

namespace App\Http\Controllers;

use App\Models\Brief;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the client dashboard
     */
    public function client()
    {
        $user = Auth::user();
        
        $briefs = Brief::with(['package'])
            ->where('created_by', $user->id)
            ->latest()
            ->get();

        return Inertia::render('Dashboard/Client', [
            'briefs' => $briefs,
            'user' => $user
        ]);
    }

    /**
     * Show the designer dashboard
     */
    public function designer()
    {
        $briefs = Brief::with(['package', 'creator'])
            ->whereIn('status', ['in_progress', 'review'])
            ->latest()
            ->get();

        $allBriefs = Brief::with(['package', 'creator'])
            ->latest()
            ->get();

        return Inertia::render('Dashboard/Designer', [
            'briefs' => $briefs,
            'allBriefs' => $allBriefs,
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the admin dashboard
     */
    public function admin()
    {
        $briefs = Brief::with(['package', 'creator'])->latest()->get();
        $users = User::all();
        
        $stats = [
            'total_briefs' => Brief::count(),
            'pending_briefs' => Brief::where('status', 'pending')->count(),
            'in_progress_briefs' => Brief::where('status', 'in_progress')->count(),
            'completed_briefs' => Brief::where('status', 'completed')->count(),
            'total_users' => User::count(),
            'clients' => User::where('role', 'client')->count(),
            'designers' => User::where('role', 'designer')->count(),
        ];

        return Inertia::render('Dashboard/Admin', [
            'briefs' => $briefs,
            'users' => $users,
            'stats' => $stats,
            'user' => Auth::user()
        ]);
    }
}

