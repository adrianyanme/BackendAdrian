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
        Schema::table('persalinan', function (Blueprint $table) {
            $table->string('namaparapihak')->nullable();
            $table->string('ktppemohon')->nullable();
            $table->string('kkpemohon')->nullable();
            $table->string('relaaspemberitahuanputusan')->nullable();
            $table->string('catatanpemohon')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persalinan', function (Blueprint $table) {
            $table->dropColumn('namaparapihak');
            $table->dropColumn('ktppemohon');
            $table->dropColumn('kkpemohon');
            $table->dropColumn('relaaspemberitahuanputusan');
            $table->dropColumn('catatanpemohon');
        });
    }
};
