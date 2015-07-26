<?php

use Illuminate\Database\Seeder;

class RatingsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');

        $t_lessons = TeacherLesson::all();
        foreach($t_lessons as $tl)
            for($i=0;$i<10;++$i)
                TeacherLessonRating::create([
                    'value' => (float) mt_rand(0,10) * 5 / 10,
                    'comment' => $faker->text(200),
                    'yes_helpful' => (int) $yes = mt_rand(0,100),
                    'total_helpful' => (int) mt_rand(0,100) + $yes,
                    'student_id' => (int) mt_rand(1,140),
                    'teacher_lesson_id' => $tl->id
                ]);

        $s_lessons = SchoolLesson::all();
        foreach($s_lessons as $sl)
            for($i=0;$i<10;++$i)
                SchoolLessonRating::create([
                    'value' => mt_rand(0,10) * 5 / 10,
                    'comment' => $faker->text(200),
                    'yes_helpful' => $yes = mt_rand(0,100),
                    'total_helpful' => mt_rand(0,100) + $yes,
                    'student_id' => mt_rand(1,140),
                    'school_lesson_id' => $sl->id
                ]);
    }
}