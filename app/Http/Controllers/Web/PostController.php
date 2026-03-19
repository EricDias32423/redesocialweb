<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Ong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RegularUser;



class PostController extends Controller
{
    /**
 * Display the specified post.
 */
public function show(Post $post)
{
    // Carrega o relacionamento com a ONG
    $post->load('ong');
    
    // Carrega a contagem de likes (se a tabela existir)
    $post->loadCount('likes');
    
    // Verifica se o usuário atual (regular) já curtiu este post
    $userLiked = false;
    $userSupportsOng = false;
    
    if (Auth::guard('regular')->check()) {
        $user = Auth::guard('regular')->user();
        
        // Verifica se o usuário já curtiu este post
        if ($post->relationLoaded('likes')) {
            $userLiked = $post->likes()
                ->where('likable_id', $user->id)
                ->where('likable_type', RegularUser::class)
                ->exists();
        }
        
        // Verifica se o usuário apoia esta ONG
        $userSupportsOng = $user->supportedOngs()
            ->where('ong_id', $post->ong_id)
            ->exists();
    }
    
    // Se for ONG logada, verifica se curtiu
    if (Auth::guard('ong')->check()) {
        $ong = Auth::guard('ong')->user();
        if ($post->relationLoaded('likes')) {
            $userLiked = $post->likes()
                ->where('likable_id', $ong->id)
                ->where('likable_type', Ong::class)
                ->exists();
        }
    }
    
    return view('posts.show', compact('post', 'userLiked', 'userSupportsOng'));
}
   public function like(Request $request, Post $post)
{
    // Verifica se o usuário está logado (qualquer guard)
        if (!Auth::check() && !Auth::guard('regular')->check() && !Auth::guard('ong')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.'
        ], 401);
    }

    $user = null;
    $userType = null;

    if (Auth::guard('regular')->check()) {
        $user = Auth::guard('regular')->user();
        $userType = RegularUser::class;
    } elseif (Auth::guard('ong')->check()) {
        $user = Auth::guard('ong')->user();
        $userType = Ong::class;
    }

    // Verifica se já curtiu
    $existingLike = $post->likes()
        ->where('likable_id', $user->id)
        ->where('likable_type', $userType)
        ->first();

    if ($existingLike) {
        // Já curtiu → remove (descurtir)
        $existingLike->delete();
        $liked = false;
    } else {
        // Não curtiu → adiciona
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
}
    /**
     * Display a listing of the posts (Feed público)
     */
    public function index(Request $request)
    {
        $query = Post::with('ong')->latest();
        
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        $posts = $query->paginate(9);
        $categories = Post::distinct('category')->pluck('category')->filter();
        
        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new post (apenas ONG)
     */
        public function create()
        {
            // Verifica se é uma ONG logada
            if (!Auth::guard('ong')->check()) {
                return redirect()->route('home')
                    ->with('error', 'Apenas ONGs podem criar posts.');
            }

            return view('posts.create');
        }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        if (!Auth::guard('ong')->check()) {
            return redirect()->route('home')
                ->with('error', 'Apenas ONGs podem criar posts.');
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
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post criado com sucesso!');
    }

   

    /**
     * Update the specified post.
     */
    public function update(Request $request, Post $post)
    {
        if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Você não tem permissão para editar este post.');
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
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post atualizado com sucesso!');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post)
    {
        if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Você não tem permissão para deletar este post.');
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        
        return redirect()->route('my-posts')
            ->with('success', 'Post deletado com sucesso!');
    }

    /**
     * Display user's posts (apenas ONG)
     */
    public function myPosts()
    {
        if (!Auth::guard('ong')->check()) {
            return redirect()->route('home');
        }
        
        $posts = Auth::guard('ong')->user()->posts()->latest()->paginate(10);
        return view('posts.my-posts', compact('posts'));
    }
}