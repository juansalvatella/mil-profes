<?php

class SchoolLessonAvailability extends Eloquent
{
    protected $fillable = ['pick','day','start','end'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'school_lesson_availabilities';

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}