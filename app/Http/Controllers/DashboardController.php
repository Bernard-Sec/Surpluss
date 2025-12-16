<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'donor') {
            return redirect()->route('donor.dashboard');
        } elseif ($user->role === 'receiver') {
            return redirect()->route('receiver.dashboard');
        }

        return abort(403, 'Role tidak valid.');
    }
}