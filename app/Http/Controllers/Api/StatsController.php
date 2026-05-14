<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Ong;
use App\Models\RegularUser;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /**
     * Visão geral das estatísticas (público)
     */
    public function overview()
    {
        try {
            $stats = [
                'total_ongs' => Ong::count(),
                'total_users' => RegularUser::count(),
                'total_posts' => Post::count(),
                'total_comments' => \App\Models\Comment::count(),
                'total_likes' => \App\Models\Like::count(),
            ];

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
     * Estatísticas por categoria (público)
     */
    public function categories()
    {
        try {
            $categories = Post::select('category')
                ->selectRaw('COUNT(*) as total')
                ->whereNotNull('category')
                ->groupBy('category')
                ->orderBy('total', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar estatísticas de categorias: ' . $e->getMessage()
            ], 500);
        }
    }
}