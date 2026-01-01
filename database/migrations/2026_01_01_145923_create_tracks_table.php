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
    Schema::create('tracks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('artist');
        $table->string('category'); // Ex: Zouk, Compas, Salsa
        $table->string('file_path'); // Chemin vers le fichier audio
        $table->string('image_path')->nullable(); // Chemin vers l'image de la pochette
        $table->string('duration')->nullable(); // Ex: 3:45
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
