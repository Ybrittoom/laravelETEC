<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboadController extends Controller
{
    // Rota /dashboard
    public function index()
    {
        $totalUsuarios = User::count();
        return view('dashboard', compact('totalUsuarios'));
    }

    // Rota /home — redireciona para o dashboard
    public function home()
    {
        return redirect()->route('dashboard');
    }
}