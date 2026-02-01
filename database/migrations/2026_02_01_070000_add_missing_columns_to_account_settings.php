<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('account_settings', 'purchase_Jewelry_account')) {
                $table->integer('purchase_Jewelry_account')->default(0)->after('purchase_account');
            }
            if (!Schema::hasColumn('account_settings', 'purchase_old_account')) {
                $table->integer('purchase_old_account')->default(0)->after('purchase_Jewelry_account');
            }
            if (!Schema::hasColumn('account_settings', 'purchase_pure_account')) {
                $table->integer('purchase_pure_account')->default(0)->after('purchase_old_account');
            }
            if (!Schema::hasColumn('account_settings', 'stock_Jewelry_account')) {
                $table->integer('stock_Jewelry_account')->default(0)->after('stock_account');
            }
            if (!Schema::hasColumn('account_settings', 'stock_old_account')) {
                $table->integer('stock_old_account')->default(0)->after('stock_Jewelry_account');
            }
            if (!Schema::hasColumn('account_settings', 'stock_pure_account')) {
                $table->integer('stock_pure_account')->default(0)->after('stock_old_account');
            }
            if (!Schema::hasColumn('account_settings', 'stock_under_account')) {
                $table->integer('stock_under_account')->default(0)->after('stock_pure_account');
            }
            if (!Schema::hasColumn('account_settings', 'made_account')) {
                $table->integer('made_account')->default(0)->after('purchase_discount_account');
            }
            if (!Schema::hasColumn('account_settings', 'cost_account')) {
                $table->integer('cost_account')->default(0)->after('made_account');
            }
            if (!Schema::hasColumn('account_settings', 'reverse_profit_account')) {
                $table->integer('reverse_profit_account')->default(0)->after('cost_account');
            }
        });
    }

    public function down(): void
    {
        Schema::table('account_settings', function (Blueprint $table) {
            if (Schema::hasColumn('account_settings', 'reverse_profit_account')) {
                $table->dropColumn('reverse_profit_account');
            }
            if (Schema::hasColumn('account_settings', 'cost_account')) {
                $table->dropColumn('cost_account');
            }
            if (Schema::hasColumn('account_settings', 'made_account')) {
                $table->dropColumn('made_account');
            }
            if (Schema::hasColumn('account_settings', 'stock_under_account')) {
                $table->dropColumn('stock_under_account');
            }
            if (Schema::hasColumn('account_settings', 'stock_pure_account')) {
                $table->dropColumn('stock_pure_account');
            }
            if (Schema::hasColumn('account_settings', 'stock_old_account')) {
                $table->dropColumn('stock_old_account');
            }
            if (Schema::hasColumn('account_settings', 'stock_Jewelry_account')) {
                $table->dropColumn('stock_Jewelry_account');
            }
            if (Schema::hasColumn('account_settings', 'purchase_pure_account')) {
                $table->dropColumn('purchase_pure_account');
            }
            if (Schema::hasColumn('account_settings', 'purchase_old_account')) {
                $table->dropColumn('purchase_old_account');
            }
            if (Schema::hasColumn('account_settings', 'purchase_Jewelry_account')) {
                $table->dropColumn('purchase_Jewelry_account');
            }
        });
    }
};
