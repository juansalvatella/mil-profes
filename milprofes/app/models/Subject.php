<?php

class Subject extends Eloquent {

	protected $fillable = [];

	public function ratings()
	{
		return $this->hasMany('Rating');
	}

	public function lessons()
	{
		return $this->hasMany('TeacherLesson');
	}

}