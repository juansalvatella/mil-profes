<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOldSubjectTeacherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('subject_teacher');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{//We re-create it so it can be droped properly by its old create migration
		Schema::create('subject_teacher', function($table)
		{
			$table->increments('id');
		});
	}

}
