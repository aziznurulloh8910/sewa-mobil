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
        Schema::create('car_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId("rental_id")->references('id')->on('rentals')->onUpdate('cascade')->onDelete('cascade');
            $table->date('return_date');
            $table->integer('total_days');
            $table->double('total_cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_returns');
    }
};
