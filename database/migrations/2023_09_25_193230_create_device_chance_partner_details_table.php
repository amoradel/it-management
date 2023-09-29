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
        Schema::create('device_change_partner_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('device_change_id')->nullable();
            $table->unsignedBigInteger('device_change_partner_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();

            $table->foreign('device_change_id')->references('id')->on('device_changes')->onDelete('set null');
            $table->foreign('device_change_partner_id')->references('id')->on('device_change_partner')->onDelete('set null');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_change_partner_details');
    }
};
