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
        Schema::create('device_changes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('asset_number');
            $table->string('serial_number');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('model_id')->references('id')->on('device_models')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_changes');
    }
};
