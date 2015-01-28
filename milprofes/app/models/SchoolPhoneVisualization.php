<?php

class SchoolPhoneVisualization extends Eloquent
{
    protected $fillable = [];

    protected $table = 'school_lessons_phone_visualizations';

    //Each visualization may belong to 1 user (observer) and 1 lesson (observed)
    public function user() {
        return $this->belongsTo('Users');
    }

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}