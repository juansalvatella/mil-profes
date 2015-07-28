<?php

/**
 * Subject
 *
 * @property integer $id 
 * @property string $name 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Search[] $searches 
 * @property-read \Illuminate\Database\Eloquent\Collection|\TeacherLesson[] $teacherLessons 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolLesson[] $schoolLessons 
 * @method static \Illuminate\Database\Query\Builder|\Subject whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subject whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Subject whereUpdatedAt($value)
 */
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