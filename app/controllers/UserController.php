<?php

class UserController extends BaseController {


	public function registerUser() {
		$register = User::tryRegister(Input::all());
		return $register;
	}

}