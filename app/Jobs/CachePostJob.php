<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CachePostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function handle(): void
    {
        $post = Post::with(['ong' => function($q) {
                $q->select('id', 'ong_name', 'logo', 'email', 'description');
            }])
            ->withCount('likes', 'comments')
            ->find($this->postId);

        Cache::put("post_{$this->postId}", $post, 3600);
    }
}