<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

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
