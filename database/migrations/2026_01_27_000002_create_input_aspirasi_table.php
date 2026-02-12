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
        if (!Schema::hasTable('input_aspirasi')) {
            Schema::create('input_aspirasi', function (Blueprint $table) {
                $table->id();
                $table->string('nis', 10)->nullable();
                $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
                $table->string('lokasi', 50)->nullable();
                $table->string('ket', 50)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('input_aspirasi')) {
            Schema::dropIfExists('input_aspirasi');
        }
    }
};
