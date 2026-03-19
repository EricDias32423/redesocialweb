<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ong_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ong_id')->constrained()->onDelete('cascade');
            $table->foreignId('regular_user_id')->constrained('regular_users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['ong_id', 'regular_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ong_user');
    }
};