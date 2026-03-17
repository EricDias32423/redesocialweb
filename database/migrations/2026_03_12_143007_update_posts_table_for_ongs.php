<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Remover user_id e adicionar ong_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->foreignId('ong_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['ong_id']);
            $table->dropColumn('ong_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }
};