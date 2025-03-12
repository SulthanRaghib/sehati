<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Homepage | Siswa';

        return view('home', compact('title'));
    }
}
