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
			$table->string('name');
			$table->string('lastname');
			$table->string('email')->unique();
			$table->string('phone');
			$table->string('address');
			$table->string('avatar');
//			$table->string('availability');
			$table->string('description');
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);
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
