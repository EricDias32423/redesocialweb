<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type'); // 'regular_user' ou 'ong'
            $table->text('content');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');

            // Índices para buscar mensagens rápido
            $table->index(['conversation_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
