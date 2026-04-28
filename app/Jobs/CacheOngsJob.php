<?php

namespace App\Jobs;

use App\Models\Ong;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CacheOngsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function handle(): void
    {
        $ongs = Ong::withCount('posts', 'supporters')
            ->latest()
            ->paginate(12);

        Cache::put('ongs_list', $ongs, 3600);
    }
}