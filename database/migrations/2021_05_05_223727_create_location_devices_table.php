<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationDevicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->date('installation_date');
            $table->time('installation_hour');
            $table->date('remove_date')->nullable();
            $table->string('latitude')->nullable();
            $table->string('length')->nullable();
            $table->integer('device_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedBigInteger('subsector_id');
            $table->foreign('subsector_id')->references('id')->on('subsectors');
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('location_devices');
    }
}
