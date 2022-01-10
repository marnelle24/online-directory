<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePastorStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pastor_staff', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('church_id')->unsigned()->index();
            $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
            
            $table->string('title')->nullable();
            $table->string('title_chi')->nullable();
            $table->string('first_name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('given_name_chi')->nullable();
            $table->string('family_name')->nullable();
            $table->string('family_name_chi')->nullable();
            $table->string('position')->nullable();
            $table->string('position_chi')->nullable();
            $table->string('phone')->nullable();
            $table->string('type')->nullable();
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('pastor_staff');
    }
}
