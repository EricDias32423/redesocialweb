<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ongs', function (Blueprint $table) {
            $table->id();
            $table->string('responsible_name'); // Nome do responsável
            $table->string('ong_name'); // Nome da ONG
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cnpj')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->json('social_media')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ongs');
    }
};