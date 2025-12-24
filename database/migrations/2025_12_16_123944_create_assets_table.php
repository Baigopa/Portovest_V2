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
    Schema::create('assets', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('logo_url')->nullable();
        $table->enum('asset_type', ['stock', 'crypto', 'mf']); // mf = mutual fund
        $table->decimal('quantity', 15, 4);
        $table->decimal('purchase_price', 15, 2);
        $table->date('purchase_date');
        $table->softDeletes();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
