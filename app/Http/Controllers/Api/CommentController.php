<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Ong;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * List comments of a post (público)
     */
    public function index(Post $post)
    {
        try {
            $comments = $post->comments()
                ->with('commentable')
                ->latest()
                ->get()
                ->map(function ($comment) {
                    $authorName = 'Usuário';
                    $authorAvatar = null;
                    
                    if ($comment->commentable_type === RegularUser::class) {
                        $author = RegularUser::find($comment->commentable_id);
                        $authorName = $author ? $author->name : 'Usuário removido';
                        $authorAvatar = $author ? $author->avatar : null;
                    } elseif ($comment->commentable_type === Ong::class) {
                        $author = Ong::find($comment->commentable_id);
                        $authorName = $author ? $author->ong_name : 'ONG removida';
                        $authorAvatar = $author ? $author->logo : null;
                    }
                    
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'author_name' => $authorName,
                        'author_avatar' => $authorAvatar,
                        'author_type' => $comment->commentable_type === RegularUser::class ? 'user' : 'ong',
                        'created_at' => $comment->created_at->diffForHumans(),
                        'created_at_raw' => $comment->created_at
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $comments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar comentários: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a single comment (público)
     */
    public function show(Comment $comment)
    {
        try {
            $comment->load('commentable');
            
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar comentário: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new comment (requer token)
     */
    public function store(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|string|min:2|max:1000'
            ]);
            
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            $userType = get_class($user);
            
            $comment = $post->comments()->create([
                'commentable_id' => $user->id,
                'commentable_type' => $userType,
                'content' => $request->content,
                'status' => 'approved'
            ]);
            
            $comment->load('commentable');
            
            return response()->json([
                'success' => true,
                'message' => 'Comentário adicionado com sucesso!',
                'data' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'author_name' => $user->name ?? $user->ong_name,
                    'author_type' => $userType === RegularUser::class ? 'user' : 'ong',
                    'created_at' => $comment->created_at->diffForHumans()
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar comentário: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a comment (apenas autor)
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            // Verificar se o usuário é o autor do comentário
            if ($comment->commentable_id !== $user->id || $comment->commentable_type !== get_class($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não tem permissão para editar este comentário'
                ], 403);
            }
            
            $request->validate([
                'content' => 'required|string|min:2|max:1000'
            ]);
            
            $comment->update([
                'content' => $request->content
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Comentário atualizado com sucesso!',
                'data' => $comment
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar comentário: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a comment (apenas autor)
     */
    public function destroy(Request $request, Comment $comment)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            // Verificar se o usuário é o autor do comentário
            if ($comment->commentable_id !== $user->id || $comment->commentable_type !== get_class($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não tem permissão para deletar este comentário'
                ], 403);
            }
            
            $comment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Comentário removido com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar comentário: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's comments (requer token)
     */
    public function myComments(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            $comments = Comment::where('commentable_id', $user->id)
                ->where('commentable_type', get_class($user))
                ->with('post')
                ->latest()
                ->paginate(20);
            
            return response()->json([
                'success' => true,
                'data' => $comments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar seus comentários: ' . $e->getMessage()
            ], 500);
        }
    }
}