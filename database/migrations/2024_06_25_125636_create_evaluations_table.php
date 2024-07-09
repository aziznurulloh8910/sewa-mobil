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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("asset_id")->references('id')->on('assets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("criteria_id")->references('id')->on('criterias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("sub_criteria_id")->references('id')->on('sub_criterias')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
