<?php

namespace login\view;

require_once("common/model/User.php");

class LoginView {

	private static $USERNAME = 'username';
	private static $PASSWORD = 'password';
	private static $SUBMIT = 'submit';
	private static $SUBMITID = 'submitId';
	private static $USERID = 'usernameId';
	private static $PASSID = 'passwordId';

	public $message;

	public function getHTMLForm() {
		$html =
		"<div id='login_form'>
			<form action='?login' method='post' enctype='multipart/form-data'>
				<fieldset>
					<legend>Login</legend>
					<p>$this->message</p>
					<input id=".self::$USERID." placeholder='Username' name=".self::$USERNAME." />
					<input id=".self::$PASSID." placeholder='Password' name=".self::$PASSWORD." />
					<input id=".self::$SUBMITID." type=".self::$SUBMIT." name=".self::$SUBMIT." />
				</fieldset>
			</form>
		</div>";

		return $html;
	}

	public function userLoggingIn() {
		return isset($_POST[self::$SUBMIT]);
	}

	private function getUsername() {
		return $_POST[self::$USERNAME];
	}

	private function getPassword() {
		return $_POST[self::$PASSWORD];
	}

	public function getUserLoginInput() {
		return new \common\model\User($this->getUsername(), $this->getPassword());
	}

	public function loginFail($message) {
		$this->message = $message;
	}
}

