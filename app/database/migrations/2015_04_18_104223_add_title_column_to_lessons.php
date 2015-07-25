<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleColumnToLessons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//        Schema::table('school_lessons', function(Blueprint $table)
//        {
//            $table->string('title')->nullable();
//        });
//        Schema::table('teacher_lessons', function(Blueprint $table)
//        {
//            $table->string('title')->nullable();
//        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//        Schema::table('school_lessons', function(Blueprint $table)
//        {
//            $table->dropColumn('title');
//        });
//        Schema::table('teacher_lessons', function(Blueprint $table)
//        {
//            $table->dropColumn('title');
//        });
	}

}
