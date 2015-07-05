<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnSubjectNameInTableSearches extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('searches',function($table){
            $table->dropColumn('subject_name');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('searches', function(Blueprint $table)
        { //old categories
            $table->enum('subject_name', ['escolar', 'cfp', 'musica', 'idiomas', 'all', 'artes', 'universitario', 'deportes']);
        });
	}

}
