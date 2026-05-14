<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'content',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com conversa
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Obter o remetente (pode ser um usuário regular ou ONG)
     */
    public function getSender()
    {
        if ($this->sender_type === 'regular_user') {
            return RegularUser::find($this->sender_id);
        } else if ($this->sender_type === 'ong') {
            return Ong::find($this->sender_id);
        }
        return null;
    }

    public function senderName(): string
    {
        $sender = $this->getSender();

        return $sender->name ?? $sender->ong_name ?? 'Contato';
    }

    /**
     * Marcar como lida
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
        return $this;
    }
}
