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
            Schema::table('amelia_members', function (Blueprint $table) {
        $table->string('nim')->nullable()->change();
    });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amelia_members', function (Blueprint $table) {
            //
        });
    }
};
