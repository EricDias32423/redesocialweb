<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'regular_user_id',
        'ong_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function regularUser(): BelongsTo
    {
        return $this->belongsTo(RegularUser::class, 'regular_user_id');
    }

    public function ong(): BelongsTo
    {
        return $this->belongsTo(Ong::class, 'ong_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function lastMessage()
    {
        return $this->messages()
            ->reorder()
            ->latest('created_at')
            ->latest('id')
            ->first();
    }

    public function unreadCountFor($userId, $userType): int
    {
        $senderType = $userType === 'regular' ? 'regular_user' : 'ong';

        return $this->messages()
            ->whereNull('read_at')
            ->where(function ($query) use ($userId, $senderType) {
                $query->where('sender_type', '!=', $senderType)
                    ->orWhere('sender_id', '!=', $userId);
            })
            ->count();
    }
}
