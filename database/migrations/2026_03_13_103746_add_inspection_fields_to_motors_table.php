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
        Schema::table('motors', function (Blueprint $table) {
        // Menyisipkan tipe data JSON untuk multi-pilihan alert dan text untuk catatan
        $table->json('inspection_alerts')->nullable()->after('status');
        $table->text('inspection_notes')->nullable()->after('inspection_alerts');

        $table->text('additional_notes')->nullable()->after('inspection_notes'); // Catatan tambahan untuk kondisi motor, bisa diisi oleh admin saat inspeksi atau update kondisi motor     
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motors', function (Blueprint $table) {
        $table->dropColumn(['inspection_alerts', 'inspection_notes', 'additional_notes']);
    });
    }
};
