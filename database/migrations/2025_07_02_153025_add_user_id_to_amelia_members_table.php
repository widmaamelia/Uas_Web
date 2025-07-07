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
        Schema::table('amelia_members', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->after('id')->nullable()->unique();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        // Jika ingin ada relasi foreign key:
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amelia_members', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropUnique(['user_id']);
        $table->dropColumn('user_id');
    });
    }
};
