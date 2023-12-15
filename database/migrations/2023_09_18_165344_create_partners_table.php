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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('employee_number', 20);
            $table->string('job_position', 50);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('username_network', 15);
            $table->string('username_odoo', 15);
            $table->string('username_jde', 15);
            $table->string('extension', 10);
            $table->string('email', 50);

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
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
        Schema::dropIfExists('partners');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
