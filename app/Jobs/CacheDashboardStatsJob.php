<?php

namespace App\Jobs;

use App\Models\Ong;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CacheDashboardStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $ongId;

    public function __construct($ongId)
    {
        $this->ongId = $ongId;
    }

    public function handle(): void
    {
        $ong = Ong::find($this->ongId);

        $stats = [
            'total_posts' => $ong->posts()->count(),
            'total_comments' => $ong->posts()->withCount('comments')->get()->sum('comments_count'),
            'total_likes' => $ong->posts()->withCount('likes')->get()->sum('likes_count'),
            'total_supporters' => $ong->supporters()->count(),
            'posts_last_week' => $ong->posts()->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        Cache::put("dashboard_stats_{$this->ongId}", $stats, 3600);
    }
}