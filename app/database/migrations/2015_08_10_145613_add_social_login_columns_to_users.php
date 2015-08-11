<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialLoginColumnsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('oauth_token_secret')->nullable()->after('id');
            $table->string('oauth_token')->nullable()->after('id');
            $table->string('social_id')->nullable()->after('id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('social_id');
            $table->dropColumn('oauth_token');
            $table->dropColumn('oauth_token_secret');
        });
	}

}
