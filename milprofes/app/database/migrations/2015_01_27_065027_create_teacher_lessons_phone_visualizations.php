<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherLessonsPhoneVisualizations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teacher_lessons_phone_visualizations', function(Blueprint $table)
		{
			$table->increments('id');
			//Each visualization belongs to 1 user (observer) and 1 lesson (observed)
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
			$table->integer('teacher_lesson_id')->unsigned()->nullable();
			$table->foreign('teacher_lesson_id')->references('id')->on('teacher_lessons')->onDelete('set null')->onUpdate('cascade');
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
		Schema::drop('teacher_lessons_phone_visualizations');
	}

}
