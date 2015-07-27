<?php

use Illuminate\Database\Seeder;

class VisualizationsSeeder extends Seeder
{
    public function run()
    {
        $teachers = Teacher::all();
        foreach($teachers as $t) {
            $t_lessons = $t->lessons()->get();
            foreach($t_lessons as $tl)
                TeacherPhoneVisualization::create([
                    'user_id' => mt_rand(1,40),
                    'teacher_id' => $t->id,
                    'teacher_lesson_id' => $tl->id,
                ]);
        }

        $schools = School::all();
        foreach($schools as $s) {
            $s_lessons = $s->lessons()->get();
            foreach($s_lessons as $sl)
                SchoolPhoneVisualization::create([
                    'user_id' => mt_rand(1,40),
                    'school_id' => $s->id,
                    'school_lesson_id' => $sl->id,
                ]);
        }
    }
}
