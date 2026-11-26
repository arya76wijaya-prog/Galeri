<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->string('session_id')->nullable()->index();
            $table->unique(['session_id', 'photo_id'])->whereNotNull('session_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->string('session_id')->nullable()->index();
            $table->unique(['session_id', 'photo_id'])->whereNotNull('session_id');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->string('session_id')->nullable()->index();
            $table->unique(['session_id', 'photo_id'])->whereNotNull('session_id');
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropUnique(['session_id', 'photo_id']);
            $table->dropColumn('session_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropUnique(['session_id', 'photo_id']);
            $table->dropColumn('session_id');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropUnique(['session_id', 'photo_id']);
            $table->dropColumn('session_id');
        });
    }
};
