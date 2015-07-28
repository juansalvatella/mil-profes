<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Teacher
 *
 * @property integer $id 
 * @property integer $profile_visits 
 * @property integer $user_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \User $user 
 * @property-read \Illuminate\Database\Eloquent\Collection|\TeacherLesson[] $lessons 
 * @property-read \Illuminate\Database\Eloquent\Collection|\TeacherAvailability[] $availabilities 
 * @method static \Illuminate\Database\Query\Builder|\Teacher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Teacher whereProfileVisits($value)
 * @method static \Illuminate\Database\Query\Builder|\Teacher whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Teacher whereDeletedAt($value)
 */
class Teacher extends Eloquent
{
    use SoftDeletingTrait;

    protected $fillable = [];
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $table = 'teachers';

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function lessons()
    {
        return $this->hasMany('TeacherLesson');
    }

    public function availabilities()
    {
        return $this->hasMany('TeacherAvailability');
    }

    /**
     * @return float
     */
    public function getTeacherAvgRating()
    {
        $lessons = $this->lessons;
        foreach($lessons as $lesson)
        {
            $lesson->average_rating = $lesson->getLessonAvgRatingWithoutCorrection();
        }
        $lessons = $lessons->filter(function($lesson) { //filter lessons without rating (avg rating = -1)
            if ($lesson->average_rating != -1)
                return true;
            return false;
        });
        $n = $lessons->count();
        if($n) {
            $sum = 0;
            foreach($lessons as $lesson)
            {
                $sum += (float)$lesson->average_rating;
            }
            return round(($sum/$n), 1);
        }
        else
        {
          return (float) 3.00; //default rating (teacher with no lessons or no lesson ratings)
        }
    }

    /**
     * @return int
     */
    public function getNumberOfReviews()
    {
        $lessons = $this->lessons;
        $n = 0;
        foreach($lessons as $l)
            $n += count($l->ratings()->get());

        return (int) $n;
    }

}