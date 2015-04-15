<?php

class SchoolLesson extends Eloquent
{
    protected $fillable = [];

    protected $table = 'school_lessons';

    public function school() {
        return $this->belongsTo('School');
    }

    public function subject() {
        return $this->belongsTo('Subject');
    }

    public function visualizations() {
        return $this->hasMany('SchoolPhoneVisualization');
    }

    public function ratings()
    {
        return $this->hasMany('SchoolLessonRating');
    }

    public function availabilities()
    {
        return $this->hasMany('SchoolLessonAvailability');
    }

    public function getLessonAvgRating()
    {
        if($this->ratings()->count())
            return round(($this->ratings()->avg('value')), 1);
        else
            return (float) 3.0; //If there are no ratings for the lesson, default to 3.00
    }

    public function getLessonAvgRatingWithoutCorrection()
    {
        if($this->ratings()->count())
            return round($this->ratings()->avg('value'), 1);
        else
            return -1; //If there are no ratings for the lesson, return -1
    }

    public function getNumberOfReviews()
    {
        return $this->hasMany('SchoolLessonRating')->count();
    }

}