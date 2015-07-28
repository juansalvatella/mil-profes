<?php

/**
 * SchoolPhoneVisualization
 *
 * @property integer $id 
 * @property integer $user_id 
 * @property integer $school_id 
 * @property integer $school_lesson_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \User $user 
 * @property-read \SchoolLesson $lesson 
 * @method static \Illuminate\Database\Query\Builder|\SchoolPhoneVisualization whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPhoneVisualization whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPhoneVisualization whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPhoneVisualization whereSchoolLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPhoneVisualization whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPhoneVisualization whereUpdatedAt($value)
 */
class SchoolPhoneVisualization extends Eloquent
{
    protected $fillable = [];
    protected $dates = ['created_at','updated_at'];
    protected $table = 's_phone_visualizations';

    //Each visualization may belong to 1 user (observer) and 1 lesson (observed)
    public function user() {
        return $this->belongsTo('User');
    }

    public function school() {
        return $this->belongTo('School');
    }

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}