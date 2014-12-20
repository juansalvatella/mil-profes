<?php

class School extends Eloquent
{

    public function subjects() {
        return $this->belongsToMany('Subject');
    }

}