<?php

class Student extends Eloquent
{
    protected $fillable = [];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'students';

    public function user() {
        return $this->belongsTo('User');
    }

    public function teacher_ratings()
    {
        return $this->hasMany('TeacherLessonRating');
    }

    public function school_ratings()
    {
        return $this->hasMany('SchoolLessonRating');
    }
}