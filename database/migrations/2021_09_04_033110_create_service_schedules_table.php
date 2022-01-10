<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('church_id')->unsigned()->index();
            $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('language')->nullable();
            $table->string('scheduleDay')->nullable();
            $table->string('scheduleHour')->nullable();
            $table->string('scheduleMinutes')->nullable();
            $table->string('amOrPm')->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_schedules');
    }
}
