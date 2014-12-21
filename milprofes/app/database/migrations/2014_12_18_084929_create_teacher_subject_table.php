<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeacherSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teacher_subject', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('teacher_id')->unsigned()->index();
			$table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
			$table->integer('subject_id')->unsigned()->index();
			$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
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
		Schema::drop('teacher_subject');
	}

}
