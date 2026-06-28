<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('workspace_messages')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE workspace_messages MODIFY sender_type ENUM('student', 'mentor', 'ai') NOT NULL DEFAULT 'student'");
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            $this->rebuildSqliteTable();
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('workspace_messages')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE workspace_messages MODIFY sender_type ENUM('student', 'mentor') NOT NULL DEFAULT 'student'");
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::table('workspace_messages')
                ->where('sender_type', 'ai')
                ->update(['sender_type' => 'mentor']);

            $this->rebuildSqliteTable();
        }
    }

    private function rebuildSqliteTable(): void
    {
        $hasIsRead = Schema::hasColumn('workspace_messages', 'is_read');
        Schema::disableForeignKeyConstraints();
        Schema::rename('workspace_messages', 'workspace_messages_old');

        Schema::create('workspace_messages', function ($table) use ($hasIsRead) {
            $table->id();
            $table->foreignId('candidatura_id')->constrained('candidaturas')->onDelete('cascade');
            $table->string('sender_type')->default('student');
            $table->text('message');
            if ($hasIsRead) {
                $table->boolean('is_read')->default(false);
            }
            $table->timestamps();
        });

        $columns = 'id, candidatura_id, sender_type, message, created_at, updated_at';
        if ($hasIsRead) {
            $columns = 'id, candidatura_id, sender_type, message, is_read, created_at, updated_at';
        }

        DB::statement("INSERT INTO workspace_messages ({$columns}) SELECT {$columns} FROM workspace_messages_old");
        Schema::drop('workspace_messages_old');
        Schema::enableForeignKeyConstraints();
    }
};
