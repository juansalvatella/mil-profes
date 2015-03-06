<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLastPaymentInUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::table('users',function($table){
			$table->dateTime('lastpayment')->nullable();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::table('users',function($table){
			$table->dropColumn('lastpayment');
		});
	}

}
