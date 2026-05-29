<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Auth\RegularUserAuthController;
use App\Http\Controllers\Auth\OngAuthController;
use App\Http\Controllers\Profile\RegularUserProfileController;
use App\Http\Controllers\Profile\OngProfileController;
use App\Http\Controllers\Dashboard\RegularUserDashboardController;
use App\Http\Controllers\Dashboard\OngDashboardController;
use App\Http\Controllers\Regular\OngController as RegularOngController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\API\CommentController as ApiCommentController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\ChatController;

Route::middleware('guest')->group(function () {
    Route::get('/verify-2fa', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
    Route::post('/verify-2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify.submit');
    Route::post('/resend-2fa', [TwoFactorController::class, 'resend'])->name('2fa.resend');
});

// ===========================================
// ROTAS DE COMENTÁRIOS (qualquer usuário logado)
// ===========================================
Route::middleware('auth:regular,ong')->group(function () {
    
    Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Rota de like
    Route::post('/posts/{post}/like', [App\Http\Controllers\Web\PostController::class, 'like'])->name('posts.like');
});
// ===========================================
// ROTAS PÚBLICAS
// ===========================================
Route::get('/', function () {
    if (auth()->guard('regular')->check()) {
        return redirect()->route('regular.dashboard');
    }
    if (auth()->guard('ong')->check()) {
        return redirect()->route('ong.dashboard');
    }
    return view('auth.choose-role');
})->name('home');

Route::get('/choose-role', function() {
    return view('auth.choose-role');
})->name('choose.role');

// ===========================================
// ROTAS PARA USUÁRIOS COMUNS
// ===========================================
Route::prefix('regular')->name('regular.')->group(function () {
    
    // Rotas de autenticação (guest)
    Route::middleware('guest:regular')->group(function () {
        Route::get('/login', [RegularUserAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [RegularUserAuthController::class, 'login']);
        Route::get('/register', [RegularUserAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [RegularUserAuthController::class, 'register']);
    });

    // Rotas protegidas (auth)
    Route::middleware('auth:regular')->group(function () {
        Route::post('/logout', [RegularUserAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [RegularUserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [RegularUserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [RegularUserProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [RegularUserProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/avatar', [RegularUserProfileController::class, 'uploadAvatar'])->name('profile.avatar');
        Route::delete('/profile/avatar', [RegularUserProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');
        Route::get('/ongs', [RegularOngController::class, 'index'])->name('ongs.index');
        Route::get('/ongs/{ong}', [RegularOngController::class, 'show'])->name('ongs.show');
        Route::post('/ongs/{ong}/support', [RegularOngController::class, 'support'])->name('ongs.support');
        Route::delete('/ongs/{ong}/unsupport', [RegularOngController::class, 'unsupport'])->name('ongs.unsupport');
        Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/profile/enable-2fa', [RegularUserProfileController::class, 'enableTwoFactor'])->name('profile.enable-2fa');
        Route::post('/profile/disable-2fa', [RegularUserProfileController::class, 'disableTwoFactor'])->name('profile.disable-2fa');
        
        // Rotas de chat
        Route::get('/messages', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/messages/{conversation}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/messages/{conversation}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
        Route::post('/messages/start', [ChatController::class, 'startChat'])->name('chat.start');
        Route::get('/messages/{conversation}/api', [ChatController::class, 'getMessages'])->name('chat.api');
    });
});

// ===========================================
// ROTAS PARA ONGS
// ===========================================
Route::prefix('ong')->name('ong.')->group(function () {
    
    // Rotas de autenticação (guest)
    Route::middleware('guest:ong')->group(function () {
        Route::get('/login', [OngAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [OngAuthController::class, 'login']);
        Route::get('/register', [OngAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [OngAuthController::class, 'register']);
    });

    // Rotas protegidas (auth)
    Route::middleware('auth:ong')->group(function () {

        Route::post('/logout', [OngAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [OngDashboardController::class, 'index'])->name('dashboard');
        Route::get('/statistics', [OngDashboardController::class, 'engagementAnalytics'])->name('statistics');
        Route::get('/profile', [OngProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [OngProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [OngProfileController::class, 'destroy'])->name('profile.destroy'); 
        Route::post('/profile/logo', [OngProfileController::class, 'uploadLogo'])->name('profile.logo');
        Route::delete('/profile/logo', [OngProfileController::class, 'removeLogo'])->name('profile.logo.remove');
        Route::post('/profile/enable-2fa', [OngProfileController::class, 'enableTwoFactor'])->name('profile.enable-2fa');
        Route::post('/profile/disable-2fa', [OngProfileController::class, 'disableTwoFactor'])->name('profile.disable-2fa');
        Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        
        // Rotas de chat
        Route::get('/messages', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/messages/{conversation}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/messages/{conversation}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
        Route::get('/messages/{conversation}/api', [ChatController::class, 'getMessages'])->name('chat.api');
    });
});

// ===========================================
// ROTAS DE POSTS PARA ONGS (UMA ÚNICA VEZ, FORA DO PREFIXO)
// ===========================================
Route::middleware('auth:ong')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('my-posts');
});

// ===========================================
// ROTAS DE POSTS PÚBLICAS
// ===========================================
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/comments', [App\Http\Controllers\Api\CommentController::class, 'index'])->name('comments.index');

// No final do web.php, adicione uma rota fallback
Route::get('/login', function () {
    return redirect()->route('regular.login');
})->name('login');

// Password reset pages (web)
Route::get('/password/forgot', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/password/reset-code', function () {
    return view('auth.reset-password-code');
})->name('password.reset.code');
