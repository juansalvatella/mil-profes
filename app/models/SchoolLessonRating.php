<?php

/**
 * SchoolLessonRating
 *
 * @property integer $id 
 * @property float $value 
 * @property string $comment 
 * @property integer $yes_helpful 
 * @property integer $total_helpful 
 * @property integer $student_id 
 * @property integer $school_lesson_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Student $student 
 * @property-read \SchoolLesson $lesson 
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereYesHelpful($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereTotalHelpful($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereSchoolLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLessonRating whereUpdatedAt($value)
 */
class SchoolLessonRating extends Eloquent
{
    protected $fillable = ['value','comment'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 's_lesson_ratings';

    //Each rating-comment belongs to 1 student and 1 school lesson (is made by a student and rates the taken lesson)
    public function student() {
        return $this->belongsTo('Student');
    }

    public function lesson() {
        return $this->belongsTo('SchoolLesson','school_lesson_id');
    }

}