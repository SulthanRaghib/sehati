<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard Guru BK';
        $user = Auth::user();

        if ($user->userable_type == 'App\Models\Guru') {
            $guru = $user->userable;
        } else {
            $guru = null;
        }


        return view('dashboard.index', compact('title', 'user', 'guru'));
    }
}
