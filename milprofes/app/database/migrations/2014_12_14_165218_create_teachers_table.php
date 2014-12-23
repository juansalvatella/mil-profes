<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teachers', function($table)
		{
			$table->increments('id');
			$table->string('name',150);
			$table->string('rate',25);
			$table->string('schedule',250);
			$table->string('address',200);
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);
			$table->string('email',50)->unique();
			$table->string('tel',25);
			$table->string('description',1000);
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
		Schema::drop('teachers');
	}

}
