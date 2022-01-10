<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->nullable();
            $table->string('chreg')->nullable();   
            $table->string('name');   
            $table->string('slug')->nullable();   
            $table->string('name_chi')->nullable();   
            $table->string('type')->default('org');  // church or org
            $table->boolean('is_nccsmember')->default(false);
            $table->text('address')->nullable();
            $table->string('bldg_name')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('maddress')->nullable();
            $table->string('mbldg_name')->nullable();
            $table->string('mcity')->nullable();
            $table->string('mpostcode')->nullable();
            $table->text('mission')->nullable();
            $table->text('mission_chi')->nullable();
            $table->text('vision')->nullable();
            $table->text('vision_chi')->nullable();
            $table->string('category')->nullable();
            $table->integer('category_id')->nullable();
            $table->datetime('date_founded')->nullable();
            $table->integer('totalMembership')->nullable();
            $table->integer('aveWeeklyAttendance')->nullable();
            $table->integer('numberOfReverends')->nullable();
            $table->integer('numberOfPreachers')->nullable();
            $table->integer('numberOfMissionaries')->nullable();
            $table->integer('status')->default(0);
            $table->string('avatar')->nullable();
            $table->string('photo_url')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_searchable')->default(false);

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
        Schema::dropIfExists('organizations');
    }
}
