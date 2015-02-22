<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewSchoolsAvgRatings extends Migration {

    public function up()
    {
        DB::statement('
            CREATE VIEW schools_average_ratings (school_id,school_avg_rating) AS
            SELECT schools.id, AVG(school_lesson_ratings.value)
            FROM schools
                LEFT JOIN school_lessons
                ON school_lessons.school_id = schools.id
                LEFT OUTER JOIN school_lesson_ratings
                ON school_lesson_ratings.school_lesson_id = school_lessons.id
                GROUP BY schools.id
        ;');
    }

    public function down()
    {
        DB::statement('DROP VIEW schools_average_ratings;');
    }

}