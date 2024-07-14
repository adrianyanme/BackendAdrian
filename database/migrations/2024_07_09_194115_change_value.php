<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jdh', function (Blueprint $table) {
            $table->text('deskripsi')->change(); // Mengubah tipe kolom menjadi TEXT
        });
    }

    public function down()
    {
        Schema::table('jdh', function (Blueprint $table) {
            $table->string('deskripsi', 9999)->change(); // Mengembalikan tipe kolom menjadi VARCHAR(255)
        });
    }
};
