<?php

class SchoolPic extends Eloquent
{
    protected $fillable = ['pic'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'school_pics';

    //Each pic belongs to one school
    public function school() {
        return $this->belongsTo('School');
    }

}