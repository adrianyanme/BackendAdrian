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
        Schema::create('jdh', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('nomor');
            $table->string('tahun');
            $table->string('kategoridokumen');
            $table->string('jenis');
            $table->string('tanggalditetapkan');
            $table->string('tanggaldiundangkan');
            $table->string('status');
            $table->string('sumber');
            $table->string('keterangan');
            $table->string('lampiran');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jdh');
    }
};
