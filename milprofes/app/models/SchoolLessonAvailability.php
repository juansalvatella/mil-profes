<?php

class SchoolLessonAvailability extends Eloquent
{
    protected $fillable = ['day','start','end'];

    protected $table = 'school_lessons_availability';

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}