<?php

class Teacher extends Eloquent
{
    protected $fillable = [];

    public function subjects() {
        return $this->belongsToMany('Subject');
    }

}