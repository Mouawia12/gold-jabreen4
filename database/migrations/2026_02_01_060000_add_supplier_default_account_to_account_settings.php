<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('account_settings', 'supplier_default_account')) {
                $table->integer('supplier_default_account')->default(0)->after('reverse_profit_account');
            }
        });
    }

    public function down(): void
    {
        Schema::table('account_settings', function (Blueprint $table) {
            if (Schema::hasColumn('account_settings', 'supplier_default_account')) {
                $table->dropColumn('supplier_default_account');
            }
        });
    }
};
