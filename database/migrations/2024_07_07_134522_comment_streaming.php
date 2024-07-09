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
        Schema::create('comments_streaming', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('streaming_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comments_content');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('streaming_id')->references('id')->on('streaming');
            $table->foreign('user_id')->references('id')->on('users');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_streaming');
    }
};
