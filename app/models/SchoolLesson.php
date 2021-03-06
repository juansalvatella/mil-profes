<?php

/**
 * SchoolLesson
 *
 * @property integer $id 
 * @property string $title 
 * @property float $price 
 * @property string $description 
 * @property string $address 
 * @property float $lat 
 * @property float $lon 
 * @property integer $school_id 
 * @property integer $subject_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \School $school 
 * @property-read \Subject $subject 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolPhoneVisualization[] $visualizations 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolLessonRating[] $ratings 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolLessonAvailability[] $availabilities 
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereLon($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereSubjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolLesson whereUpdatedAt($value)
 */
class SchoolLesson extends Eloquent
{
    protected $fillable = ['title','price','description','address'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'school_lessons';

    public function school()
    {
        return $this->belongsTo('School','school_id');
    }

    public function subject()
    {
        return $this->belongsTo('Subject','subject_id');
    }

    public function visualizations()
    {
        return $this->hasMany('SchoolPhoneVisualization');
    }

    public function ratings()
    {
        return $this->hasMany('SchoolLessonRating');
    }

    public function availabilities()
    {
        return $this->hasMany('SchoolLessonAvailability');
    }

    /**
     * @return int
     */
    public function getNumberOfReviews()
    {
        return (int) $this->hasMany('SchoolLessonRating')->count();
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
     * @param $this_many
     * @return mixed
     */
    public function getFeaturedReviews($this_many) {
        $n = (int) $this_many;
        $featured = $this->ratings()
            ->where('total_helpful','>','0')
            ->orderByRaw('`yes_helpful`/IF(`total_helpful`=0,1,`total_helpful`) DESC')
            ->take($n)
            ->get();
        if(!count($featured)>0)
            $featured = $this->ratings()->orderBy('value')->take($n)->get();

        return $featured;
    }

}