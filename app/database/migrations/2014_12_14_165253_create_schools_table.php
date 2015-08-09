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
		Schema::create('schools', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->nullable();
			$table->string('address');
			$table->string('town')->nullable();
			$table->string('postalcode')->nullable();
			$table->string('region')->nullable();
			$table->string('cif');
			$table->string('email');
			$table->string('phone');
			$table->string('phone2');
			$table->string('link_web')->nullable();
			$table->string('link_facebook')->nullable();
			$table->string('link_twitter')->nullable();
			$table->string('link_linkedin')->nullable();
			$table->string('link_googleplus')->nullable();
			$table->string('link_instagram')->nullable();
			$table->string('logo')->default('default_logo.png');
			$table->string('video')->nullable();
			$table->string('description');
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);
			$table->string('status')->nullable();
			$table->string('origin')->nullable();
			$table->timestamps();
			$table->softDeletes();
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
