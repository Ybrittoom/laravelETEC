<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// adicionada a linha a Fachada (Facade) de Autenticação
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        // Retorna a view do formulário
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Adicionamos 'level' => true para garantir que usuários 
        // desativados (false) não consigam logar mesmo com a senha correta
        $credentials['active'] = true;

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais não coincidem ou sua conta está desativada.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Realiza o logout do usuário no sistema
        Auth::logout();

        // Invalida a sessão atual do usuário
        $request->session()->invalidate();

        // Gera um novo token CSRF para evitar ataques de fixação de sessão
        $request->session()->regenerateToken();

        // Redireciona para a página de login ou home
        return redirect('/login');
    }

    public function showRegister() {
        return view('auth.register'); // Certifique-se de que a pasta e arquivo existam
    }
    
    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->route('login')->with('success', 'Cadastro realizado! Agora faça o login.');
    }
}