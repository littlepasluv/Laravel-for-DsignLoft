<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DsignLoftController extends Controller
{
    /**
     * Show the brief flow page
     */
    public function index()
    {
        return Inertia::render('BriefFlow');
    }

    /**
     * Show the dashboard page
     */
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    /**
     * Show the admin page
     */
    public function admin()
    {
        return Inertia::render('Admin');
    }
}
