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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('point_a_location_id');
            $table->bigInteger('point_b_location_id');
            $table->bigInteger('point_c_location_id');
            $table->integer('kilometer');
            $table->decimal('cost_tollbooth', 8, 2)->default(0);
            $table->decimal('cost_pemex', 8, 2)->default(0);
            $table->decimal('cost_pension', 8, 2)->default(0);
            $table->decimal('cost_food', 8, 2)->default(0);
            $table->decimal('cost_hotel', 8, 2)->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('point_a_location_id')->references('id')->on('locations');
            // $table->foreign('point_b_location_id')->references('id')->on('locations');
            // $table->foreign('point_c_location_id')->references('id')->on('locations');
            $table->unique(['point_a_location_id', 'point_b_location_id', 'point_c_location_id']);
            $table->index(['point_a_location_id', 'point_b_location_id', 'point_c_location_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
        Schema::table('quotes', function (Blueprint $table) {
            Schema::dropIfExists('quotes');
        });
    }
};
