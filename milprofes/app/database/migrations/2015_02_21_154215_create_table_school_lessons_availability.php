<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSchoolLessonsAvailability extends Migration {

    public function up()
    {
        Schema::create('school_lessons_availability', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('school_lesson_id')->unsigned();
            $table->foreign('school_lesson_id')->references('id')->on('school_lessons')->onDelete('cascade')->onUpdate('cascade');
            $pick = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
            $table->enum('pick', $pick);
            $days = array('LUN', 'MAR', 'MIER', 'JUE', 'VIE', 'SAB', 'DOM');
            $table->enum('day', $days);
            $table->time('start');
            $table->time('end');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('school_lessons_availability');
    }

}