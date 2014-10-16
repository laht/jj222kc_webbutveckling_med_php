<?php

namespace register\view;

class RegisterView {

	//declare som static variables for our html form
	private static $USERNAME = 'username';
	private static $PASSWORD = 'password';
	private static $SUBMIT = 'RegisterView::submit';
	private static $SUBMITID = 'submitId';
	private static $USERID = 'usernameId';
	private static $PASSID = 'passwordId';
	private static $REGISTER = 'register';

	//message to show errors to the user
	private $message;

	public function userRegistrating() {
		if (isset($_GET[self::$REGISTER])) {
			return true;
		}
		return false;
	}

	public function userWantsToRegister() {
		if (isset($_POST[self::$SUBMIT])) {
			return true;
		}
		return false;
	}

	public function registrationFailed() {
		$username = $this->getUsername();
		$password = $this->getPassword();

		if (strlen($username) < 3) {
			$this->message = 'Användarnamnet måste minst vara 3 bokstäver';
		}
		else if (strlen($password) < 3) {
			$this->message .= 'Lösenordet måste minst vara 3 bokstäver';
		}
		else {
			$this->message = 'Användarnamnet är upptaget';
		}		
	}

	public function getHTMLForm() {
		$html = 
		"<div id='registerForm'>
			<form action='?register' method='post' enctype='multipart/form-data'>				
				<fieldset>
					<p>$this->message</p>
					<input id='UsernameID' placeholder='Username' name='".self::$USERNAME."'/> 
					<input id='PasswordID' placeholder='Password' type='password' value='' name='".self::$PASSWORD."'/>
					<input id='SubmitID' type='submit' value='Register' name='".self::$SUBMIT."'/> 
				</fieldset>
			</form>
		</div>";
		return $html;
	}

	public function getUserData() {
		$username = strip_tags($this->getUsername());
		$password = $this->getPassword();
		return new \common\model\User($username, $password);
	}

	public function getUsername() {
		if (isset($_POST[self::$USERNAME])) {
			return $_POST[self::$USERNAME];
		}
	}

	public function getPassword() {
		if (isset($_POST[self::$PASSWORD])) {
			return $_POST[self::$PASSWORD];
		}
	}

}