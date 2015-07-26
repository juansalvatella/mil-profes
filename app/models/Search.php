<?php

class Search extends Eloquent
{
    protected $fillable = ['address','keywords','type'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'searches';

    public function subject() {
        return $this->belongsTo('Subject','subject_id');
    }

}