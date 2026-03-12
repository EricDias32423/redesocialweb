<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;

class CheckPostOwner
{
    public function handle(Request $request, Closure $next)
    {
        $postId = $request->route('post');
        $post = Post::findOrFail($postId);
        
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }
        
        return $next($request);
    }
}