<?php

/**
 * SchoolLessonAvailability
 *
 * @property integer $id 
 * @property integer $school_lesson_id 
 * @property string $pick 
 * @property string $day 
 * @property string $start 
 * @property string $end 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \SchoolLesson $lesson 
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereSchoolLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability wherePick($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereDay($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonAvailability whereUpdatedAt($value)
 */
class SchoolLessonAvailability extends Eloquent
{
    protected $fillable = ['pick','day','start','end'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'school_lesson_availabilities';

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}