<?php

class Subject extends Eloquent {

	protected $fillable = [];

	public $timestamps = false;

	public function schools() {
		return $this->belongsToMany('School');
	}

	public function teachers() {
		return $this->belongsToMany('Teacher');
	}

}