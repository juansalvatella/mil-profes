<?php

class Teacher extends Eloquent
{
    protected $fillable = [];

    protected $table = 'teachers';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function lessons()
    {
        return $this->hasMany('TeacherLesson');
    }

    public function getTeacherAvgRating()
    {
        $lessons = $this->lessons;
        foreach($lessons as $lesson)
        {
            $lesson->average_rating = $lesson->getLessonAvgRating();
        }
        $lessons_array = $lessons->toArray();
        if($n_lessons = count($lessons_array))
        {
            $sum = 0;
            for($i=0;$i<$n_lessons;++$i)
            {
                $sum += (float) $lessons[$i]->average_rating;
            }
            return round($sum/$n_lessons,2);
        }
        else
        {
          return (float) 3.00; //default rating (teacher with no lessons or no lesson ratings)
        }
    }

}