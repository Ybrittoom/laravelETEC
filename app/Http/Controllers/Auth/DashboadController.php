<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboadController extends Controller
{
    public function index()
    {

        // Conta o total de registros na tabela 'users' do banco de dados
        $totalUsuarios = User::count();

        // A função compact() passa a variável totalUsuarios para a view
        return view('dashboard', compact('totalUsuarios'));
    }
}
