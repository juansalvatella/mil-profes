<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lessons', function(Blueprint $table)
		{
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lessons');
	}

}