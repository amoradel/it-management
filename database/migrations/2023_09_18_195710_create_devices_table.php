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
            $table->string('name', 15);
            $table->string('ubication');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            // $table->unsignedBigInteger('department_id')->nullable();
            $table->string('device_type');
            $table->text('description')->nullable();
            $table->string('historic')->nullable();
            $table->string('storage')->nullable();
            $table->string('ram_memory')->nullable();
            $table->string('processor')->nullable();
            $table->string('asset_number')->nullable();
            $table->string('serial_number');
            $table->string('any_desk')->nullable();
            $table->string('office_version')->nullable();
            $table->string('windows_version')->nullable();
            $table->string('dvr_program')->nullable();
            $table->string('observation')->nullable();
            $table->string('condition');
            $table->date('entry_date')->nullable();
            $table->boolean('status');
    
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
        Schema::dropIfExists('devices');
    }
};
