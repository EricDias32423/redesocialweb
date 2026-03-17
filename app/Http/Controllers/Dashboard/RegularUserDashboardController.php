<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegularUserDashboardController extends Controller
{
    /**
     * Exibir dashboard do usuário comum
     */
    public function index()
    {
        $user = Auth::guard('regular')->user();
        
        // Estatísticas para o dashboard
        $stats = [
            'total_ongs_supported' => 0, // Implementar lógica de ONGs apoiadas
            'total_comments' => 0, // Implementar contagem de comentários
            'total_likes_given' => 0, // Implementar contagem de curtidas
            'member_since' => $user->created_at->format('d/m/Y'),
        ];
        
        // Últimas atividades
        $recentActivities = []; // Implementar busca de atividades recentes
        
        // ONGs recomendadas
        $recommendedOngs = []; // Implementar lógica de recomendação
        
        return view('regular.dashboard', compact('user', 'stats', 'recentActivities', 'recommendedOngs'));
    }

    /**
     * Exibir estatísticas detalhadas
     */
    public function statistics()
    {
        $user = Auth::guard('regular')->user();
        
        // Estatísticas mais detalhadas
        $statistics = [
            'comments_by_month' => $this->getCommentsByMonth($user),
            'likes_by_category' => $this->getLikesByCategory($user),
            'most_active_months' => $this->getMostActiveMonths($user),
        ];
        
        return response()->json($statistics);
    }

    /**
     * Exibir histórico de atividades
     */
    public function activityHistory()
    {
        $user = Auth::guard('regular')->user();
        
        $activities = []; // Buscar atividades do usuário
        
        return view('regular.activities', compact('activities'));
    }

    /**
     * Métodos privados para estatísticas
     */
    private function getCommentsByMonth($user)
    {
        // Implementar lógica para buscar comentários por mês
        return [];
    }

    private function getLikesByCategory($user)
    {
        // Implementar lógica para buscar curtidas por categoria
        return [];
    }

    private function getMostActiveMonths($user)
    {
        // Implementar lógica para meses mais ativos
        return [];
    }
}