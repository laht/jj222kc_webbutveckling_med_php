<?php

namespace login\model;

class LoginModel {

	private static $sessionUsername = "USERNAME";
	private static $sessionPassword = "PASSWORD";
	private static $sessionUser = "sessionUser";
	private static $userAgent = "HTTP_USER_AGENT";

	public function setSession(\common\model\User $user) {
		$_SESSION[self::$sessionUsername] = $user->username;
		$_SESSION[self::$sessionPassword] = $user->password;		
		$_SESSION[self::$sessionUser] = $_SERVER[self::$userAgent];
	}

	public function login(\common\model\User $user) {
		$this->validateUser($user);
		$this->setSession($user);;
	}

	private function validateUser(\common\model\User $user) {
		if ($user->username != "asd") {
			throw new \Exception("Username does not exist");
		}
		if ($user->password != "123") {
			throw new \Exception("Password does not match username");
		}
	}
}