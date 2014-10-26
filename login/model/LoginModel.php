<?php

namespace login\model;

require_once("common/model/UserDAL.php");

class LoginModel {

	//declare static variables for global variables
	private static $sessionUsername = "USERNAME";
	private static $sessionPassword = "PASSWORD";
	private static $sessionUser = "sessionUser";
	private static $userAgent = "HTTP_USER_AGENT";

	//user data access class
	private $userDAL;

	//initiate the userDAL
	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->userDAL = new \common\model\userDAL($baseDAL);
	}

	//set the users session in the applikation
	//save their username and password and the useragent
	public function setSession(\common\model\User $user) {
		$_SESSION[self::$sessionUsername] = $user->username;
		$_SESSION[self::$sessionPassword] = $user->password;		
		$_SESSION[self::$sessionUser] = $_SERVER[self::$userAgent];
	}

	//validate the user and then set the users session
	public function login(\common\model\User $user) {
		$this->validateUser($user);
		$this->setSession($user);
	}

	//return if the user has a session set
	public function isSessionSet() {
		if (isset($_SESSION[self::$sessionUsername])
			&& isset($_SESSION[self::$sessionPassword])) {
			return true;
		}
	}

	//return the session users username
	public function getSessionUser() {
		if (isset($_SESSION[self::$sessionUsername])) {
			return $_SESSION[self::$sessionUsername];
		}
	} 

	//set the expiration time for the users cookies
	public function cookieExperation() {
		return time() + 360;
	}

	//encrypt a given password and return it
	public function hashPassword($password) {
		return md5($password);
	}

	//remove the user from the persistent logged in state
	public function logout() {
		$_SESSION = array();
		session_destroy();
	}

	public function validateSession() {
		if ($_SESSION[self::$sessionUser] == $_SERVER[self::$userAgent]) {
			return true;
		}
	}

	//validate the users login data to allow login
	private function validateUser(\common\model\User $user) {
		//try to find the user that wants to login
		$dbUser = $this->userDAL->findUser($user);
		//if no user is found throw exceptions everywhere
		if (is_null($dbUser->username)) {
			throw new \Exception("User does not exist");
		}
		//if the password does not match the username throw even more exceptions
		if ($user->password != $dbUser->password) {
			throw new \Exception("Password does not match user");
		}
	}
}