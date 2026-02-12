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
        if (!Schema::hasTable('aspirasis')) {
            Schema::create('aspirasis', function (Blueprint $table) {
                $table->id('id_aspirasi');
                $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
                $table->string('id_pelaporan')->nullable();
                $table->string('lokasi', 50)->nullable();
                $table->string('ket', 50)->nullable();
                $table->enum('status', ['Menunggu','Proses','Selesai'])->default('Menunggu');
                $table->text('feedback')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('aspirasis')) {
            Schema::dropIfExists('aspirasis');
        }
    }
};
