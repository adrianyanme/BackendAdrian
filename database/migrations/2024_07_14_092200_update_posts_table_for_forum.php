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
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'forum_content')) {
                $table->string('forum_content')->nullable(); // Tambahkan kolom baru
            }
            if (!Schema::hasColumn('posts', 'tag')) {
                $table->string('tag')->nullable();
            }
        });

        // Pindahkan data dari kolom lama ke kolom baru
        DB::statement('UPDATE posts SET forum_content = news_content');

        // Hapus kolom lama
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'news_content')) {
                $table->dropColumn('news_content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'news_content')) {
                $table->string('news_content')->nullable(); // Tambahkan kolom lama kembali
            }
        });

        // Pindahkan data dari kolom baru ke kolom lama
        DB::statement('UPDATE posts SET news_content = forum_content');

        // Hapus kolom baru
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'forum_content')) {
                $table->dropColumn('forum_content');
            }
            if (Schema::hasColumn('posts', 'tag')) {
            $table->dropColumn('forum_content');
            $table->dropColumn('tag');
            }
        });
    }
};