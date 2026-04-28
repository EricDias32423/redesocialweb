<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\OngController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\CachedController;

Route::get('/health', function() {
    return response()->json(['status' => 'ok']);
});


// Autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Posts públicos
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);

// Comentários públicos
Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
Route::get('/comments/{comment}', [CommentController::class, 'show']);

// ONGs públicas
Route::get('/ongs', [OngController::class, 'index']);
Route::get('/ongs/{ong}', [OngController::class, 'show']);
Route::get('/ongs/{ong}/posts', [OngController::class, 'posts']);

// Busca pública
Route::get('/search', [SearchController::class, 'index']);
Route::get('/search/ongs', [SearchController::class, 'ongs']);
Route::get('/search/posts', [SearchController::class, 'posts']);

// Estatísticas públicas
Route::get('/stats/overview', [StatsController::class, 'overview']);
Route::get('/stats/categories', [StatsController::class, 'categories']);

// ===========================================
// ROTAS PROTEGIDAS (requerem token Sanctum)
// ===========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'update']);
    Route::delete('/me', [AuthController::class, 'destroy']);
    
    // Usuário
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::post('/user/avatar', [UserController::class, 'uploadAvatar']);
    Route::delete('/user/avatar', [UserController::class, 'removeAvatar']);
    Route::get('/user/activities', [UserController::class, 'activities']);
    
    // Posts (CRUD)
    Route::get('/my-posts', [PostController::class, 'myPosts']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    
    // Comentários
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    Route::get('/my-comments', [CommentController::class, 'myComments']);
    
    // Curtidas
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']);
    Route::get('/my-likes', [LikeController::class, 'myLikes']);
    
    // ONGs (para usuários comuns)
    Route::get('/my-ongs', [OngController::class, 'mySupportedOngs']);
    Route::post('/ongs/{ong}/support', [OngController::class, 'support']);
    Route::delete('/ongs/{ong}/unsupport', [OngController::class, 'unsupport']);
    
    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/activities', [DashboardController::class, 'activities']);
    Route::get('/dashboard/recommendations', [DashboardController::class, 'recommendations']);
    
    // Notificações
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    
    // Uploads
    Route::post('/upload/image', [UploadController::class, 'image']);
    Route::post('/upload/file', [UploadController::class, 'file']);
});

// ===========================================
// ROTAS ESPECÍFICAS PARA ONGs (API)
// ===========================================
Route::middleware(['auth:sanctum', 'ability:ong'])->prefix('ong')->name('api.ong.')->group(function () {
    
    // Estatísticas avançadas
    Route::get('/analytics', [OngController::class, 'analytics']);
    Route::get('/analytics/posts', [OngController::class, 'postAnalytics']);
    Route::get('/analytics/followers', [OngController::class, 'followerAnalytics']);
    
    // Gerenciamento de posts
    Route::get('/posts/stats', [OngController::class, 'postStats']);
    Route::get('/posts/{post}/stats', [OngController::class, 'singlePostStats']);
    
    // Exportação de dados
    Route::get('/export/followers', [OngController::class, 'exportFollowers']);
    Route::get('/export/posts', [OngController::class, 'exportPosts']);
    
    // Configurações da ONG
    Route::get('/settings', [OngController::class, 'settings']);
    Route::put('/settings', [OngController::class, 'updateSettings']);
});

// ===========================================
// ROTAS DE TESTE (apenas desenvolvimento)
// ===========================================
if (app()->environment('local')) {
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working!']);
    });
}



// Rotas com cache
Route::get('/feed', [CachedController::class, 'feed']);
Route::get('/posts/{id}', [CachedController::class, 'post']);
Route::get('/ongs', [CachedController::class, 'ongs']);
Route::get('/ongs/{id}', [CachedController::class, 'ong']);
Route::get('/dashboard/stats', [CachedController::class, 'dashboardStats'])->middleware('auth:sanctum');

// Rotas para invalidar cache
Route::post('/feed/invalidate', [CachedController::class, 'invalidateFeed']);
Route::post('/posts/invalidate', [CachedController::class, 'invalidateOnNewPost'])->middleware('auth:ong');