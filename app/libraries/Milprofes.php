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
        $popular_teachers = DB::select(DB::raw("
            SELECT t5.teacher_id, t5.user_id, t5.total, @curRank := @curRank + 1 AS 'rank'
            FROM (SELECT
                    t4.teacher_id            AS 'teacher_id',
                    t4.user_id               AS 'user_id',
                    SUM(t4.count)            AS 'total'
                  FROM (SELECT
                           t1.teacher_lesson_id,
                           t2.teacher_id,
                           t3.user_id,
                           count(*) AS 'count'
                         FROM teacher_lessons_phone_visualizations AS t1
                           LEFT JOIN teacher_lessons AS t2
                             ON t2.id = t1.teacher_lesson_id
                           LEFT JOIN teachers AS t3
                             ON t3.id = t2.teacher_id
                         GROUP BY t1.teacher_lesson_id
                   ) AS t4
                  GROUP BY t4.teacher_id
                  ORDER BY total DESC
            ) AS t5, (SELECT @curRank := 0) r
            ORDER BY rank
            LIMIT ?;
        "),array($n));

        foreach($popular_teachers as $pt)
        {
            $user = User::where('id',$pt->user_id)->first();
            $pt->username = $user->username;
            $pt->displayName = ucwords($user->name).' '.substr(ucwords($user->lastname),0,1).'.';
            $pt->avatar = $user->avatar;
            $pt->slug = $user->slug;
        }

        return $popular_teachers;
    }

    public static function getLastSchools($this_many)
    {
        $n = (int) $this_many;
        $last_schools = School::whereNull('status')
            ->orWhere('status','<>','Crawled')
            ->orderBy('created_at','DESC')
            ->take($n)
            ->get();

        return $last_schools;
    }

    public static function getPopularSchools($this_many)
    {
        $n = (int) $this_many;
        $schools = School::whereNull('status')
            ->orWhere('status','<>','Crawled')
            ->get();

        foreach($schools as $s)
        {
            $total_visualizations = 0;
            $school_lessons = $s->lessons;
            foreach($school_lessons as $l)
            {
                $lesson_visualizations = count($l->visualizations()->get());
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