<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouses', 'type')) {
                $table->integer('type')->default(0)->after('branch_id');
            }
            if (!Schema::hasColumn('warehouses', 'karat_id')) {
                $table->integer('karat_id')->default(0)->after('type');
            }
            if (!Schema::hasColumn('warehouses', 'category_id')) {
                $table->integer('category_id')->default(0)->after('karat_id');
            }
            if (!Schema::hasColumn('warehouses', 'enter_weight')) {
                $table->decimal('enter_weight', 8, 2)->default(0)->after('category_id');
            }
            if (!Schema::hasColumn('warehouses', 'out_weight')) {
                $table->decimal('out_weight', 8, 2)->default(0)->after('enter_weight');
            }
            if (!Schema::hasColumn('warehouses', 'bill_id')) {
                $table->integer('bill_id')->default(0)->after('out_weight');
            }
            if (!Schema::hasColumn('warehouses', 'date')) {
                $table->dateTime('date')->nullable()->after('bill_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            if (Schema::hasColumn('warehouses', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('warehouses', 'bill_id')) {
                $table->dropColumn('bill_id');
            }
            if (Schema::hasColumn('warehouses', 'out_weight')) {
                $table->dropColumn('out_weight');
            }
            if (Schema::hasColumn('warehouses', 'enter_weight')) {
                $table->dropColumn('enter_weight');
            }
            if (Schema::hasColumn('warehouses', 'category_id')) {
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('warehouses', 'karat_id')) {
                $table->dropColumn('karat_id');
            }
            if (Schema::hasColumn('warehouses', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
