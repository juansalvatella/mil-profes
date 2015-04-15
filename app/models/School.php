<?php

class School extends Eloquent
{
    protected $fillable = [];

    public function lessons()
    {
        return $this->hasMany('SchoolLesson');
    }

    public function pics()
    {
        return $this->hasMany('Pic');
    }

    public function getSchoolAvgRating()
    {
        $lessons = $this->lessons;
        foreach($lessons as $lesson)
        {
            $lesson->average_rating = $lesson->getLessonAvgRatingWithoutCorrection();
        }
        $lessons = $lessons->filter(function($lesson) { //filter lessons without rating (avg rating = -1)
            if ($lesson->average_rating != -1)
                return true;
        });
        $n = $lessons->count();
        if($n)
        {
            $sum = 0;
            foreach($lessons as $lesson)
            {
                $sum += (float)$lesson->average_rating;
            }
            return round(($sum/$n), 1);
        }
        else
        {
            return (float) 3.00; //default rating (teacher with no lessons or no lesson ratings)
        }
    }

}