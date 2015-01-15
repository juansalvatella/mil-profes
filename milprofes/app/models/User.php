<?php

//Test user class. TEST PURPOSES ONLY. Delete before publishing.

//use Illuminate\Auth\UserTrait;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Reminders\RemindableInterface;
//use LaravelBook\Ardent\Ardent;
//
//class User extends Ardent implements UserInterface, RemindableInterface {
//	use UserTrait, RemindableTrait;
//
//	protected $fillable = [];
//	protected $table = 'users';
//	// protected $hidden = array('password', 'remember_token');
//	public static $rules = array(
//		'email' => 'required'
//	);
//}

//Good and final user class
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
