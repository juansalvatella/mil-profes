<?php

class SchoolPhoneVisualization extends Eloquent
{
    protected $fillable = [];
    protected $dates = ['created_at','updated_at'];
    protected $table = 's_phone_visualizations';

    //Each visualization may belong to 1 user (observer) and 1 lesson (observed)
    public function user() {
        return $this->belongsTo('User');
    }

    public function school() {
        return $this->belongTo('School');
    }

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}