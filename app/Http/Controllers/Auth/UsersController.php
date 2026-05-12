<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Importar o Model User
use Illuminate\Support\Facades\Hash; // Importar para criptografar a senha

class UsersController extends Controller
{
    public function index()
    {
        return view('users');
    }

    // Exibe o formulário de cadastro
    public function create()
    {
        return view('users_create'); // Vamos criar essa view
    }

    // Salva o usuário no banco de dados
    public function store(Request $request)
    {
        // 1. Validação
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Criação do registro
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Sempre criptografe!
        ]);

        // 3. Redirecionar com mensagem de sucesso
        return redirect()->route('users')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
