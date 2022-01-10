<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_contact_details', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('organization_id')->unsigned()->index();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->string('org_name')->nullable();
            $table->string('value')->nullable();
            $table->string('ctype')->nullable();
            $table->string('extra1')->nullable();
            $table->string('extra2')->nullable();

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
        Schema::dropIfExists('org_contact_details');
    }
}
