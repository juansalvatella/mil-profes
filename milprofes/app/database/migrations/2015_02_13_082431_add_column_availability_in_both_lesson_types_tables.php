<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAvailabilityInBothLessonTypesTables extends Migration {

	public function up()
	{
//		Schema::table('teacher_lessons',function($table){
//			$table->string('availability');
//		});
//		Schema::table('school_lessons',function($table){
//			$table->string('availability');
//		});
	}

	public function down()
	{
//		Schema::table('teacher_lessons',function($table){
//			$table->dropColumn('availability');
//		});
//		Schema::table('school_lessons',function($table){
//			$table->dropColumn('availability');
//		});
	}
}
