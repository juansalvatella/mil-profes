<?php

class Lesson extends Eloquent
{
    protected $fillable = [];

    //Each lesson belongs to 1 teacher and 1 subject
    public function teacher() {
        return $this->belongsTo('Teacher');
    }

    public function subject() {
        return $this->belongsTo('Subject');
    }

}