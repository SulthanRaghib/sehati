<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GurubkController extends Controller
{
    public function dashboard()
    {
        return view('gurubk.dashboard');
    }
}
