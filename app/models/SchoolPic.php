<?php

/**
 * SchoolPic
 *
 * @property integer $id 
 * @property integer $school_id 
 * @property string $pic 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \School $school 
 * @method static \Illuminate\Database\Query\Builder|\SchoolPic whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPic whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPic wherePic($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPic whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SchoolPic whereUpdatedAt($value)
 */
class SchoolPic extends Eloquent
{
    protected $fillable = ['pic'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'school_pics';

    //Each pic belongs to one school
    public function school() {
        return $this->belongsTo('School','school_id');
    }

}