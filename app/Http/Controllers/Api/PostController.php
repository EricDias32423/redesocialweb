<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Ong;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of posts (Feed público)
     */
    public function index(Request $request)
    {
        try {
            $query = Post::with('ong')->latest();
            
            // Filtro por categoria
            if ($request->has('category') && $request->category != '') {
                $query->where('category', $request->category);
            }
            
            // Busca por título ou conteúdo
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }
            
            $posts = $query->paginate(10);
            
            return response()->json([
                'success' => true,
                'data' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar posts: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified post (público)
     */
    public function show(Post $post)
    {
        try {
            $post->load('ong');
            $post->loadCount('likes', 'comments');
            
            return response()->json([
                'success' => true,
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar post: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created post (apenas ONG)
     */
    public function store(Request $request)
    {
        try {
            // Verificar se é uma ONG
            if (!Auth::guard('ong')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Apenas ONGs podem criar posts'
                ], 403);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category' => 'nullable|string|max:100',
                'image' => 'nullable|image|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $validated['image'] = $path;
            }

            $validated['ong_id'] = Auth::guard('ong')->id();

            $post = Post::create($validated);
            $post->load('ong');

            return response()->json([
                'success' => true,
                'message' => 'Post criado com sucesso!',
                'data' => $post
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar post: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified post (apenas ONG dona)
     */
    public function update(Request $request, Post $post)
    {
        try {
            // Verificar se é a ONG dona do post
            if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não tem permissão para editar este post'
                ], 403);
            }

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'category' => 'nullable|string|max:100',
                'image' => 'nullable|image|max:2048'
            ]);

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $path = $request->file('image')->store('posts', 'public');
                $validated['image'] = $path;
            }

            $post->update($validated);
            $post->load('ong');

            return response()->json([
                'success' => true,
                'message' => 'Post atualizado com sucesso!',
                'data' => $post
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar post: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified post (apenas ONG dona)
     */
    public function destroy(Post $post)
    {
        try {
            if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não tem permissão para deletar este post'
                ], 403);
            }

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Deletar curtidas e comentários associados
            $post->likes()->delete();
            $post->comments()->delete();
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deletado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar post: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's posts (requer token)
     */
    public function myPosts(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            // Se for ONG, busca posts da ONG
            if ($user instanceof Ong) {
                $posts = $user->posts()->latest()->paginate(10);
            } else {
                // Se for usuário comum, busca posts que ele curtiu ou comentou
                $posts = Post::whereHas('likes', function($q) use ($user) {
                    $q->where('likable_id', $user->id);
                })->latest()->paginate(10);
            }
            
            return response()->json([
                'success' => true,
                'data' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar seus posts: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like or unlike a post
     */
    public function like(Request $request, Post $post)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            $userType = get_class($user);
            
            $existingLike = $post->likes()
                ->where('likable_id', $user->id)
                ->where('likable_type', $userType)
                ->first();
            
            if ($existingLike) {
                $existingLike->delete();
                $liked = false;
            } else {
                $post->likes()->create([
                    'likable_id' => $user->id,
                    'likable_type' => $userType,
                ]);
                $liked = true;
            }
            
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'count' => $post->likes()->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar curtida: ' . $e->getMessage()
            ], 500);
        }
    }
}