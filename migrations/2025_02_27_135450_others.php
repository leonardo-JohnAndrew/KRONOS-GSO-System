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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('facilityID')->unique();
            $table->string('facilityName');
            $table->string('description');
            $table->text('location');
            $table->integer('capacity');
            $table->enum('archive', ['Yes', 'No'])->default('No');
            $table->timestamps();
        });
        Schema::create('vehicle', function (Blueprint $table) {
            $table->string('vehicleID', 50)->primary();
            $table->string('plateNo')->unique();
            $table->integer('maxSeat');
            $table->string('brand');
            $table->string('unit');
            $table->string('status');
            $table->date('yearManufacture');
            $table->enum('archive', ['Yes', 'No'])->default('No');
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests');
            $table->string('materialName');
            $table->integer('quantity');
            $table->boolean('available');
            $table->timestamps();
        });
        Schema::create('jobList', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('job_request');
            $table->string('particulars');
            $table->integer('quantity');
            $table->string('natureofWork');
            $table->string('jbrqremarks')->nullable();
            $table->timestamps();
        });
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('job_request');
            $table->string('userid')->references('userid')->on('users');
            $table->string('notification');
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id('dprtID');
            $table->string('dprtName');
            $table->timestamps();
        });
        Schema::create('organizations', function (Blueprint $table) {
            $table->id('orgID');
            $table->unsignedBigInteger('dprtID');
            $table->foreign('dprtID')->references('dprtID')->on('departments')->cascadeOnUpdate();
            $table->string('orgName');
            $table->timestamps();
        });
        Schema::create('positions', function (Blueprint $table) {
            $table->id('positionID');
            $table->unsignedBigInteger('orgID');
            $table->foreign('orgID')->references('orgID')->on('organizations')->cascadeOnUpdate();
            $table->unsignedBigInteger('dprtID');
            $table->foreign('dprtID')->references('dprtID')->on('departments')->cascadeOnUpdate();
            $table->string('positionName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('vehicle');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('jobList');
        Schema::dropIfExists('notification');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('organizations');
    }
};
