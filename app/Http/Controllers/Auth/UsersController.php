<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })
                ->orderBy('name')
                ->paginate(10);

        return view('users', compact('users', 'search'));
    }

    public function create()
    {
        return view('users_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'active'   => true,
        ]);

        return redirect()->route('users')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'active' => $request->has('active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('users')->with('error', 'Você não pode excluir sua própria conta!');
        }

        // ✅ Deleta as mensagens do usuário antes de deletar o usuário
        // (necessário por causa da foreign key messages.user_id → users.id)
        Message::where('user_id', $user->id)->delete();

        $user->delete();

        return redirect()->route('users')->with('success', 'Usuário excluído com sucesso!');
    }
}