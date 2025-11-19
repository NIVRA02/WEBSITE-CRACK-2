<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Kolom penghubung ke User (siapa yg komen)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // Kolom penghubung ke Game (komen di game apa) -> INI YANG HILANG TADI
            $table->foreignId('game_id')->constrained()->onDelete('cascade'); 
            $table->text('body'); // Isi komentar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};