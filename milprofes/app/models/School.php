<?php

class School extends Eloquent
{
    protected $fillable = [];

    public function lessons()
    {
        return $this->hasMany('SchoolLesson');
    }

}