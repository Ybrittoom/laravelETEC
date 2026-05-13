<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index() {
        // Pega as últimas 50 mensagens com os dados do utilizador
        $messages = Message::with('user')->latest()->take(50)->get()->reverse();
        return view('chat', compact('messages'));
    }

    public function store(Request $request) {
        $request->validate(['content' => 'required']);

        Message::create([
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back(); // Recarrega a página para mostrar a nova mensagem
    }
}