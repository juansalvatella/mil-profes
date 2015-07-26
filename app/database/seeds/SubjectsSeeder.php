<?php

use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            'general education',
            'dummy1',
            'dummy2',
            'art',
            'music and dance',
            'languages',
            'sports',
            'hobbies',
            'science',
            'social science',
            'economy and business',
            'humanities',
            'IT and technology',
            'exams preparation',
            'special education',
            'civil service exams'
        ];

        foreach($subjects as $s) {
            Subject::create([
                'name' => $s
            ]);
        }
    }
}

