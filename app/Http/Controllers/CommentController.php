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
        $request->validate([
            'content' => 'required|string|min:2|max:1000',
        ]);

        // Determinar quem está comentando (usuário comum ou ONG)
        if (Auth::guard('regular')->check()) {
            $commentableType = RegularUser::class;
            $commentableId = Auth::guard('regular')->id();
            $guard = 'regular';
        } elseif (Auth::guard('ong')->check()) {
            $commentableType = Ong::class;
            $commentableId = Auth::guard('ong')->id();
            $guard = 'ong';
        } else {
            return redirect()->back()->with('error', 'Você precisa estar logado para comentar.');
        }

        $comment = Comment::create([
            'commentable_type' => $commentableType,
            'commentable_id' => $commentableId,
            'post_id' => $post->id,
            'content' => $request->content,
            'status' => 'approved' // Ou 'pending' se precisar de moderação
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso!');
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