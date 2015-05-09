<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('schools', function(Blueprint $table)
        {
            $table->softDeletes();
            $table->string('status')->nullable();
        });
        Schema::table('users', function(Blueprint $table)
        {
            $table->softDeletes();
            $table->string('status')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('schools', function(Blueprint $table)
        {
            $table->dropColumn('deleted_at');
            $table->dropColumn('status');
        });
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('deleted_at');
            $table->dropColumn('status');
        });
	}

}
