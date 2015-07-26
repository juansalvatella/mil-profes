<?php

class TeacherLessonRating extends Eloquent
{
    protected $fillable = ['value','comment'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 't_lesson_ratings';

    //Each rating-comment belongs to 1 student and 1 lesson (is made by the student and rates the taken lesson)
    public function student() {
        return $this->belongsTo('Student','student_id');
    }

    public function lesson() {
        return $this->belongsTo('TeacherLesson','teacher_lesson_id');
    }

}