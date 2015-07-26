<?php

use Illuminate\Database\Seeder;

class TeacherLessonsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        $users = User::all();

        foreach($users as $u)
            if($u->lat && $u->hasRole('teacher'))
                for ($i = 0; $i < 4; ++$i)
                    TeacherLesson::create([
                        'title' => $faker->sentence(),
                        'price' => (float) mt_rand(100, 200000) / 100,
                        'description' => $faker->text(250),
                        'address' => $u->address,
                        'lat' => $u->lat,
                        'lon' => $u->lon,
                        'teacher_id' => $u->teacher()->pluck('id'),
                        'subject_id' => $faker->randomElement([1,4,5,6,7,8,9,10,11,12,13,14,15,16])
                    ]);
    }
}