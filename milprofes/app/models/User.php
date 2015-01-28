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

}
