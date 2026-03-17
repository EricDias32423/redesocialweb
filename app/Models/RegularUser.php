<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RegularUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'regular_users';
    
    protected $fillable = [
        'name', 'email', 'password', 'cpf', 'birth_date', 
        'phone', 'avatar', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    // Relacionamentos
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
    
}