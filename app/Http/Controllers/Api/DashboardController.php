<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Ong;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Estatísticas do dashboard (requer token)
     */
    public function stats(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user instanceof \App\Models\Ong) {
                // Estatísticas para ONG
                $stats = [
                    'total_posts' => $user->posts()->count(),
                    'total_comments' => $user->posts()->withCount('comments')->get()->sum('comments_count'),
                    'total_likes' => $user->posts()->withCount('likes')->get()->sum('likes_count'),
                    'total_supporters' => $user->supporters()->count(),
                ];
            } else {
                // Estatísticas para usuário comum
                $stats = [
                    'total_ongs_supported' => $user->supportedOngs()->count(),
                    'total_comments' => $user->comments()->count(),
                    'total_likes' => $user->likes()->count(),
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar estatísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atividades recentes (requer token)
     */
    public function activities(Request $request)
    {
        try {
            $user = $request->user();
            $activities = [];

            if ($user instanceof \App\Models\Ong) {
                // Últimos posts da ONG
                $posts = $user->posts()->latest()->take(5)->get();
                foreach ($posts as $post) {
                    $activities[] = [
                        'type' => 'post',
                        'title' => $post->title,
                        'created_at' => $post->created_at->diffForHumans(),
                        'url' => "/posts/{$post->id}"
                    ];
                }
            } else {
                // Últimos comentários do usuário
                $comments = $user->comments()->latest()->take(5)->get();
                foreach ($comments as $comment) {
                    $activities[] = [
                        'type' => 'comment',
                        'content' => $comment->content,
                        'created_at' => $comment->created_at->diffForHumans(),
                        'url' => "/posts/{$comment->post_id}"
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $activities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar atividades: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recomendações (requer token)
     */
    public function recommendations(Request $request)
    {
        try {
            $user = $request->user();
            
            // ONGs recomendadas (exemplo: mais recentes)
            $recommendations = Ong::withCount('posts')
                ->latest()
                ->take(5)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $recommendations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar recomendações: ' . $e->getMessage()
            ], 500);
        }
    }
}