<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schools', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('address');
			$table->string('cif');
			$table->string('email');
			$table->string('phone');
			$table->string('phone2');
			$table->string('logo');
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
		Schema::drop('schools');
	}

}
