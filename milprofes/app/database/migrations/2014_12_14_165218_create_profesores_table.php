<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profesores', function($table)
		{
			$table->increments('id');
			$table->string('nombre',150);
			$table->string('preciohora',25);
			$table->string('disponibilidad',250);
			$table->string('direccion',200);
			$table->string('poblacion',150);
			$table->string('email',50);
			$table->string('telefono',25);
			$allow = array('escolar','cfp','universitario','artes','música','idiomas','deportes');
			$table->enum('categoria',$allow);
			$table->string('descripcion',1000);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profesores');
	}

}
