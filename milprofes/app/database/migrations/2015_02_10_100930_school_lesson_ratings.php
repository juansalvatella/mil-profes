<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchoolLessonRatings extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('school_lesson_ratings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('value');
			$table->string('comment');

			//Each rating-comment belongs to 1 student and 1 school lesson
			$table->integer('student_id')->unsigned()->nullable();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('set null')->onUpdate('cascade');
			$table->integer('school_lesson_id')->unsigned();
			$table->foreign('school_lesson_id')->references('id')->on('school_lessons')->onDelete('cascade')->onUpdate('cascade');

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

		Schema::table('school_lesson_ratings', function($table) {
			$table->dropIndex('search');
		});

		Schema::drop('school_lesson_ratings');
	}

}