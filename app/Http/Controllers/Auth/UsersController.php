<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // ── READ: Lista todos os usuários (com busca opcional) ──────────
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })
                ->orderBy('name')
                ->paginate(10);   // 10 por página

        return view('users', compact('users', 'search'));
    }

    // ── CREATE: Exibe formulário de cadastro ─────────────────────────
    public function create()
    {
        return view('users_create');
    }

    // ── STORE: Salva novo usuário ────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'active'   => true,
        ]);

        return redirect()->route('users')->with('success', 'Usuário cadastrado com sucesso!');
    }

    // ── EDIT: Exibe formulário de edição ─────────────────────────────
    public function edit($id)
    {
        $user = User::findOrFail($id);   // 404 automático se não existir
        return view('users_edit', compact('user'));
    }

    // ── UPDATE: Salva as alterações ──────────────────────────────────
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // senha é opcional na edição
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'active' => $request->has('active') ? 1 : 0,
        ];

        // Só atualiza a senha se o campo foi preenchido
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users')->with('success', 'Usuário atualizado com sucesso!');
    }

    // ── DESTROY: Remove o usuário ────────────────────────────────────
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Impede que o próprio usuário logado se exclua
        if ($user->id === auth()->id()) {
            return redirect()->route('users')->with('error', 'Você não pode excluir sua própria conta!');
        }

        $user->delete();

        return redirect()->route('users')->with('success', 'Usuário excluído com sucesso!');
    }
}