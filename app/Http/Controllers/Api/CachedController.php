<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CacheFeedJob;
use App\Jobs\CacheOngsJob;
use App\Jobs\CachePostJob;
use App\Jobs\CacheOngJob;
use App\Jobs\CacheDashboardStatsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CachedController extends Controller
{
    /**
     * Get feed (com cache)
     */
    public function feed()
    {
        $posts = Cache::get('feed_posts');
        
        if (!$posts) {
            CacheFeedJob::dispatch();
            return response()->json([
                'success' => true,
                'message' => 'Cache sendo gerado...',
                'status' => 'loading'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $posts,
            'cached' => true
        ]);
    }

    /**
     * Get single post (com cache)
     */
    public function post($id)
    {
        $post = Cache::get("post_{$id}");
        
        if (!$post) {
            CachePostJob::dispatch($id);
            return response()->json([
                'success' => true,
                'message' => 'Post sendo carregado...',
                'status' => 'loading'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $post,
            'cached' => true
        ]);
    }

    /**
     * Get ONGs list (com cache)
     */
    public function ongs()
    {
        $ongs = Cache::get('ongs_list');
        
        if (!$ongs) {
            CacheOngsJob::dispatch();
            return response()->json([
                'success' => true,
                'message' => 'Lista sendo carregada...',
                'status' => 'loading'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $ongs,
            'cached' => true
        ]);
    }

    /**
     * Get single ONG (com cache)
     */
    public function ong($id)
    {
        $ong = Cache::get("ong_{$id}");
        
        if (!$ong) {
            CacheOngJob::dispatch($id);
            return response()->json([
                'success' => true,
                'message' => 'ONG sendo carregada...',
                'status' => 'loading'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $ong,
            'cached' => true
        ]);
    }

    /**
     * Get dashboard stats (com cache)
     */
    public function dashboardStats()
    {
        $ongId = Auth::guard('ong')->id();
        
        if (!$ongId) {
            return response()->json([
                'success' => false,
                'message' => 'Não autenticado'
            ], 401);
        }
        
        $stats = Cache::get("dashboard_stats_{$ongId}");
        
        if (!$stats) {
            CacheDashboardStatsJob::dispatch($ongId);
            return response()->json([
                'success' => true,
                'message' => 'Estatísticas sendo carregadas...',
                'status' => 'loading'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $stats,
            'cached' => true
        ]);
    }

    /**
     * Invalidate cache when content changes
     */
    public function invalidateFeed()
    {
        Cache::forget('feed_posts');
        CacheFeedJob::dispatch();
        
        return response()->json([
            'success' => true,
            'message' => 'Cache do feed reiniciado'
        ]);
    }

    /**
     * Invalidate cache after creating post
     */
    public function invalidateOnNewPost()
    {
        Cache::forget('feed_posts');
        CacheFeedJob::dispatch();
        
        // Também invalidar estatísticas do dashboard
        $ongId = Auth::guard('ong')->id();
        if ($ongId) {
            Cache::forget("dashboard_stats_{$ongId}");
            CacheDashboardStatsJob::dispatch($ongId);
        }
    }
}