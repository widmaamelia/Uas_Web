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
        Schema::create('amelia_borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('amelia_books')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('amelia_members')->onDelete('cascade');
            $table->date('tanggal_pinjam'); // sebelumnya borrowed_at
            $table->date('tanggal_kembali')->nullable(); // sebelumnya returned_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amelia_borrowings');
    }
};
