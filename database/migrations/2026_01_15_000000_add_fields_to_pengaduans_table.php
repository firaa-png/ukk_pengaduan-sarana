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
        Schema::table('pengaduans', function (Blueprint $table) {
            if (!Schema::hasColumn('pengaduans', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('pengaduans', 'gambar')) {
                $table->string('gambar')->nullable()->after('lokasi');
            }
            if (!Schema::hasColumn('pengaduans', 'siswa_id')) {
                $table->foreignId('siswa_id')->nullable()->after('pelapor')->constrained('siswas')->nullOnDelete();
            }
            if (!Schema::hasColumn('pengaduans', 'feedback')) {
                $table->text('feedback')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            if (Schema::hasColumn('pengaduans', 'feedback')) {
                $table->dropColumn('feedback');
            }
            if (Schema::hasColumn('pengaduans', 'siswa_id')) {
                $table->dropForeign(['siswa_id']);
                $table->dropColumn('siswa_id');
            }
            if (Schema::hasColumn('pengaduans', 'gambar')) {
                $table->dropColumn('gambar');
            }
            if (Schema::hasColumn('pengaduans', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
        });
    }
};
