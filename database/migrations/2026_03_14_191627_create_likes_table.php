<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            
            // Quem curtiu (pode ser usuário comum ou ONG)
            $table->morphs('likable'); // likable_type e likable_id
            
            // Post que recebeu a curtida
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();

            // Evita curtidas duplicadas (um usuário curtir o mesmo post mais de uma vez)
            $table->unique(['likable_type', 'likable_id', 'post_id'], 'unique_like');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};