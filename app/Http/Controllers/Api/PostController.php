<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        // Middleware para API (Sanctum)
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of posts (Feed)
     */
    public function index(Request $request)
    {
        // Query base com relacionamentos
        $query = Post::with('user')->latest();
        
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
        
        $posts = $query->paginate(9);
        
        // Se for API (JSON)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $posts
            ]);
        }
        
        // Se for Web (View) - Buscar categorias para o filtro
        $categories = Post::distinct('category')->pluck('category')->filter();
        return view('home', compact('posts', 'categories'));
    }

    /**
     * Show form for creating post (Web only)
     */
    public function create()
    {
        // Verificar se é API
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'message' => 'Use POST /api/posts para criar um post'
            ], 405);
        }
        
        return view('posts.create');
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048'
        ]);

        // Upload de imagem
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = Auth::id();

        try {
            $post = Post::create($validated);
            
            // Se for API
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post criado com sucesso!',
                    'data' => $post->load('user')
                ], 201);
            }
            
            // Se for Web
            return redirect()->route('posts.show', $post)
                ->with('success', 'Post criado com sucesso!');
                
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao criar post: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erro ao criar post')->withInput();
        }
    }

    /**
     * Display the specified post.
     */
    public function show(Request $request, Post $post)
    {
        $post->load('user');
        
        // Se for API
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $post
            ]);
        }
        
        // Se for Web
        return view('posts.show', compact('post'));
    }

    /**
     * Show form for editing post (Web only)
     */
    public function edit(Request $request, Post $post)
    {
        // Verificar permissão
        if ($post->user_id !== Auth::id()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não tem permissão para editar este post'
                ], 403);
            }
            
            return redirect()->route('posts.index')
                ->with('error', 'Você não tem permissão para editar este post');
        }
        
        // Se for API
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $post
            ]);
        }
        
        // Se for Web
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, Post $post)
    {
        // Verificar permissão
        if ($post->user_id !== Auth::id()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permissão negada'
                ], 403);
            }
            
            return redirect()->route('posts.index')
                ->with('error', 'Permissão negada');
        }

        // Validação
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048'
        ]);

        // Upload de nova imagem
        if ($request->hasFile('image')) {
            // Deletar imagem antiga
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        try {
            $post->update($validated);
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post atualizado com sucesso!',
                    'data' => $post->fresh()->load('user')
                ]);
            }
            
            return redirect()->route('posts.show', $post)
                ->with('success', 'Post atualizado com sucesso!');
                
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar post: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erro ao atualizar post')->withInput();
        }
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Request $request, Post $post)
    {
        // Verificar permissão
        if ($post->user_id !== Auth::id()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permissão negada'
                ], 403);
            }
            
            return redirect()->route('posts.index')
                ->with('error', 'Permissão negada');
        }

        try {
            // Deletar imagem
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->delete();
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post deletado com sucesso!'
                ]);
            }
            
            return redirect()->route('my-posts')
                ->with('success', 'Post deletado com sucesso!');
                
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao deletar post: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erro ao deletar post');
        }
    }

    /**
     * Display user's posts.
     */
    public function myPosts(Request $request)
    {
        $posts = Auth::user()->posts()->latest()->paginate(10);
        
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $posts
            ]);
        }
        
        return view('posts.my-posts', compact('posts'));
    }

    /**
     * Get categories list (API only)
     */
    public function categories()
    {
        $categories = Post::distinct('category')
            ->whereNotNull('category')
            ->pluck('category');
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}