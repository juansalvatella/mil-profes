<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHelpfulnessOfRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('ratings', function(Blueprint $table) {
            $table->integer('yes_helpful')->default(0);
            $table->integer('total_helpful')->default(0);
        });
        Schema::table('school_lesson_ratings', function(Blueprint $table) {
            $table->integer('yes_helpful')->default(0);
            $table->integer('total_helpful')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('ratings', function(Blueprint $table) {
            $table->dropColumn('yes_helpful');
            $table->dropColumn('total_helpful');
        });
        Schema::table('school_lesson_ratings', function(Blueprint $table) {
            $table->dropColumn('yes_helpful');
            $table->dropColumn('total_helpful');
        });
	}

}
