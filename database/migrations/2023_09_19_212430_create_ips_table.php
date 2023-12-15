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
        Schema::create('ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_number', 15);
            $table->unsignedBigInteger('device_id')->nullable();
            $table->string('availability')->nullable();
            $table->text('description')->nullable();
            $table->string('ip_type');
            $table->string('segment');
            $table->boolean('status');

            $table->foreign('device_id')->references('id')->on('devices')->restrictOnDelete();
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
        Schema::dropIfExists('ips');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
