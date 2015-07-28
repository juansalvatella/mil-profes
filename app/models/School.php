<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * School
 *
 * @property integer $id 
 * @property string $name 
 * @property string $slug 
 * @property string $address 
 * @property string $town 
 * @property string $postalcode 
 * @property string $region 
 * @property string $cif 
 * @property string $email 
 * @property string $phone 
 * @property string $phone2 
 * @property string $link_web 
 * @property string $link_facebook 
 * @property string $link_twitter 
 * @property string $link_linkedin 
 * @property string $link_googleplus 
 * @property string $link_instagram 
 * @property string $logo 
 * @property string $video 
 * @property string $description 
 * @property float $lat 
 * @property float $lon 
 * @property string $status 
 * @property string $origin 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolLesson[] $lessons 
 * @property-read \Illuminate\Database\Eloquent\Collection|\SchoolPic[] $pics 
 * @method static \Illuminate\Database\Query\Builder|\School whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereTown($value)
 * @method static \Illuminate\Database\Query\Builder|\School wherePostalcode($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereCif($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\School wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\School wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLinkWeb($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLinkFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLinkTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLinkLinkedin($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLinkGoogleplus($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLinkInstagram($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereVideo($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereLon($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereOrigin($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\School whereDeletedAt($value)
 */
class School extends Eloquent implements SluggableInterface
{
    use SluggableTrait, SoftDeletingTrait;

    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'name',
        'address',
        'cif',
        'email',
        'phone',
        'phone2',
        'link_web',
        'link_facebook',
        'link_twitter',
        'link_linkedin',
        'link_googleplus',
        'link_instagram',
        'video',
        'description'
    ];
    protected $table = 'schools';

    public function lessons()
    {
        return $this->hasMany('SchoolLesson');
    }

    //each school has many pics
    public function pics()
    {
        return $this->hasMany('SchoolPic');
    }

    /**
     * @return float
     */
    public function getSchoolAvgRating()
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
        if($n)
        {
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