<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard Admin';

        return view('dashboard.index', compact('title'));
    }
}
