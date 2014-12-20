<?php

class Teacher extends Eloquent
{

    public function subjects() {
        return $this->belongsToMany('Subject');
    }

}