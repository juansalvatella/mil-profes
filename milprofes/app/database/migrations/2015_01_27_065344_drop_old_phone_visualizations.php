<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOldPhoneVisualizations extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::drop('phone_visualizations');
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{//We re-create it so it can be droped properly by its old create migration
		Schema::create('phone_visualizations', function(Blueprint $table)
		{
			$table->increments('id');
		});
	}

}
