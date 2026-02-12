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
            if (!Schema::hasColumn('pengaduans', 'aspek')) {
                $table->string('aspek')->nullable()->after('pelapor');
            }
            if (!Schema::hasColumn('pengaduans', 'sub_aspek')) {
                $table->string('sub_aspek')->nullable()->after('aspek');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            if (Schema::hasColumn('pengaduans', 'sub_aspek')) {
                $table->dropColumn('sub_aspek');
            }
            if (Schema::hasColumn('pengaduans', 'aspek')) {
                $table->dropColumn('aspek');
            }
        });
    }
};
