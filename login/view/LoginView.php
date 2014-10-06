<?php

namespace login\view;

require_once("common/model/User.php");

class LoginView {

	//Declare some static variables
	private static $LOGOUT = "logout";
	private static $USERNAME = 'username';
	private static $PASSWORD = 'password';
	private static $SUBMIT = 'submit';
	private static $SUBMITID = 'submitId';
	private static $USERID = 'usernameId';
	private static $PASSID = 'passwordId';

	public $message;

	//Return html for the login form in the logged out state
	public function getHTMLForm() {
		$html =
		"<div id='login_form'>
			<form action='?login' method='post' enctype='multipart/form-data'>
				<fieldset>
					<legend>Login</legend>
					<p>$this->message</p>
					<input id=".self::$USERID." placeholder='Användarnamn' name=".self::$USERNAME." />
					<input id=".self::$PASSID." placeholder='Lösenord' name=".self::$PASSWORD." />
					<input id=".self::$SUBMITID." type=".self::$SUBMIT." name=".self::$SUBMIT." value='Logga in' />
				</fieldset>
			</form>
		</div>";

		return $html;
	}

	//Return html for the logged in state header
	public function getLoggedInHeader() {
		$html = 
		"Logged in as ".$_SESSION['USERNAME']."
			<a class='logoutBtn' href='?".self::$LOGOUT."'>Logout</a>
		";
		return $html;
	}

	//Remove the user from the persistent logged in state
	public function logout() {
		//$this->removeCookies();
	}

	//Does the user want to log out?
	public function userLoggingOut() {
		return isset($_GET[self::$LOGOUT]);
	}

	//Does the user want to log in?
	public function userLoggingIn() {
		return isset($_POST[self::$SUBMIT]);
	}

	//Fetch the username input by the user
	private function getUsername() {
		return $_POST[self::$USERNAME];
	}

	//Fetch the password input by the user
	private function getPassword() {
		return $_POST[self::$PASSWORD];
	}

	//Return the input from the user as a \common\model\User object
	public function getUserLoginInput() {
		return new \common\model\User($this->getUsername(), $this->getPassword());
	}

	//If the login should fail, asign a message for the user
	public function loginFail($message) {
		$this->message = $message;
	}
}

