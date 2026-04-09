<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Ong;
use App\Models\RegularUser;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Toggle like on a post (curtir/descurtir)
     */
    public function toggle(Request $request, Post $post)
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
                $message = 'Curtida removida';
            } else {
                $post->likes()->create([
                    'likable_id' => $user->id,
                    'likable_type' => $userType,
                ]);
                $liked = true;
                $message = 'Post curtido!';
            }
            
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'count' => $post->likes()->count(),
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar curtida: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get posts liked by the user
     */
    public function myLikes(Request $request)
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
            
            $likedPosts = Post::whereHas('likes', function($query) use ($user, $userType) {
                $query->where('likable_id', $user->id)
                      ->where('likable_type', $userType);
            })->with('ong')->latest()->paginate(10);
            
            return response()->json([
                'success' => true,
                'data' => $likedPosts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar posts curtidos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user liked a specific post
     */
    public function check(Request $request, Post $post)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'liked' => false,
                    'count' => $post->likes()->count()
                ]);
            }
            
            $userType = get_class($user);
            
            $liked = $post->likes()
                ->where('likable_id', $user->id)
                ->where('likable_type', $userType)
                ->exists();
            
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'count' => $post->likes()->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao verificar curtida: ' . $e->getMessage()
            ], 500);
        }
    }
}