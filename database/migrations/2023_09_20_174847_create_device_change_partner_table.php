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
        Schema::create('device_change_partner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('device_change_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->string('type'); //Entrega o Mejora
            $table->string('replenishment'); // Solicitado, Pendiente o No Aplica(N/A)
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');
            $table->foreign('device_change_id')->references('id')->on('device_changes')->onDelete('set null');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_change_partner');
    }
};
