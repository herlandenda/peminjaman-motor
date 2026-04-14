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
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel Customers dan Motors
        $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
        $table->foreignId('motor_id')->constrained('motors')->cascadeOnDelete();
        
        // Data Waktu
        $table->dateTime('loan_date');
        $table->dateTime('return_date_plan');
        $table->dateTime('return_date_actual')->nullable(); // Diisi saat motor kembali
        
        // Kondisi Awal (Saat form peminjaman diisi)
        $table->integer('start_km');
        $table->string('start_condition_tires')->nullable();
        $table->string('start_condition_brakes')->nullable();
        $table->string('start_condition_lights')->nullable();
        $table->string('start_condition_mirrors')->nullable();
        $table->string('start_fuel_level')->nullable();
        $table->string('start_photo_motor')->nullable();
        $table->text('agreement_note')->nullable(); // Pertanggungjawaban
        
        // Kondisi Akhir (Saat form pengembalian diisi, boleh kosong di awal)
        $table->integer('end_km')->nullable();
        $table->string('end_condition_tires')->nullable();
        $table->string('end_condition_brakes')->nullable();
        $table->string('end_condition_lights')->nullable();
        $table->string('end_condition_mirrors')->nullable();
        $table->string('end_fuel_level')->nullable();
        $table->string('end_photo_motor')->nullable();
        // Kondisi Motor Opsional
        $table->string('photo_right')->nullable();
        $table->string('photo_left')->nullable();
        $table->string('photo_front')->nullable();
        $table->string('photo_back')->nullable();
        
        // Status dan Denda
        $table->integer('fine_amount')->default(0);
        $table->enum('status', ['pending', 'active', 'returned'])->default('pending');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
