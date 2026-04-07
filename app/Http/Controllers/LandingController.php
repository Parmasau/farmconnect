<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        // Redirect logged-in farmers to their dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isFarmer()) {
                return redirect()->route('farmer.dashboard');
            } elseif ($user->isAgrovet()) {
                return redirect()->route('agrovet.dashboard');
            } elseif ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('landing');
    }
}
