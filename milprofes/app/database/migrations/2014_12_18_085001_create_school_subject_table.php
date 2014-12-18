<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchoolSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('school_subject', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('school_id')->unsigned()->index();
			$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
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
		Schema::drop('school_subject');
	}

}
