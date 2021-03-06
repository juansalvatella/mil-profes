<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewTeacherAvgRatings extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
        DB::statement('
            CREATE VIEW teachers_average_ratings (teacher_id,teacher_avg_rating) AS
            SELECT teachers.id, AVG(t_lesson_ratings.value)
            FROM teachers
                LEFT JOIN teacher_lessons
                ON teacher_lessons.teacher_id = teachers.id
                LEFT OUTER JOIN t_lesson_ratings
                ON t_lesson_ratings.teacher_lesson_id = teacher_lessons.id
                GROUP BY teachers.id
        ;');
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
        DB::statement('DROP VIEW teachers_average_ratings;');
	}

}
