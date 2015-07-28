<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * User
 *
 * @property integer $id 
 * @property string $username 
 * @property string $slug 
 * @property string $name 
 * @property string $lastname 
 * @property string $email 
 * @property string $phone 
 * @property string $address 
 * @property string $town 
 * @property string $postalcode 
 * @property string $region 
 * @property \Carbon\Carbon $date_of_birth 
 * @property string $gender 
 * @property string $link_web 
 * @property string $link_facebook 
 * @property string $link_twitter 
 * @property string $link_linkedin 
 * @property string $link_googleplus 
 * @property string $link_instagram 
 * @property string $description 
 * @property string $avatar 
 * @property float $lat 
 * @property float $lon 
 * @property string $password 
 * @property string $confirmation_code 
 * @property string $remember_token 
 * @property boolean $confirmed 
 * @property string $status 
 * @property string $origin 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \Student $student 
 * @property-read \Teacher $teacher 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust::role')[] $roles 
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereTown($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePostalcode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkWeb($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkLinkedin($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkGoogleplus($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLinkInstagram($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLon($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereOrigin($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereDeletedAt($value)
 */
class User extends Eloquent implements ConfideUserInterface, SluggableInterface {

	use ConfideUser, HasRole, SluggableTrait, SoftDeletingTrait;

    protected $sluggable = ['build_from' => 'username', 'save_to' => 'slug'];
    protected $dates = ['date_of_birth','deleted_at'];
    protected $fillable = [
		'username',
		'name',
		'lastname',
		'email',
		'phone',
		'address',
		'link_web',
		'link_facebook',
		'link_twitter',
		'link_linkedin',
		'link_googleplus',
		'link_instagram',
		'description'
	];
	protected $table = 'users';
	protected $guarded = [];

	public function student()
	{
		return $this->hasOne('Student');
	}

	public function teacher()
	{
		return $this->hasOne('Teacher');
	}

	/**
	 * @return bool
     */
	public function thisUserPaymentIsCurrent()
	{
		$lastPaymentDate = new DateTime($this->lastpayment);
		$daysSinceLastPayment = $this->calcElapsedDaysSincePayment($lastPaymentDate);
		if ($daysSinceLastPayment < 33)
			$itIsCurrent = true;
		else
			$itIsCurrent = false;

		return $itIsCurrent;
	}

	/**
	 * @param DateTime $lastpaymentdatetime
	 * @return int
     */
	private function calcElapsedDaysSincePayment(DateTime $lastpaymentdatetime)
	{
		$datetime1 = new DateTime('now');
		$datetime2 = $lastpaymentdatetime;
		$interval = $datetime2->diff($datetime1);
		$elapsedDays = (int) $interval->format('%R%a'); //pasar a días

		return $elapsedDays;
	}

	/**
	 * @return bool
     */
	public function updateLastPaymentDate()
	{
		$today = new DateTime('now');
		if ($user = Confide::user())
		{
			$user->lastpayment = $today->format('y-m-d H:i:s');
			$updated = $user->save();
		} else {
			$updated = false;
		}

		return $updated;
	}
}
