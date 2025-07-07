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
        Schema::table('amelia_borrowings', function (Blueprint $table) {
            $table->date('tanggal_pinjam')->nullable();
        $table->date('tanggal_kembali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amelia_borrowings', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pinjam', 'tanggal_kembali']);
        });
    }
};
