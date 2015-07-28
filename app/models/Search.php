<?php

/**
 * Search
 *
 * @property integer $id 
 * @property string $address 
 * @property integer $subject_id 
 * @property string $keywords 
 * @property string $type 
 * @property integer $results 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Subject $subject 
 * @method static \Illuminate\Database\Query\Builder|\Search whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereSubjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereResults($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Search whereUpdatedAt($value)
 */
class Search extends Eloquent
{
    protected $fillable = ['address','keywords','type'];
    protected $dates = ['created_at','updated_at'];
    protected $table = 'searches';

    public function subject() {
        return $this->belongsTo('Subject','subject_id');
    }

}