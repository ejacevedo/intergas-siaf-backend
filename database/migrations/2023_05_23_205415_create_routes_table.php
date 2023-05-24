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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('load_address_id');
            $table->bigInteger('unload_address_id');
            $table->bigInteger('return_address_id');
            $table->integer('kilometer');
            $table->decimal('cost_tollbooth', 8, 2)->default(0);
            $table->decimal('cost_pemex', 8, 2)->default(0);
            $table->decimal('cost_pension', 8, 2)->default(0);
            $table->decimal('cost_food', 8, 2)->default(0);
            $table->decimal('cost_hotel', 8, 2)->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['load_address_id', 'unload_address_id', 'return_address_id']);
            $table->index(['load_address_id', 'unload_address_id', 'return_address_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};