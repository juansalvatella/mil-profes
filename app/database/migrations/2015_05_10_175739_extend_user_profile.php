<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendUserProfile extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function(Blueprint $table) {
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('link_web')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_linkedin')->nullable();
            $table->string('link_googleplus')->nullable();
            $table->string('link_instagram')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('link_web');
            $table->dropColumn('link_facebook');
            $table->dropColumn('link_twitter');
            $table->dropColumn('link_linkedin');
            $table->dropColumn('link_googleplus');
            $table->dropColumn('link_instagram');
        });
	}

}
