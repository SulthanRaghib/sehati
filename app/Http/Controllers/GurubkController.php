<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GurubkController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard Guru BK';

        return view('dashboard.index', compact('title'));
    }
}
