<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique(); // Syarat wajib tadi
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke User
        $table->foreignId('asset_id')->constrained()->onDelete('cascade'); // Relasi ke Asset
        $table->enum('type', ['buy', 'sell']); // Beli atau Jual
        $table->decimal('amount', 15, 2); // Jumlah lembar/unit yg ditransaksikan
        $table->decimal('price_per_unit', 15, 2); // Harga saat transaksi
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
