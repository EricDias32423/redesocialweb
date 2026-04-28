<?php

use App\Jobs\CacheFeedJob;
use App\Jobs\CacheOngsJob;
use App\Jobs\CacheDashboardStatsJob;
use App\Models\Ong;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule; // ← CORRIGIDO!

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Habilita CORS para rotas da API
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Atualizar cache do feed a cada 30 minutos
        $schedule->job(new CacheFeedJob())->everyThirtyMinutes();
        
        // Atualizar cache da lista de ONGs a cada 30 minutos
        $schedule->job(new CacheOngsJob())->everyThirtyMinutes();
        
        // Atualizar estatísticas do dashboard de todas as ONGs a cada hora
        $schedule->call(function () {
            $ongs = Ong::all();
            foreach ($ongs as $ong) {
                dispatch(new CacheDashboardStatsJob($ong->id));
            }
        })->hourly();
    })
    ->create();