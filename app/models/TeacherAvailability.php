<?php

class TeacherAvailability extends Eloquent
{
    protected $fillable = ['pick','day','start','end'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'teacher_availabilities';

    public function lesson() {
        return $this->belongsTo('Teacher','teacher_id');
    }

}