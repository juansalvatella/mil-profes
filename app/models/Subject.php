<?php

class Subject extends Eloquent {

	protected $fillable = [];

	public function ratings()
	{
		return $this->hasMany('Rating');
	}

    public function searches()
    {
        return $this->hasMany('Search');
    }

	public function lessons()
	{
		return $this->hasMany('TeacherLesson');
	}

	public function schoolLessons()
	{
		return $this->hasMany('SchoolLesson');
	}

}