<?php

class Pic extends Eloquent
{
    protected $fillable = [];

    protected $table = 'schools_profile_pics';

    //Each pic belongs to one school
    public function school() {
        return $this->belongsTo('School');
    }

}