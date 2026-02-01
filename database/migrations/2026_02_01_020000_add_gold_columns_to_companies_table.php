<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'deposit_gold')) {
                $table->double('deposit_gold')->default(0)->after('deposit_amount');
            }
            if (!Schema::hasColumn('companies', 'credit_gold')) {
                $table->double('credit_gold')->default(0)->after('deposit_gold');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'credit_gold')) {
                $table->dropColumn('credit_gold');
            }
            if (Schema::hasColumn('companies', 'deposit_gold')) {
                $table->dropColumn('deposit_gold');
            }
        });
    }
};
