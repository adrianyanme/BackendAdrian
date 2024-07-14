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
        Schema::create('gugatansederhanalangsung', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nohp');
            $table->string('nama_pengugat');
            $table->string('nama_tergugat');
            $table->string('penjelasan');
            $table->string('tuntutan_pengugat');
            $table->string('lampiran');
            $table->string('author');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gugatansederhanalangsung');
    }
};
