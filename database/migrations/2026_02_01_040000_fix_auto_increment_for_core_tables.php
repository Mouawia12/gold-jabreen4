<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'items',
            'karats',
            'items_collectibles',
            'exit_works',
            'exit_work_details',
            'exit_olds',
            'exit_old_details',
            'enter_money',
            'exit_money',
            'enter_works',
            'enter_work_details',
            'enter_olds',
            'enter_old_details',
            'company_movements',
            'warehouses',
        ];

        foreach ($tables as $table) {
            $this->ensureAutoIncrementId($table);
        }
    }

    public function down(): void
    {
        // No-op: keep IDs auto-incrementing once fixed.
    }

    private function ensureAutoIncrementId(string $table): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'id')) {
            return;
        }

        $hasPrimaryKey = DB::selectOne(
            "SELECT COUNT(*) AS c
             FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_TYPE = 'PRIMARY KEY'",
            [$table]
        );

        if (!$hasPrimaryKey || (int) ($hasPrimaryKey->c ?? 0) === 0) {
            DB::statement("ALTER TABLE `{$table}` ADD PRIMARY KEY (`id`)");
        }

        DB::statement("ALTER TABLE `{$table}` MODIFY `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT");
    }
};
