<?php

class Video extends Eloquent
{
    protected $fillable = [];

    protected $table = 'schools_profile_video';

    //Each video belongs to one school
    public function school() {
        return $this->belongsTo('School');
    }

}