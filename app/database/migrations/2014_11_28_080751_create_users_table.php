<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('users', function(Blueprint $table)
	    {
	        $table->increments('id');
			$table->string('username')->unique();
			$table->string('slug')->nullable();
			$table->string('name');
			$table->string('lastname');
			$table->string('email')->unique();
			$table->string('phone');
			$table->string('address');
			$table->string('town')->nullable();
			$table->string('postalcode')->nullable();
			$table->string('region')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->string('gender')->nullable();
			$table->string('link_web')->nullable();
			$table->string('link_facebook')->nullable();
			$table->string('link_twitter')->nullable();
			$table->string('link_linkedin')->nullable();
			$table->string('link_googleplus')->nullable();
			$table->string('link_instagram')->nullable();
			$table->string('description');
			$table->string('avatar')->default('default_avatar.png');
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);
			$table->string('password');
			$table->string('confirmation_code');
			$table->string('remember_token')->nullable();
			$table->boolean('confirmed')->default(false);
			$table->string('status')->nullable();
			$table->string('origin')->nullable();
	        $table->timestamps();
			$table->softDeletes();
	    });
	}

	public function down()
	{
	    Schema::drop('users');
	}

}
