<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS "comments_temp_session_id_photo_id_unique"');
            DB::statement('DROP INDEX IF EXISTS "comments_temp_user_id_photo_id_unique"');
            DB::statement('DROP INDEX IF EXISTS "comments_session_id_photo_id_unique"');
            DB::statement('DROP INDEX IF EXISTS "comments_user_id_photo_id_unique"');

            return;
        }

        Schema::table('comments', function (Blueprint $table) {
            $table->dropUnique(['session_id', 'photo_id']);
            $table->dropUnique(['user_id', 'photo_id']);
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unique(['session_id', 'photo_id']);
            $table->unique(['user_id', 'photo_id']);
        });
    }
};
