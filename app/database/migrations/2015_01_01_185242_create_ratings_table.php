<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('value');
			$table->string('comment');

			//Each rating-comment belongs to 1 student and 1 lesson
			$table->integer('student_id')->unsigned()->nullable();
			$table->foreign('student_id')->references('id')->on('students')->onDelete('set null')->onUpdate('cascade');
			$table->integer('lesson_id')->unsigned();
			$table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade')->onUpdate('cascade');

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
		Schema::drop('ratings');
	}

}