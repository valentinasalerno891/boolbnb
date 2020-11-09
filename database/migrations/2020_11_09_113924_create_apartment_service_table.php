<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_service', function (Blueprint $table) {
            $table->unsignedBigInteger('apartment_id');
            $table->unsignedBigInteger('service_id');
            $table->foreign('apartment_id')->references('id')->on('apartment');
            $table->foreign('service_id')->references('id')->on('service');
            $table->primary(['apartment_id', 'service_id']);  // note, this is a *primary* key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_service');
    }
}
