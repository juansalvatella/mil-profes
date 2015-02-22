<?php

class TeacherLesson extends Eloquent
{
    protected $fillable = [];

    protected $table = 'teacher_lessons';

    //Each lesson belongs to 1 teacher and 1 subject
    public function teacher() {
        return $this->belongsTo('Teacher');
    }

    public function subject() {
        return $this->belongsTo('Subject');
    }

    public function ratings()
    {
        return $this->hasMany('Rating');
    }

    public function visualizations() {
        return $this->hasMany('TeacherPhoneVisualization');
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
        return $this->hasMany('Rating')->count();
    }

}