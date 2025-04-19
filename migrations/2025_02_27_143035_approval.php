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
        //
        Schema::create('deans_Approval', function (Blueprint $table) {
            $table->id('deansApprovalID')->primary();
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests');
            $table->string('deanID')->nullable();
            $table->foreign('deanID')->references('userid')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('deanApproval')->nullable();
            $table->dateTime('deanDateApproval', 0)->nullable();
            $table->text('notification');
            $table->timestamps();
        });
        Schema::create('gso_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deansApprovalID')->references('deansApprovalID')->on('deans_approval');
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests');
            $table->string('vehicleID', 50);
            $table->foreign('vehicleID')->references('vehicleID')->on('vehicle')->onDelete('cascade');
            $table->string('driver');
            $table->dateTime('actualArrival', 0);
            $table->string('officerID');
            $table->foreign('officerID')->references('userid')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('officerApproval');
            $table->dateTime('officerDateApproval', 0);
            $table->string('adminApproval');
            $table->dateTime('adminDateApproval', 0);
            $table->text('notification');
            $table->timestamps();
        });

        Schema::create('gso_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deansApprovalID')->references('deansApprovalID')->on('deans_approval');
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests');
            $table->string('facilityID');
            $table->foreign('facilityID')->references('facilityID')->on('facilities');
            $table->string('officerID');
            $table->foreign('officerID')->references('userid')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('officerApproval');
            $table->dateTime('officerDateApproval', 0);
            $table->string('adminApproval');
            $table->dateTime('adminDateApproval', 0);
            $table->text('notification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
