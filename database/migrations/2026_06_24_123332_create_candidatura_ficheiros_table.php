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
        Schema::create('candidatura_ficheiros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidatura_id')->constrained()->onDelete('cascade');
            $table->string('nome_ficheiro');
            $table->string('caminho');
            $table->integer('tamanho_bytes')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatura_ficheiros');
    }
};
