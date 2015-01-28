<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneVisualizations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('phone_visualizations', function(Blueprint $table)
		{
			$table->increments('id');
			//Each visualization belongs to 1 user (observer) and 1 teacher (observed)
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('teacher_id')->unsigned();
			$table->foreign('teacher_id')->references('id')->on('teachers');
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
		Schema::drop('phone_visualizations');
	}

}
