<?php

namespace App\Jobs;

use App\Models\Ong;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CacheOngJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $ongId;

    public function __construct($ongId)
    {
        $this->ongId = $ongId;
    }

    public function handle(): void
    {
        $ong = Ong::withCount('posts', 'supporters')
            ->with(['posts' => function($q) {
                $q->latest()->take(5);
            }])
            ->find($this->ongId);

        Cache::put("ong_{$this->ongId}", $ong, 3600);
    }
}