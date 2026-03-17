<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'ong_id',
        'title',
        'content',
        'category',
        'image',
        'views'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function ong()
    {
        return $this->belongsTo(Ong::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
    return $this->hasMany(Like::class);
    }

    public function likesCount()
    {
    return $this->likes()->count();
    }
}