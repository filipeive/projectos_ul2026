<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('docente')->after('password');
        });

        Schema::table('candidaturas', function (Blueprint $table) {
            $table->foreignId('docente_id')->nullable()->constrained('users')->nullOnDelete()->after('status');
        });

        Schema::table('workspace_messages', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('workspace_messages', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropForeign(['docente_id']);
            $table->dropColumn('docente_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
