<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpdata', function (Blueprint $table) {
            $table->string('device');
            $table->datetime('time');
            $table->float('0');
            $table->float('1');
            $table->float('2');
            $table->float('3');
            $table->float('4');
            $table->float('5');
            $table->float('6');
            $table->float('7');
            $table->float('8');
            $table->float('9');
            $table->float('10');
            $table->float('11');
            $table->float('12');
            $table->float('13');
            $table->float('14');
            $table->float('15');
            $table->float('16');
            $table->float('17');
            $table->float('18');
            $table->float('19');
            $table->float('20');
            $table->float('21');
            $table->float('22');
            $table->float('23');
            $table->float('24');
            $table->float('25');
            $table->float('26');
            $table->float('27');
            $table->float('28');
            $table->float('29');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lpData');
    }
}
