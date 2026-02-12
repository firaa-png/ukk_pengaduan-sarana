<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'Menunggu' to the status enum. Using raw statement because changing enums
        // is database-specific and not directly supported by the schema builder.
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` ENUM('Dalam Proses','Selesai','Menunggu') NOT NULL DEFAULT 'Dalam Proses'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` ENUM('Dalam Proses','Selesai') NOT NULL DEFAULT 'Dalam Proses'");
    }
};
