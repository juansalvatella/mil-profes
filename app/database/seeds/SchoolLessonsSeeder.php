<?php

use Illuminate\Database\Seeder;

class SchoolLessonsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        $schools = School::all();

        foreach($schools as $s)
            if($s->lat)
                for ($i = 0; $i < 4; ++$i)
                    SchoolLesson::create([
                        'title' => $faker->sentence(),
                        'price' => (float) mt_rand(100, 200000) / 100,
                        'description' => $faker->text(250),
                        'address' => $s->address,
                        'lat' => $s->lat,
                        'lon' => $s->lon,
                        'school_id' => $s->id,
                        'subject_id' => $faker->randomElement([1,4,5,6,7,8,9,10,11,12,13,14,15,16])
                    ]);
    }
}