<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_movements', function (Blueprint $table) {
            if (!Schema::hasColumn('account_movements', 'notes')) {
                $table->text('notes')->nullable()->after('date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('account_movements', function (Blueprint $table) {
            if (Schema::hasColumn('account_movements', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};
