<?php

/**
 * TeacherAvailability
 *
 * @property integer $id 
 * @property integer $teacher_id 
 * @property string $pick 
 * @property string $day 
 * @property string $start 
 * @property string $end 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Teacher $lesson 
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability wherePick($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereDay($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherAvailability whereUpdatedAt($value)
 */
class TeacherAvailability extends Eloquent
{
    protected $fillable = ['pick','day','start','end'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'teacher_availabilities';

    public function lesson() {
        return $this->belongsTo('Teacher','teacher_id');
    }

}