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
    if (!Schema::hasTable('comments')) {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();

            $table->index(['commentable_type', 'commentable_id']);
        });
    } else {
        // Se a tabela já existe, apenas adiciona o índice se não existir
        Schema::table('comments', function (Blueprint $table) {
            $table->index(['commentable_type', 'commentable_id']);
        });
    }
}
};