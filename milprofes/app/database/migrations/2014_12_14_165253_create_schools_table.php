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
			$table->string('name',150);
			$table->string('rate',250);
			$table->string('schedule',250);
			$table->string('address',200);
			$table->decimal('lat');
			$table->decimal('long');
			$table->string('email',50);
			$table->string('cif',9);
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
		Schema::drop('schools');
	}

}