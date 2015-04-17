<?php

use Illuminate\Support\Collection;

class Milprofes
{

    public static function getLastTeachers($this_many)
    {
        $n = (int) $this_many;
        $teachers = Teacher::all();
        $last_teachers = $teachers->sortByDesc(function($teacher) {
            return $teacher->created_at;
        })->take($n);
        foreach($last_teachers as $lt)
        {
            $lt->username = $lt->user->username;
            $lt->avatar = $lt->user->avatar;
            $lt->slug = $lt->user->slug;
        }
        return $last_teachers;
    }

    public static function getPopularTeachers($this_many)
    {
        $n = (int) $this_many;
        $teachers = Teacher::all();
        foreach($teachers as $t)
        {
            $total_visualizations = 0;
            $teacher_lessons = $t->lessons()->get();
            foreach($teacher_lessons as $l)
            {
                $lesson_visualizations = count($l->visualizations());
                $total_visualizations += $lesson_visualizations;
            }
            $t->total_visualizations = $total_visualizations;
        }
        $popular_teachers = $teachers->sortByDesc(function($teacher) {
            return $teacher->total_visualizations;
        })->take($n);

        foreach($popular_teachers as $lt)
        {
            $lt->username = $lt->user->username;
            $lt->avatar = $lt->user->avatar;
            $lt->slug = $lt->user->slug;
        }

        return $popular_teachers;
    }

    public static function getLastSchools($this_many)
    {
        $n = (int) $this_many;
        $schools = School::all();
        $last_schools = $schools->sortByDesc(function($school) {
            return $school->created_at;
        })->take($n);

        return $last_schools;
    }

    public static function getPopularSchools($this_many)
    {
        $n = (int) $this_many;
        $schools = School::all();
        foreach($schools as $s)
        {
            $total_visualizations = 0;
            $school_lessons = $s->lessons;
            foreach($school_lessons as $l)
            {
                $lesson_visualizations = count($l->visualizations());
                $total_visualizations += $lesson_visualizations;
            }
            $s->total_visualizations = $total_visualizations;
        }
        $popular_schools = $schools->sortByDesc(function($school) {
            return $school->total_visualizations;
        })->take($n);

        return $popular_schools;
    }
    
    public static function findWithinPrice($price_range, $prof_o_acad, $collection)
    {
        if($prof_o_acad=='profesor') {
            if ($price_range == 'rang0') {
                $min_price = 0.01;
                $max_price = 9.99;
            } else if ($price_range == 'rang1') {
                $min_price = 10;
                $max_price = 30;
            } else if ($price_range == 'rang2') {
                $min_price = 30;
                $max_price = 50;
            } else if ($price_range == 'rang3') {
                $min_price = 50;
                $max_price = 100;
            } else if ($price_range == 'rang4') {
                $min_price = 100;
                $max_price = 999999;
            } else { //if 'all', any other case also defaults to all
                $min_price = 0;
                $max_price = 999999;
            }
        } else { //academias
            if ($price_range == 'rang0') {
                $min_price = 0.01;
                $max_price = 150;
            } else if ($price_range == 'rang1') {
                $min_price = 150;
                $max_price = 350;
            } else if ($price_range == 'rang2') {
                $min_price = 350;
                $max_price = 500;
            } else if ($price_range == 'rang3') {
                $min_price = 500;
                $max_price = 1500;
            } else if ($price_range == 'rang4') {
                $min_price = 1500;
                $max_price = 9999999;
            } else { //if 'all', any other case also defaults to all
                $min_price = 0;
                $max_price = 9999999;
            }
        }

        $filtered_collection = $collection->filter(function($lesson) use ($min_price,$max_price)
        {
            if ($lesson->price >= $min_price && $lesson->price <= $max_price)
                return true;
        }); //Primer filtro

        return $filtered_collection;
    }
}