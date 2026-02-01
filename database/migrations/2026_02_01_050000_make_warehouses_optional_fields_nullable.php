<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('warehouses')) {
            return;
        }

        DB::statement("ALTER TABLE `warehouses` MODIFY `name` VARCHAR(191) NULL");
        DB::statement("ALTER TABLE `warehouses` MODIFY `status` TINYINT(1) NULL DEFAULT 0");
    }

    public function down(): void
    {
        if (!Schema::hasTable('warehouses')) {
            return;
        }

        DB::statement("ALTER TABLE `warehouses` MODIFY `name` VARCHAR(191) NOT NULL");
        DB::statement("ALTER TABLE `warehouses` MODIFY `status` TINYINT(1) NOT NULL");
    }
};
