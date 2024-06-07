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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('registration_number');
            $table->string('asset_code');
            $table->string('location');
            $table->string('brand_type');
            $table->integer('procurement_year');
            $table->integer('quantity');
            $table->double('acquisition_cost');
            $table->double('recorded_value');
            $table->double('accumulated_depreciation');
            $table->float('total_depreciation');
            $table->integer('condition');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
