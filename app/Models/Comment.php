<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'post_id',
        'content',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the parent commentable model (user or ong).
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope para comentários aprovados
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope para comentários pendentes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Verificar se o comentário foi feito por um usuário comum
     */
    public function isFromRegularUser(): bool
    {
        return $this->commentable_type === RegularUser::class;
    }

    /**
     * Verificar se o comentário foi feito por uma ONG
     */
    public function isFromOng(): bool
    {
        return $this->commentable_type === Ong::class;
    }

    /**
     * Obter o autor do comentário
     */
    public function getAuthorAttribute()
    {
        if ($this->isFromRegularUser()) {
            $user = RegularUser::find($this->commentable_id);
            return $user ? $user->name : 'Usuário removido';
        }
        
        if ($this->isFromOng()) {
            $ong = Ong::find($this->commentable_id);
            return $ong ? $ong->ong_name : 'ONG removida';
        }
        
        return 'Autor desconhecido';
    }

    /**
     * Obter avatar do autor
     */
    public function getAuthorAvatarAttribute()
    {
        if ($this->isFromRegularUser()) {
            $user = RegularUser::find($this->commentable_id);
            return $user ? $user->avatar : null;
        }
        
        if ($this->isFromOng()) {
            $ong = Ong::find($this->commentable_id);
            return $ong ? $ong->logo : null;
        }
        
        return null;
    }
}