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
    Schema::table('assets', function (Blueprint $table) {
        // Kita buat nullable dulu, tapi karena ini DB baru kosong, aman langsung constrained
        $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
    });
    }

public function down(): void
    {
    Schema::table('assets', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
    }
};
