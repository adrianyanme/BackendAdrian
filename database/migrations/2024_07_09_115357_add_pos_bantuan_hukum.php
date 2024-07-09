<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posbantuanhukum', function (Blueprint $table) {
            $table->id();
            $table->string('namalengkap', 255);
            $table->string('nohp');
            $table->string('email');
            $table->string('deskribsi');
            $table->string('suratgugatan');
            $table->string('suratketerangantidakmampu');
            $table->unsignedBigInteger('author');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('author')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posbantuanhukum');
    }
};
