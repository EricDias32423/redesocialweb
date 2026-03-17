<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'likable_type',
        'likable_id',
        'post_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the parent likable model (user or ong).
     */
    public function likable()
    {
        return $this->morphTo();
    }

    /**
     * Get the post that was liked.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Check if the like was made by a regular user.
     */
    public function isFromRegularUser(): bool
    {
        return $this->likable_type === RegularUser::class;
    }

    /**
     * Check if the like was made by an ONG.
     */
    public function isFromOng(): bool
    {
        return $this->likable_type === Ong::class;
    }

    /**
     * Get the author of the like.
     */
    public function getAuthorAttribute()
    {
        if ($this->isFromRegularUser()) {
            $user = RegularUser::find($this->likable_id);
            return $user ? $user->name : 'Usuário removido';
        }
        
        if ($this->isFromOng()) {
            $ong = Ong::find($this->likable_id);
            return $ong ? $ong->ong_name : 'ONG removida';
        }
        
        return 'Autor desconhecido';
    }
}