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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_sale', 8, 5)->default(0);
            $table->decimal('density', 8, 2)->default(0);
            $table->decimal('load_capacity_per_kilogram', 8, 2)->default(0);
            $table->decimal('load_capacity_per_liter', 8, 2)->default(0);
            $table->decimal('price_disel', 8, 2)->default(0);
            $table->decimal('price_event', 8, 2)->default(0);
            $table->timestamps();
        });

    }


    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
