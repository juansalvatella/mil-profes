<?php

/**
 * TeacherLessonRating
 *
 * @property integer $id 
 * @property float $value 
 * @property string $comment 
 * @property integer $yes_helpful 
 * @property integer $total_helpful 
 * @property integer $student_id 
 * @property integer $teacher_lesson_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Student $student 
 * @property-read \TeacherLesson $lesson 
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereYesHelpful($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereTotalHelpful($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereStudentId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereTeacherLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLessonRating whereUpdatedAt($value)
 */
class TeacherLessonRating extends Eloquent
{
    protected $fillable = ['value','comment'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 't_lesson_ratings';

    //Each rating-comment belongs to 1 student and 1 lesson (is made by the student and rates the taken lesson)
    public function student() {
        return $this->belongsTo('Student','student_id');
    }

    public function lesson() {
        return $this->belongsTo('TeacherLesson','teacher_lesson_id');
    }

}