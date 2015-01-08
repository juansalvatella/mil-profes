<?php

class Student extends Eloquent
{
    protected $fillable = [];

    protected $table = 'students';

    public function user() {
        return $this->belongsTo('User');
    }

    public function ratings()
    {
        return $this->hasMany('Rating');
    }
}