<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function home()
    {
        $title = 'Homepage';
        $user = Auth::user();

        if ($user->userable_type == 'App\Models\Siswa') {
            $siswa = $user->userable;
        } else {
            $siswa = null;
        }

        return view('home', compact('title', 'user', 'siswa'));
    }
}
