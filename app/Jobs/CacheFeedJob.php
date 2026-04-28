<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CacheFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Buscar posts com seus relacionamentos
        $posts = Post::with(['ong' => function($query) {
                $query->select('id', 'ong_name', 'logo', 'email');
            }])
            ->withCount('likes', 'comments')
            ->latest()
            ->take(50) // Limitar para não sobrecarregar
            ->get();

        // Armazenar no cache por 1 hora (3600 segundos)
        Cache::put('feed_posts', $posts, 3600);

        // Também armazenar o timestamp da última atualização
        Cache::put('feed_last_update', now(), 3600);
    }
}