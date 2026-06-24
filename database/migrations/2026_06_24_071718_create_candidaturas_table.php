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
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->integer('project_number');
            $table->string('project_name');
            $table->string('technology');
            $table->string('mentor')->nullable();
            
            // Members (minimum 2, maximum 4)
            $table->string('member1_name');
            $table->string('member1_code');
            $table->string('member2_name');
            $table->string('member2_code');
            $table->string('member3_name')->nullable();
            $table->string('member3_code')->nullable();
            $table->string('member4_name')->nullable();
            $table->string('member4_code')->nullable();
            
            $table->text('rationale')->nullable();
            $table->string('status')->default('Pendente'); // Pendente, Aprovado, Rejeitado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }
};
