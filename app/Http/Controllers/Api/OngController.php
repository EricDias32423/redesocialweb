<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OngController extends Controller
{
    /**
     * Display a listing of all ONGs (API)
     */
    public function index(Request $request)
    {
        try {
            $query = Ong::query();
            
            // Busca por nome ou descrição
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('ong_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            $ongs = $query->withCount('posts')->latest()->paginate(12);
            
            return response()->json([
                'success' => true,
                'data' => $ongs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar ONGs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified ONG (API)
     */
    public function show(Request $request, Ong $ong)
    {
        try {
            $ong->loadCount('posts');
            
            // Verificar se o usuário atual apoia esta ONG
            $userSupported = false;
            $user = $request->user();
            if ($user) {
                $userSupported = $user->supportedOngs()
                    ->where('ong_id', $ong->id)
                    ->exists();
            }
            
            // Estatísticas da ONG
            $stats = [
                'total_posts' => $ong->posts()->count(),
                'total_followers' => $ong->supporters()->count(),
            ];
            
            // Posts da ONG
            $posts = $ong->posts()->withCount('comments')->latest()->paginate(10);
            
            // Apoiadores recentes (últimos 5)
            $recentSupporters = $ong->supporters()
                ->latest()
                ->take(5)
                ->get()
                ->map(function($supporter) {
                    return [
                        'id' => $supporter->id,
                        'name' => $supporter->name,
                        'avatar' => $supporter->avatar
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'ong' => $ong,
                    'stats' => $stats,
                    'posts' => $posts,
                    'user_supported' => $userSupported,
                    'recent_supporters' => $recentSupporters
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar ONG: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar posts de uma ONG específica (API)
     */
    public function posts(Ong $ong)
    {
        try {
            $posts = $ong->posts()->with('ong')->latest()->paginate(10);
            
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
     * ONGs que o usuário apoia (API - requer token)
     */
    public function mySupportedOngs(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            $ongs = $user->supportedOngs()->paginate(10);
            
            return response()->json([
                'success' => true,
                'data' => $ongs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar ONGs apoiadas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apoiar uma ONG (API - requer token)
     */
    public function support(Request $request, Ong $ong)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            if (!$user->supportedOngs()->where('ong_id', $ong->id)->exists()) {
                $user->supportedOngs()->attach($ong->id);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'ONG apoiada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao apoiar ONG: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deixar de apoiar uma ONG (API - requer token)
     */
    public function unsupport(Request $request, Ong $ong)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            $user->supportedOngs()->detach($ong->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Apoio removido com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover apoio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Estatísticas da ONG (API - requer token de ONG)
     */
    public function analytics(Request $request)
    {
        try {
            $ong = $request->user();
            
            // Verificar se o usuário é uma ONG
            if (!$ong instanceof \App\Models\Ong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Apenas ONGs podem acessar esta rota'
                ], 403);
            }
            
            $stats = [
                'total_posts' => $ong->posts()->count(),
                'total_followers' => $ong->supporters()->count(),
                'total_comments' => $ong->posts()->withCount('comments')->get()->sum('comments_count'),
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
}