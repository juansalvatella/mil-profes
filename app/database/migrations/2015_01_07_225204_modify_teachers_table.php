<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTeachersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teachers',function($table)
		{ 	//quitamos columnas innecesarias (ya incluidas en users)
			$table->dropColumn('name');
			$table->dropColumn('lastname');
			$table->dropColumn('email')->unique();
			$table->dropColumn('phone');
			$table->dropColumn('address');
			$table->dropColumn('avatar');
//			$table->dropColumn('availability');
			$table->dropColumn('description');
			$table->dropColumn('lat');
			$table->dropColumn('lon');

			//relacionamos user con un teacher id
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
