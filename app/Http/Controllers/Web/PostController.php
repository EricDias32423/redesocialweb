<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\Post;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $post->load('ong');
        $post->loadCount(['likes', 'comments']);

        $userLiked = false;
        $userSupportsOng = false;

        if (Auth::guard('regular')->check()) {
            $user = Auth::guard('regular')->user();

            $userLiked = $post->likes()
                ->where('likable_id', $user->id)
                ->where('likable_type', RegularUser::class)
                ->exists();

            $userSupportsOng = $user->supportedOngs()
                ->where('ong_id', $post->ong_id)
                ->exists();
        }

        if (Auth::guard('ong')->check()) {
            $ong = Auth::guard('ong')->user();

            $userLiked = $post->likes()
                ->where('likable_id', $ong->id)
                ->where('likable_type', Ong::class)
                ->exists();
        }

        return view('posts.show', compact('post', 'userLiked', 'userSupportsOng'));
    }

    public function like(Request $request, Post $post)
    {
        if (!Auth::guard('regular')->check() && !Auth::guard('ong')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (Auth::guard('regular')->check()) {
            $user = Auth::guard('regular')->user();
            $userType = RegularUser::class;
        } else {
            $user = Auth::guard('ong')->user();
            $userType = Ong::class;
        }

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
            'count' => $post->likes()->count(),
        ]);
    }

    public function index(Request $request)
    {
        $query = Post::with('ong')
            ->withCount(['likes', 'comments'])
            ->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9);
        $categories = Post::distinct('category')->pluck('category')->filter();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        if (!Auth::guard('ong')->check()) {
            return redirect()->route('home')
                ->with('error', 'Apenas ONGs podem criar posts.');
        }

        return view('posts.create');
    }

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
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['ong_id'] = Auth::guard('ong')->id();

        $post = Post::create($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post criado com sucesso!');
    }

    public function edit(Post $post)
    {
        if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Voce nao tem permissao para editar este post.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Voce nao tem permissao para editar este post.');
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy(Post $post)
    {
        if (!Auth::guard('ong')->check() || Auth::guard('ong')->id() !== $post->ong_id) {
            return redirect()->route('posts.index')
                ->with('error', 'Voce nao tem permissao para deletar este post.');
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('my-posts')
            ->with('success', 'Post deletado com sucesso!');
    }

    public function myPosts()
    {
        if (!Auth::guard('ong')->check()) {
            return redirect()->route('home');
        }

        $posts = Auth::guard('ong')->user()->posts()
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(10);

        return view('posts.my-posts', compact('posts'));
    }
}
