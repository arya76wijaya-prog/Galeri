<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('visitor_id', 64)->nullable();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->unique(['photo_id', 'visitor_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('visitor_id', 64)->nullable();
            $table->unique(['photo_id', 'visitor_id']);
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropUnique(['photo_id', 'visitor_id']);
            $table->dropColumn('visitor_id');
            $table->foreignId('user_id')->nullable(false)->change();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropUnique(['photo_id', 'visitor_id']);
            $table->dropColumn('visitor_id');
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
