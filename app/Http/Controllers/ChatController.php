<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Exibir página de mensagens (para usuário regular)
     */
    public function index(Request $request)
    {
        $user = Auth::guard('regular')->user() ?? Auth::guard('ong')->user();
        $userType = Auth::guard('regular')->check() ? 'regular' : 'ong';
        $routePrefix = $userType === 'regular' ? 'regular' : 'ong';

        // Obter conversas do usuário
        if ($userType === 'regular') {
            $conversations = Conversation::where('regular_user_id', $user->id)
                ->with(['ong', 'messages'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        } else {
            $conversations = Conversation::where('ong_id', $user->id)
                ->with(['regularUser', 'messages'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        }

        return view('chat.index', compact('conversations', 'userType', 'user', 'routePrefix'));
    }

    /**
     * Abrir conversa com um contato
     */
    public function show(Conversation $conversation, Request $request)
    {
        $user = Auth::guard('regular')->user() ?? Auth::guard('ong')->user();
        $userType = Auth::guard('regular')->check() ? 'regular' : 'ong';
        $routePrefix = $userType === 'regular' ? 'regular' : 'ong';

        // Verificar se o usuário pode acessar esta conversa
        if ($userType === 'regular' && $conversation->regular_user_id !== $user->id) {
            abort(403);
        }
        if ($userType === 'ong' && $conversation->ong_id !== $user->id) {
            abort(403);
        }

        // Marcar mensagens como lidas
        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_type', '!=', ($userType === 'regular' ? 'regular_user' : 'ong'))
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->reorder()
            ->oldest('created_at')
            ->oldest('id')
            ->paginate(50);
        $other = $userType === 'regular' ? $conversation->ong : $conversation->regularUser;
        $otherName = $this->participantName($other);

        return view('chat.show', compact('conversation', 'messages', 'userType', 'user', 'other', 'otherName', 'routePrefix'));
    }

    /**
     * Enviar mensagem
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $user = Auth::guard('regular')->user() ?? Auth::guard('ong')->user();
        $userType = Auth::guard('regular')->check() ? 'regular' : 'ong';

        // Validar
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        // Verificar acesso
        if ($userType === 'regular' && $conversation->regular_user_id !== $user->id) {
            abort(403);
        }
        if ($userType === 'ong' && $conversation->ong_id !== $user->id) {
            abort(403);
        }

        // Criar mensagem
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'sender_type' => $userType === 'regular' ? 'regular_user' : 'ong',
            'content' => $request->content,
        ]);

        // Atualizar last_message_at
        $conversation->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    /**
     * Iniciar conversa ou abrir existente (via botão no perfil)
     */
    public function startChat(Request $request)
    {
        $user = Auth::guard('regular')->user();

        if (!$user) {
            abort(403);
        }

        $request->validate([
            'ong_id' => 'required|exists:ongs,id',
        ]);

        // Procurar conversa existente
        $conversation = Conversation::where('regular_user_id', $user->id)
            ->where('ong_id', $request->ong_id)
            ->first();

        // Se não existir, criar
        if (!$conversation) {
            $conversation = Conversation::create([
                'regular_user_id' => $user->id,
                'ong_id' => $request->ong_id,
                'last_message_at' => now(),
            ]);
        }

        return redirect()->route('regular.chat.show', $conversation);
    }

    /**
     * Obter mensagens via AJAX (para atualização em tempo real)
     */
    public function getMessages(Conversation $conversation)
    {
        $user = Auth::guard('regular')->user() ?? Auth::guard('ong')->user();
        $userType = Auth::guard('regular')->check() ? 'regular' : 'ong';
        $senderType = $userType === 'regular' ? 'regular_user' : 'ong';

        // Verificar acesso
        if ($userType === 'regular' && $conversation->regular_user_id !== $user->id) {
            abort(403);
        }
        if ($userType === 'ong' && $conversation->ong_id !== $user->id) {
            abort(403);
        }

        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_type', '!=', $senderType)
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->reorder()
            ->latest('created_at')
            ->latest('id')
            ->limit(50)
            ->get()
            ->sortBy([
                ['created_at', 'asc'],
                ['id', 'asc'],
            ])
            ->values();

        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender' => $message->senderName(),
                    'sender_id' => $message->sender_id,
                    'sender_type' => $message->sender_type,
                    'content' => $message->content,
                    'created_at' => $message->created_at->format('H:i'),
                    'read_at' => $message->read_at,
                ];
            }),
        ]);
    }

    private function participantName($participant): string
    {
        return $participant->name ?? $participant->ong_name ?? 'Contato';
    }
}
