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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('last_Update');
            $table->integer('user_id');
            $table->double('price', 10, 2)->default(0);
            $table->double('price_21', 10, 2)->default(0);
            $table->double('price_22', 10, 2)->default(0);
            $table->double('price_24', 10, 2)->default(0);
            $table->double('price_18', 10, 2)->default(0);
            $table->double('price_14', 10, 2)->default(0);
            $table->string('currency', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
