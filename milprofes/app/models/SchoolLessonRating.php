<?php

class SchoolLessonRating extends Eloquent
{
    protected $fillable = [];

    protected $table = 'school_lesson_ratings';

    //Each rating-comment belongs to 1 student and 1 school lesson (is made by a student and rates the taken lesson)
    public function student() {
        return $this->belongsTo('Student');
    }

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}