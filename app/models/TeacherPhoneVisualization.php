<?php

class TeacherPhoneVisualization extends Eloquent
{
    protected $fillable = [];

    protected $table = 'teacher_lessons_phone_visualizations';

    //Each visualization may belong to 1 user (observer) and 1 lesson (observed)
    public function user() {
        return $this->belongsTo('Users');
    }

    public function lesson() {
        return $this->belongsTo('TeacherLesson','teacher_lesson_id');
    }

}