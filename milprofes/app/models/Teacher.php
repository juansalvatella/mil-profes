<?php

class Teacher extends Eloquent
{
    protected $fillable = [];

    protected $table = 'teachers';

    public function user() {
        return $this->belongsTo('User');
    }

    public function lessons()
    {
        return $this->hasMany('TeacherLesson');
    }

}