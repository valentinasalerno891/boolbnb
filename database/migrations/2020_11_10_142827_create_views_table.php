<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

      //Creazione della tabella Views//
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->string('created_at', 20);
            $table->string('session_id', 40);

            //Realazione tramite apartment_id con la tabella apartments//
            $table->unsignedBigInteger('apartment_id');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views');
    }
}
