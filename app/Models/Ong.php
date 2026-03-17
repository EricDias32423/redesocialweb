<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ong extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'ongs';
    
    protected $fillable = [
        'responsible_name', 'ong_name', 'email', 'password', 
        'cnpj', 'description', 'logo', 'address', 'phone', 
        'website', 'social_media', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_media' => 'array',
    ];

    // Relacionamentos
    public function posts()
    {
        return $this->hasMany(Post::class, 'ong_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    // Dentro da classe Ong, adicione:
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function likes()
    {
    return $this->morphMany(Like::class, 'likable');
    }
}