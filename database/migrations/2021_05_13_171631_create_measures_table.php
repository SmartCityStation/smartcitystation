<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasuresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measures', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('time');
            $table->float('data', 5, 2);
            // $table->string('data');
            $table->integer('device_id')->unsigned();
            $table->integer('data_variable_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('data_variable_id')->references('id')->on('data_variables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('measures');
    }
}
