<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAddressInBothLessonTypeTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_lessons',function($table){
            $table->string('address');
            $table->decimal('lat',9,7);
            $table->decimal('lon',9,7);
        });
        Schema::table('school_lessons',function($table){
            $table->string('address');
            $table->decimal('lat',9,7);
            $table->decimal('lon',9,7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::table('teacher_lessons',function($table){
			$table->dropColumn('address');
		});
		Schema::table('school_lessons',function($table){
			$table->dropColumn('address');
		});
	}

}
