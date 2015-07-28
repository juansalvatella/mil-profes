<?php

/**
 * TeacherPhoneVisualization
 *
 * @property integer $id 
 * @property integer $user_id 
 * @property integer $teacher_id 
 * @property integer $teacher_lesson_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \User $user 
 * @property-read \TeacherLesson $lesson 
 * @method static \Illuminate\Database\Query\Builder|\TeacherPhoneVisualization whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherPhoneVisualization whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherPhoneVisualization whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherPhoneVisualization whereTeacherLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherPhoneVisualization whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherPhoneVisualization whereUpdatedAt($value)
 */
class TeacherPhoneVisualization extends Eloquent
{
    protected $fillable = [];
    protected $dates = ['created_at','updated_at'];
    protected $table = 't_phone_visualizations';

    //Each visualization may belong to 1 user (observer) and 1 lesson (observed)
    public function user() {
        return $this->belongsTo('User','user_id');
    }

    public function lesson() {
        return $this->belongsTo('TeacherLesson','teacher_lesson_id');
    }

}