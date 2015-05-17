<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileVisitsToTeachers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::table('teachers', function(Blueprint $table) {
            $table->integer('profile_visits')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function(Blueprint $table) {
            $table->dropColumn('profile_visits');
        });
    }

}
