<?php

namespace register\model;

class RegisterModel {

	const minUsernameLength = 3;
	const minPasswordLength = 3;

	//user access object for the database
	private $userDAL;

	//initiate the userDAL member variable
	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->userDAL = new \common\model\UserDAL($baseDAL);
	}

	public function register(\common\model\User $user) {
		$this->validateUser($user);
		//if user input is valid add it to the db
		$this->userDAL->addUser($user);
	}

	//validate the users input
	public function validateUser(\common\model\User $user) {
		$username = $user->username;
		$password = $user->password;

		if ($this->userDAL->userExists($user)) {
			throw new \Exception('Username is taken');
		}
		else if (strlen($username) < self::minUsernameLength) {
			throw new \Exception('Username is too short');			
		}
		else if (strlen($password) < self::minPasswordLength) {
			throw new \Exception('Password is too short');			
		}
	}
}