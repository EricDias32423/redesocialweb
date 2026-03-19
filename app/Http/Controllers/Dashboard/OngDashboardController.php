<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class OngDashboardController extends Controller
{
    /**
     * Exibir dashboard da ONG
     */
    public function index()
    {
        $ong = Auth::guard('ong')->user();
        
        // Estatísticas da ONG - SEM usar a coluna views
        $stats = [
            'total_posts' => $ong->posts()->count(),
            // Remover ou comentar a linha que usa views
            // 'total_views' => $ong->posts()->sum('views'),
            'total_views' => 0, // Valor temporário até implementar views
            'total_comments' => $this->getTotalComments($ong),
            'total_likes' => $this->getTotalLikes($ong),
            'total_followers' => 0, // Implementar depois
            'member_since' => $ong->created_at->format('d/m/Y'),
        ];
        
        // Últimos posts
        $recentPosts = $ong->posts()->latest()->take(5)->get();
        
        // Posts mais populares (baseado em comentários por enquanto)
        $popularPosts = $ong->posts()
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();
        
        // Atividades recentes
        $recentActivities = $this->getRecentActivities($ong);
        
        return view('ong.dashboard', compact(
            'ong', 
            'stats', 
            'recentPosts', 
            'popularPosts', 
            'recentActivities'
        ));
    }

    /**
     * Exibir análise de engajamento
     */
public function engagementAnalytics()
{
    $ong = Auth::guard('ong')->user();
    
    $statistics = [
        'total_posts' => $ong->posts()->count(),
        'total_views' => 0,
        'total_comments' => $this->getTotalComments($ong),
        'total_likes' => $this->getTotalLikes($ong),
        'posts_per_month' => $this->getPostsByMonth($ong),
        'most_commented_posts' => $this->getMostCommentedPosts($ong),
        'most_liked_posts' => $this->getMostLikedPosts($ong),
        'best_performing_categories' => $this->getBestPerformingCategories($ong),
    ];
    
    return view('ong.statistics', compact('statistics'));
}



    
    /**
     * Exibir todos os posts da ONG
     */
    public function allPosts()
    {
        $ong = Auth::guard('ong')->user();
        $posts = $ong->posts()->withCount('comments')->latest()->paginate(10);
        
        return view('ong.posts.index', compact('posts'));
    }

    /**
     * Exibir lista de seguidores
     */
    public function followers()
    {
        $ong = Auth::guard('ong')->user();
        // Implementar depois
        $followers = [];
        
        return view('ong.followers', compact('followers'));
    }

    /**
     * Métodos privados para cálculos
     */
    private function getTotalComments($ong)
    {
        $total = 0;
        foreach ($ong->posts as $post) {
            $total += $post->comments()->count();
        }
        return $total;
    }

    private function getTotalLikes($ong)
    {
        $total = 0;
        foreach ($ong->posts as $post) {
            $total += $post->likes()->count();
        }
        return $total;
    }
    private function getMostCommentedPosts($ong)
    {
        return $ong->posts()
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();
    }
    private function getMostLikedPosts($ong)
    {
        return $ong->posts()
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->get();
    }

    private function getRecentActivities($ong)
    {
        $activities = [];
        
        // Últimos posts criados
        foreach ($ong->posts()->latest()->take(5)->get() as $post) {
            $activities[] = [
                'type' => 'post',
                'description' => "Novo post criado: {$post->title}",
                'date' => $post->created_at,
                'icon' => 'fas fa-newspaper',
                'color' => 'primary'
            ];
        }
        
        // Ordenar por data
        usort($activities, function($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });
        
        return array_slice($activities, 0, 10);
    }

    private function getPostsByMonth($ong)
    {
        return $ong->posts()
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    private function getCommentsByPost($ong)
    {
        return $ong->posts()
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();
    }

    private function calculateEngagementRate($ong)
    {
        // Implementar depois
        return 0;
    }



private function getBestPerformingCategories($ong)
{
    $results = DB::select("
        SELECT 
            category,
            COUNT(*) as total_posts,
            (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as total_comments
        FROM posts
        WHERE ong_id = ?
        GROUP BY category
        ORDER BY total_comments DESC
    ", [$ong->id]);
    
    return collect($results);
}

}