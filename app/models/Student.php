<?php

/**
 * Student
 *
 * @property integer $id 
 * @property integer $user_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \User $user 
 * @property-read \Illuminate\Database\Eloquent\Collection|\TeacherLessonRating[] $teacher_ratings 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolLessonRating[] $school_ratings 
 * @method static \Illuminate\Database\Query\Builder|\Student whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Student whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Student whereUpdatedAt($value)
 */
class Student extends Eloquent
{
    protected $fillable = [];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'students';

    public function user() {
        return $this->belongsTo('User');
    }

    public function teacher_ratings()
    {
        return $this->hasMany('TeacherLessonRating');
    }

    public function school_ratings()
    {
        return $this->hasMany('SchoolLessonRating');
    }
}