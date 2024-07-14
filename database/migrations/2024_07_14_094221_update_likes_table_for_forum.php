<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            if (!Schema::hasColumn('likes', 'forum_id')) {
                $table->unsignedBigInteger('forum_id')->nullable();
            }
        });

        // Pindahkan data dari kolom lama ke kolom baru
        DB::statement('UPDATE likes SET forum_id = post_id');

        // Hapus foreign key constraint dan kolom lama
        Schema::table('likes', function (Blueprint $table) {
            if (Schema::hasColumn('likes', 'post_id')) {
                $table->dropForeign(['post_id']);
                $table->dropColumn('post_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            if (!Schema::hasColumn('likes', 'post_id')) {
                $table->unsignedBigInteger('post_id')->nullable();
            }
        });

        // Pindahkan data dari kolom baru ke kolom lama
        DB::statement('UPDATE likes SET post_id = forum_id');

        // Hapus kolom baru dan tambahkan foreign key constraint kembali
        Schema::table('likes', function (Blueprint $table) {
            if (Schema::hasColumn('likes', 'forum_id')) {
                $table->dropColumn('forum_id');
            }
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }
};