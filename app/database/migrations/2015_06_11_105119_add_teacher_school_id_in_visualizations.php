<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherSchoolIdInVisualizations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('school_lessons_phone_visualizations', function(Blueprint $table) {
            $table->integer('school_id')->unsigned()->nullable();
        });
        Schema::table('teacher_lessons_phone_visualizations', function(Blueprint $table) {
            $table->integer('teacher_id')->unsigned()->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('school_lessons_phone_visualizations', function(Blueprint $table) {
            $table->dropColumn('school_id');
        });
        Schema::table('teacher_lessons_phone_visualizations', function(Blueprint $table) {
            $table->dropColumn('teacher_id');
        });
	}

}
