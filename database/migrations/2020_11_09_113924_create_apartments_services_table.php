<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     //Creazione tabella ponte tra apartments e services
    public function up()
    {
        Schema::create('apartments_services', function (Blueprint $table) {
            //Realazione tramite apartment_id con la tabella apartments//
            $table->unsignedBigInteger('apartment_id');
            $table->foreign('apartment_id')->references('id')->on('apartments');
            
            
            //Realazione tramite service_id con la tabella services//
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->primary(['apartment_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments_services');
    }
}
