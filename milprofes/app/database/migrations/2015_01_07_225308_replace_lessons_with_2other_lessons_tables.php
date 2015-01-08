<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplaceLessonsWith2otherLessonsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Drop old reference to the old lessons table, by the ratings pivot table
		Schema::table('ratings', function($table)
		{
			$table->dropForeign('ratings_lesson_id_foreign');
			$table->dropColumn('lesson_id');
		});

		//New lessons tables (one for teachers, one for schools)
		Schema::create('teacher_lessons',function($table){
			$table->increments('id');
			$table->decimal('price');
			$table->string('description');

			//Each lesson belongs to 1 teacher and 1 subject
			$table->integer('teacher_id')->unsigned();
			$table->foreign('teacher_id')->references('id')->on('teachers');
			$table->integer('subject_id')->unsigned();
			$table->foreign('subject_id')->references('id')->on('subjects');

			$table->timestamps();
		});

		Schema::create('school_lessons',function($table){
			$table->increments('id');
			$table->decimal('price');
			$table->string('description');

			//Each lesson belongs to 1 teacher and 1 subject
			$table->integer('school_id')->unsigned();
			$table->foreign('school_id')->references('id')->on('schools');
			$table->integer('subject_id')->unsigned();
			$table->foreign('subject_id')->references('id')->on('subjects');

			$table->timestamps();
		});

		//Finally, we replace the old ratings-lesson reference with the new one in the pivot table
		Schema::table('ratings', function($table)
		{
			$table->integer('teacher_lesson_id')->unsigned();
			$table->foreign('teacher_lesson_id')->references('id')->on('teacher_lessons');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ratings', function($table)
		{
			$table->dropForeign('ratings_teacher_lesson_id_foreign');
			$table->dropColumn('teacher_lesson_id');
		});
		Schema::drop('teacher_lessons');
		Schema::drop('school_lessons');
	}

}
