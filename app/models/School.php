<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class School extends Eloquent implements SluggableInterface
{
    use SluggableTrait, SoftDeletingTrait;

    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'name',
        'address',
        'cif',
        'email',
        'phone',
        'phone2',
        'link_web',
        'link_facebook',
        'link_twitter',
        'link_linkedin',
        'link_googleplus',
        'link_instagram',
        'video',
        'description'
    ];
    protected $table = 'schools';

    public function lessons()
    {
        return $this->hasMany('SchoolLesson');
    }

    //each school has many pics
    public function pics()
    {
        return $this->hasMany('SchoolPic');
    }

    /**
     * @return float
     */
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
            return false;
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

    /**
     * @return int
     */
    public function getNumberOfReviews()
    {
        $lessons = $this->lessons;
        $n = 0;
        foreach($lessons as $l)
            $n += count($l->ratings()->get());

        return (int) $n;
    }

}