<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//New lessons tables (one for teachers, one for schools)
		Schema::create('teacher_lessons',function(Blueprint $table){
			$table->increments('id');
			$table->string('title')->nullable();
			$table->decimal('price');
			$table->string('description');
			$table->string('address');
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);

			//Each lesson belongs to 1 teacher and 1 subject
			$table->integer('teacher_id')->unsigned();
			$table->foreign('teacher_id')->references('id')->on('teachers');
			$table->integer('subject_id')->unsigned();
			$table->foreign('subject_id')->references('id')->on('subjects');

			$table->timestamps();
		});
		DB::statement('ALTER TABLE teacher_lessons ADD FULLTEXT search(description,title)');

		Schema::create('school_lessons',function(Blueprint $table){
			$table->increments('id');
			$table->string('title')->nullable();
			$table->decimal('price');
			$table->string('description');
			$table->string('address');
			$table->decimal('lat',9,7);
			$table->decimal('lon',9,7);

			//Each lesson belongs to 1 teacher and 1 subject
			$table->integer('school_id')->unsigned();
			$table->foreign('school_id')->references('id')->on('schools');
			$table->integer('subject_id')->unsigned();
			$table->foreign('subject_id')->references('id')->on('subjects');

			$table->timestamps();
		});
		DB::statement('ALTER TABLE school_lessons ADD FULLTEXT search(description,title)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//drop FULLTEXT indexes from lesson tables before droping the tables
		Schema::table('teacher_lessons', function(Blueprint $table) {
			$table->dropIndex('search');
		});
		Schema::table('school_lessons', function(Blueprint $table) {
			$table->dropIndex('search');
		});
		Schema::drop('teacher_lessons');
		Schema::drop('school_lessons');
	}

}