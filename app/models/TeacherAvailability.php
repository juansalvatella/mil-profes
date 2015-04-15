<?php

class TeacherAvailability extends Eloquent
{
    protected $fillable = ['day','start','end'];

    protected $table = 'teachers_availability';

    public function lesson() {
        return $this->belongsTo('Teacher','teacher_id');
    }

}