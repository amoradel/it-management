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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('location');
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('model_id')->nullable();
            $table->foreignId('type_id')->nullable();
            $table->string('device_type');
            $table->text('description')->nullable();
            $table->string('storage')->nullable();
            $table->string('storage_type')->nullable();
            $table->string('ram_memory_type')->nullable();
            $table->string('ram_memory')->nullable();
            $table->string('processor')->nullable();
            $table->string('asset_number')->nullable();
            $table->string('serial_number');
            $table->foreignId('ip_id')->nullable();
            $table->string('anydesk')->nullable();
            $table->string('office_version')->nullable();
            $table->string('windows_version')->nullable();
            $table->string('dvr_program')->nullable();
            $table->string('observation')->nullable();
            $table->string('condition');
            $table->date('entry_date')->nullable();

            $table->foreign('brand_id')->references('id')->on('brands')->restrictOnDelete();
            $table->foreign('model_id')->references('id')->on('device_models')->restrictOnDelete();
            $table->foreign('type_id')->references('id')->on('types')->restrictOnDelete();
            $table->foreign('ip_id')->references('id')->on('ips')->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('devices');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
