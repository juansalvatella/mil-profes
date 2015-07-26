<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeachersAvailability extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_availabilities', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $pick = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
            $table->enum('pick', $pick);
            $days = array('LUN', 'MAR', 'MIER', 'JUE', 'VIE','SAB','DOM');
            $table->enum('day', $days);
            $table->time('start');
            $table->time('end');
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
        Schema::drop('teacher_availabilities');
    }

}
