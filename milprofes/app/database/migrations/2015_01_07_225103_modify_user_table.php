<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function($table){
			//already exists $table->increments('id');
			//already exists $table->string('name');
			$table->string('lastname');
			//already exists $table->string('email')->unique();
			$table->string('phone');
			$table->string('address');
			$table->string('avatar');
			$table->string('availability');
			$table->string('description');
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);
			//already exists $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users',function($table){
			$table->dropColumn('lastname');
			$table->dropColumn('phone');
			$table->dropColumn('address');
			$table->dropColumn('avatar');
			$table->dropColumn('availability');
			$table->dropColumn('description');
			$table->dropColumn('lat');
			$table->dropColumn('lon');
		});
	}

}
