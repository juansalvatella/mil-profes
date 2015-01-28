<?php

class SchoolLesson extends Eloquent
{
    protected $fillable = [];

    protected $table = 'school_lessons';

    //Each lesson belongs to 1 teacher and 1 subject
    public function school() {
        return $this->belongsTo('School');
    }

    public function subject() {
        return $this->belongsTo('Subject');
    }

    public function visualizations() {
        return $this->hasMany('SchoolPhoneVisualization');
    }


}