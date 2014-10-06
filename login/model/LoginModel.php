<?php

namespace login\model;

require_once("common/model/UserDAL.php");

class LoginModel {

	private static $sessionUsername = "USERNAME";
	private static $sessionPassword = "PASSWORD";
	private static $sessionUser = "sessionUser";
	private static $userAgent = "HTTP_USER_AGENT";

	private $userDAL;

	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->userDAL = new \common\model\userDAL($baseDAL);
	}

	public function setSession(\common\model\User $user) {
		$_SESSION[self::$sessionUsername] = $user->username;
		$_SESSION[self::$sessionPassword] = $user->password;		
		$_SESSION[self::$sessionUser] = $_SERVER[self::$userAgent];
	}

	public function login(\common\model\User $user) {
		$this->validateUser($user);
		$this->setSession($user);
	}

	public function isSessionSet() {
		if (isset($_SESSION[self::$sessionUsername])
			&& isset($_SESSION[self::$sessionPassword])) {
			return true;
		}
	}

	//Remove the user from the persistent logged in state
	public function logout() {
		$_SESSION = array();
		session_destroy();
	}

	public function validateSession() {
		if ($_SESSION[self::$sessionUser] == $_SERVER[self::$userAgent]) {
			return true;
		}
	}

	private function validateUser(\common\model\User $user) {
		$dbUser = $this->userDAL->findUser($user);

		if ($user->username != $dbUser->username) {
			throw new \Exception("User does not exist");
		}
		if ($user->password != $dbUser->password) {
			throw new \Exception("Password does not match user");
		}
		/*if ($user->username != "asd") {
			throw new \Exception("Username does not exist");
		}
		if ($user->password != "123") {
			throw new \Exception("Password does not match username");
		}*/
	}
}