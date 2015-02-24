<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchesTable extends Migration {

    public function up()
    {
        Schema::create('searches', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('address');
            //relacionamos search con un subject
            $table->integer('subject_id')->unsigned()->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null')->onUpdate('cascade');
            $subjects = array('escolar', 'cfp', 'musica', 'idiomas', 'all', 'artes', 'universitario', 'deportes');
            $table->enum('subject_name', $subjects);
            $table->string('keywords');
            $table->string('type');
            $table->integer('results');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('searches');
    }

}
