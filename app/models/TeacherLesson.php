<?php

/**
 * TeacherLesson
 *
 * @property integer $id 
 * @property string $title 
 * @property float $price 
 * @property string $description 
 * @property string $address 
 * @property float $lat 
 * @property float $lon 
 * @property integer $teacher_id 
 * @property integer $subject_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Teacher $teacher 
 * @property-read \Subject $subject 
 * @property-read \Illuminate\Database\Eloquent\Collection|\TeacherLessonRating[] $ratings 
 * @property-read \Illuminate\Database\Eloquent\Collection|\TeacherPhoneVisualization[] $visualizations 
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereLon($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereSubjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TeacherLesson whereUpdatedAt($value)
 */
class TeacherLesson extends Eloquent
{
    protected $fillable = ['title','price','description','address'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'teacher_lessons';

    //Each lesson belongs to 1 teacher and 1 subject
    public function teacher() {
        return $this->belongsTo('Teacher');
    }

    public function subject() {
        return $this->belongsTo('Subject');
    }

    public function ratings()
    {
        return $this->hasMany('TeacherLessonRating');
    }

    public function visualizations() {
        return $this->hasMany('TeacherPhoneVisualization');
    }

    /**
     * @return float
     */
    public function getLessonAvgRating()
    {
        if($this->ratings()->count())
            return round(($this->ratings()->avg('value')), 1);
        else
            return (float) 3.0; //If there are no ratings for the lesson, default to 3.00
    }

    /**
     * @return float
     */
    public function getLessonAvgRatingWithoutCorrection()
    {
        if($this->ratings()->count())
            return round($this->ratings()->avg('value'), 1);
        else
            return -1.0; //If there are no ratings for the lesson, return -1
    }

    /**
     * @return int
     */
    public function getNumberOfReviews()
    {
        return (int) $this->hasMany('TeacherLessonRating')->count();
    }

    /**
     * @param $this_many
     * @return mixed
     */
    public function getFeaturedReviews($this_many) {
        $n = (int) $this_many;
        $featured = $this->ratings()
//            ->where('total_helpful','>','0')
            ->orderByRaw('`yes_helpful`/IF(`total_helpful`=0,1,`total_helpful`) DESC')
            ->take($n)
            ->get();
        if(!count($featured)>0)
            $featured = $this->ratings()->orderBy('value')->take($n)->get();

        return $featured;
    }

}