<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function home()
    {
        $title = 'Dashboard Siswa';

        return view('home', compact('title'));
    }
}
