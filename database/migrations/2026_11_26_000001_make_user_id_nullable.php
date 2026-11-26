<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->recreateTableForSQLite('likes');
            $this->recreateTableForSQLite('comments');
            $this->recreateTableForSQLite('reports');
        } else {
            Schema::table('likes', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->change();
            });

            Schema::table('comments', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->change();
            });

            Schema::table('reports', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->change();
            });
        }
    }

    public function down(): void
    {
        // Down migration not implemented for SQLite table recreation
    }

    protected function recreateTableForSQLite(string $tableName): void
    {
        $tempTable = $tableName.'_temp';
        $columns = Schema::getColumnListing($tableName);

        Schema::create($tempTable, function (Blueprint $table) use ($columns) {
            $table->id();

            if (in_array('user_id', $columns)) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            }

            if (in_array('session_id', $columns)) {
                $table->string('session_id')->nullable();
            }

            if (in_array('photo_id', $columns)) {
                $table->foreignId('photo_id')->constrained()->cascadeOnDelete();
            }

            if (in_array('content', $columns)) {
                $table->text('content');
            }

            if (in_array('status', $columns)) {
                $table->string('status', 20)->default('pending')->index();
            }

            if (in_array('reason', $columns)) {
                $table->string('reason');
            }

            if (in_array('description', $columns)) {
                $table->text('description')->nullable();
            }

            if (in_array('reviewed_by', $columns)) {
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            }

            if (in_array('reviewed_at', $columns)) {
                $table->timestamp('reviewed_at')->nullable();
            }

            $table->timestamps();

            if (in_array('user_id', $columns) && in_array('photo_id', $columns)) {
                $table->unique(['user_id', 'photo_id']);
            }

            if (in_array('session_id', $columns) && in_array('photo_id', $columns)) {
                $table->unique(['session_id', 'photo_id'])->whereNotNull('session_id');
            }
        });

        $columnList = implode(', ', array_map(fn ($col) => '"'.$col.'"', $columns));
        DB::statement('INSERT INTO "'.$tempTable.'" ('.$columnList.') SELECT '.$columnList.' FROM "'.$tableName.'"');

        Schema::drop($tableName);
        Schema::rename($tempTable, $tableName);
    }
};
