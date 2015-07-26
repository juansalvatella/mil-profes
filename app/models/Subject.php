<?php

class Subject extends Eloquent {

	protected $fillable = ['name'];
	protected $dates = ['created_at','updated_at'];
	protected $table = 'subjects';

    public function searches()
    {
        return $this->hasMany('Search');
    }

	public function teacherLessons()
	{
		return $this->hasMany('TeacherLesson');
	}

	public function schoolLessons()
	{
		return $this->hasMany('SchoolLesson');
	}

}