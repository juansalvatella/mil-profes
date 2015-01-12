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
			//Each visualization belongs to 1 user (observer) and 1 user (observed)
			$table->integer('observer_id')->unsigned();
			$table->foreign('observer_id')->references('id')->on('users');
			$table->integer('observed_id')->unsigned();
			$table->foreign('observed_id')->references('id')->on('users');
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
