<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendSchoolsWithAddressColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('schools', function(Blueprint $table) {
            $table->string('town')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('region')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function(Blueprint $table) {
            $table->dropColumn('town');
            $table->dropColumn('postalcode');
            $table->dropColumn('region');
        });
	}

}
