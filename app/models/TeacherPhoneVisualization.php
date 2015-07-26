<?php

class TeacherPhoneVisualization extends Eloquent
{
    protected $fillable = [];
    protected $dates = ['created_at','updated_at'];
    protected $table = 't_phone_visualizations';

    //Each visualization may belong to 1 user (observer) and 1 lesson (observed)
    public function user() {
        return $this->belongsTo('User','user_id');
    }

    public function lesson() {
        return $this->belongsTo('TeacherLesson','teacher_lesson_id');
    }

}