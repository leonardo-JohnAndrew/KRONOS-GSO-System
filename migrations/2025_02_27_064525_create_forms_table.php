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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE')->unique();
            $table->string('userid');
            $table->foreign('userid')->references('userid')->on('users')->onUpdate('cascade');
            $table->string('request_type');
            $table->enum('bump', ['No', 'Yes'])->nullable();
            $table->string('facultyApproval')->nullable();
            $table->string('facultyID')->nullable();
            $table->foreign('facultyID')->references('userid')->on('users')->cascadeOnUpdate();
            $table->datetime('facultyDateApproval')->nullable();
            $table->text('reason');
            $table->enum('remark', ['Pending', 'Ongoing', 'Completed', 'Rejected']);
            $table->timestamps();
        });

        Schema::create('service_request', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE');
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests')->onUpdate('cascade');
            $table->dateTime('dateSubmit');
            $table->time('timeDeparture');
            $table->time('timeArrival');
            $table->date('dateArrival');
            $table->integer("noOfPassenger");
            $table->date('dateNeeded');
            $table->string('destination');
            $table->text('passengerName');
            $table->string('purpose');
            $table->timestamps();
        });
        Schema::create('facility_request', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE')->unique();
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests')->onUpdate('cascade');
            $table->string('facilityID');
            $table->dateTime('dateSubmit');
            $table->string('activity');
            $table->text('purpose');
            $table->string('activityType');
            $table->dateTime('activityDateStart');
            $table->dateTime('activityDateEnd');
            $table->string('venue');
            $table->integer('participants');
            $table->text('note');
            $table->timestamps();
        });

        Schema::create('purchase_request', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE')->unique();
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests')->onUpdate('cascade');
            $table->string('category')->nullable();
            $table->date('dateNeeded');
            $table->text('purpose');
            $table->timestamps();
        });

        Schema::create('job_request', function (Blueprint $table) {
            $table->id();
            $table->string('reqstCODE')->unique();
            $table->foreign('reqstCODE')->references('reqstCODE')->on('requests')->onUpdate('cascade');
            $table->dateTime('dateSubmit');
            $table->date('dateNeeded');
            $table->text('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request');
        Schema::dropIfExists('facility_request');
        Schema::dropIfExists('service_request');
        Schema::dropIfExists('job_requests');
        Schema::dropIfExists('requests');
    }
};
