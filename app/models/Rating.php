<?php

class Rating extends Eloquent
{
    protected $fillable = [];

    //Each rating-comment belongs to 1 student and 1 lesson (is made by the student and rates the taken lesson)
    public function student() {
        return $this->belongsTo('Student');
    }

    public function lesson() {
        return $this->belongsTo('TeacherLesson','teacher_lesson_id');
    }

}