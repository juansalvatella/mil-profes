<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface {

	use ConfideUser, HasRole;

	protected $fillable = [];

	public function student()
	{
		return $this->hasOne('Student');
	}

	public function teacher()
	{
		return $this->hasOne('Teacher');
	}

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

	private function calcElapsedDaysSincePayment(DateTime $lastpaymentdatetime)
	{
		$datetime1 = new DateTime('now');
		$datetime2 = $lastpaymentdatetime;
		$interval = $datetime2->diff($datetime1);
		$elapsedDays = (int) $interval->format('%R%a'); //pasar a días

		return $elapsedDays;
	}

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
