<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class School extends Eloquent implements SluggableInterface
{
    use SluggableTrait, SoftDeletingTrait;

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );
    protected $dates = ['deleted_at'];
    protected $fillable = [];

    public function lessons()
    {
        return $this->hasMany('SchoolLesson');
    }

    //each school has many pics
    public function pics()
    {
        return $this->hasMany('Pic');
    }

    //each school has one video (youtube link)
    public function video()
    {
        return $this->hasOne('Video');
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

    public function getNumberOfReviews()
    {
        $lessons = $this->lessons;
        $n = 0;
        foreach($lessons as $l)
            $n += count($l->ratings()->get());

        return (int) $n;
    }

}