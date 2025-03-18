<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Homepage | Siswa';

        return view('home', compact('title'));
    }

    public function testingDashboard()
    {
        $title = 'Testing Dashboard';

        return view('test.dashboard', compact('title'));
    }

    public function testingUser()
    {
        $title = 'Testing User';
        $user = User::all();

        return view('test.users', compact('title', 'user'));
    }
}
