<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLastPaymentInUsersTable extends Migration {

	public function up()
	{
		Schema::table('users',function($table){
			$table->dateTime('lastpayment')->nullable();
		});
	}

	public function down()
	{
		Schema::table('users',function($table){
			$table->dropColumn('lastpayment');
		});
	}

}
