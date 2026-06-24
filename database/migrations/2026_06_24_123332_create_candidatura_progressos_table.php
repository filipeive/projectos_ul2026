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
        Schema::create('candidatura_progressos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidatura_id')->constrained()->onDelete('cascade');
            $table->enum('fase', ['sensibilizacao', 'campo', 'mvp', 'exposicao', 'artigo']);
            $table->enum('estado', ['pendente', 'em_progresso', 'concluida'])->default('pendente');
            $table->text('observacao')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatura_progressos');
    }
};
