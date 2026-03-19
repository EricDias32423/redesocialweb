<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
{
    // Garantir que a resposta sempre seja JSON
    if (!$request->expectsJson()) {
        return response()->json(['success' => false, 'message' => 'Requisição inválida'], 400);
    }
    
    try {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $user = null;
        $userType = null;

        if (Auth::guard('regular')->check()) {
            $user = Auth::guard('regular')->user();
            $userType = RegularUser::class;
        } elseif (Auth::guard('ong')->check()) {
            $user = Auth::guard('ong')->user();
            $userType = Ong::class;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        $comment = $post->comments()->create([
            'commentable_id' => $user->id,
            'commentable_type' => $userType,
            'content' => $request->content,
            'status' => 'approved'
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'author_name' => $user->name ?? $user->ong_name,
                'created_at' => $comment->created_at->diffForHumans()
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro de validação',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro interno: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment)
    {
        // Verificar permissão (apenas o autor pode editar)
        $authorized = false;
        
        if (Auth::guard('regular')->check()) {
            $authorized = ($comment->commentable_type === RegularUser::class && 
                          $comment->commentable_id === Auth::guard('regular')->id());
        } elseif (Auth::guard('ong')->check()) {
            $authorized = ($comment->commentable_type === Ong::class && 
                          $comment->commentable_id === Auth::guard('ong')->id());
        }

        if (!$authorized) {
            return redirect()->back()->with('error', 'Você não tem permissão para editar este comentário.');
        }

        $request->validate([
            'content' => 'required|string|min:2|max:1000',
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Comentário atualizado!');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        // Verificar permissão (apenas o autor pode deletar)
        $authorized = false;
        
        if (Auth::guard('regular')->check()) {
            $authorized = ($comment->commentable_type === RegularUser::class && 
                          $comment->commentable_id === Auth::guard('regular')->id());
        } elseif (Auth::guard('ong')->check()) {
            $authorized = ($comment->commentable_type === Ong::class && 
                          $comment->commentable_id === Auth::guard('ong')->id());
        }

        if (!$authorized) {
            return redirect()->back()->with('error', 'Você não tem permissão para deletar este comentário.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comentário removido!');
    }
}