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
    Schema::create('motors', function (Blueprint $table) {
        $table->id();
        $table->string('brand'); // Contoh: Kawasaki
        $table->string('model'); // Contoh: W175 Kuning
        $table->string('plate_number')->unique();
        $table->string('color')->nullable();
        $table->string('stnk_image')->nullable();
        $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
