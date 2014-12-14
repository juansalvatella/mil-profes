<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademiasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('academias', function($table)
		{
			$table->increments('id');
			$table->string('nombre',150);
			$table->string('precio',250);
			$table->string('horario',250);
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
		Schema::drop('academias');
	}

}
