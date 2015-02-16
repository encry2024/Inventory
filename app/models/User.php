<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static function tryRegister($data) {
		//get all data
		//data to validate
		//rules
		$rules = array(
			'username' => 'required|unique:users,username|alpha_num',
			'password' => 'required|confirmed',
			'firstname' => 'required',
			'lastname' => 'required',
			'password_confirmation' => 'required'
		);

		//create validation instance
		$validation = Validator::make(Input::all(), $rules);

		//check if validation successful
		if($validation->fails()) {
			return Redirect::back()
				->withErrors($validation)->withInput();
			//return var_dump($validation->messages());
		} else {
			$user = new User;
			$user->username = $data['username'];
			$user->password = Hash::make($data['password']);
			$user->firstname = $data['firstname'];
			$user->lastname = $data['lastname'];

			$user->save();

			$users_username = $user->username;
			$user_name = $user->firstname ." ". $user->lastname;
			
			$audits = new Audit;
			$audits->user = "-";
			$audits->event = "Create";
			$audits->field = "User";
			$audits->object = $users_username;
			$audits->save();

			return Redirect::to('/');
		}
	}

	public static function validateLogin($data) {
		$rules = array(
			'username' => 'required',
			'password' => 'required'
		);

		$validation =  Validator::make(Input::all(),$rules);

		if($validation->fails()) {
			$failed = $validation->failed();
			return  Redirect::to('auth/login')->with('error_index', $failed)->withErrors($validation)->withInput();
		} else {
			$credentials = array(
			  'username' => Input::get('username'),
			  'password' => Input::get('password')
			);
			if (Auth::attempt($credentials)) {
					return Redirect::to('mainpage');
			} else {
				return Redirect::to('auth/login')
				->with('flash_error', 'Your username/password was incorrect.')
				->withInput();
			}
		}
	}

}
