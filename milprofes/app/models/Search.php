<?php

class Search extends Eloquent
{
    protected $fillable = [];

    protected $table = 'searches';

    public function subject() {
        return $this->belongsTo('Subject','subject_id');
    }

}