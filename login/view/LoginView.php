<?php

namespace login\view;

require_once("common/model/User.php");

class LoginView {

	//Declare some static variables
	private static $LOGOUT = 'logout';
	private static $USERNAME = 'username';
	private static $PASSWORD = 'password';
	private static $SUBMIT = 'LoginView::submit';
	private static $SUBMITID = 'submitId';
	private static $USERID = 'usernameId';
	private static $PASSID = 'passwordId';
	private static $REMEMBER = 'remember';
	private static $REGISTER = 'register';

	//string message for the user
	public $message;

	// \login\model\LoginModel
	private $model;

	public function __construct(\login\model\LoginModel $loginModel) {
		$this->model = $loginModel;
	}

	//Return html for the login form in the logged out state
	public function getHTMLForm() {
		$html =
		"<div id='login_form'>
			<form action='?login' method='post' enctype='multipart/form-data'>
				<fieldset>
					<p>$this->message</p>
					<input id=".self::$USERID." placeholder='Användarnamn' name=".self::$USERNAME." />
					<input id=".self::$PASSID." placeholder='Lösenord' type='password' name=".self::$PASSWORD." /> <br />
					<input id=".self::$SUBMITID." type='submit' name=".self::$SUBMIT." value='Logga in' />
					eller
					<a id='registerBtn' href='?register'>Registrera</a>				
					<label for=".self::$REMEMBER.">Kom ihåg mig</label>
					<input id=".self::$REMEMBER." type='checkbox' name=".self::$REMEMBER." />
				</fieldset>
			</form>
			
		</div>";

		return $html;
	}

	//Return html for the logged in state header
	public function getLoggedInHeader() {
		$html = 
			"<div id='loggedInHeader'>
				Inloggad som ".$_SESSION['USERNAME']." <br />
				<a class='logoutBtn' href='?".self::$LOGOUT."'>Logga ut</a>
			</div>";

		return $html;
	}

	//Remove the user from the persistent logged in state
	public function logout() {
		$this->removeCookies();
	}

	//the login was successful
	public function loginSuccess() {
		$username = $this->getUsername();
		$password = $this->model->hashPassword($this->getPassword());
		//and if the user wants to be saved
		if ($this->rememberUser()) {
			setcookie(self::$USERNAME, $username, $this->model->cookieExperation());
			setcookie(self::$PASSWORD, $password, $this->model->cookieExperation());
		}
	}

	//function to remove the users saved login data
	private function removeCookies() {
		setcookie(self::$USERNAME, "", time()-10);
		setcookie(self::$PASSWORD, "", time()-10);
	}

	//Does the user want to log out?
	public function userLoggingOut() {
		return isset($_GET[self::$LOGOUT]);
	}

	public function rememberUser() {		
		return isset($_POST[self::$REMEMBER]);
	}

	//Does the user want to log in?
	public function userLoggingIn() {
		return isset($_POST[self::$SUBMIT]);
	}

	//Fetch the username input by the user
	private function getUsername() {
		if (isset($_POST[self::$USERNAME])) {
			return $_POST[self::$USERNAME];
		}
	}

	//Fetch the password input by the user
	private function getPassword() {
		if (isset($_POST[self::$PASSWORD])) {
			return $_POST[self::$PASSWORD];
		}
	}

	//Return the input from the user as a \common\model\User object
	public function getUserLoginInput() {
		if ($this->userCookies()) {
			$username = $_COOKIE[self::$USERNAME];
			$password = $_COOKIE[self::$PASSWORD];
			return new \common\model\User($username, $password);
		}
		else {
			$username = $this->getUsername();
			$password = $this->model->hashPassword($this->getPassword());
			return new \common\model\User($username, $password);	
		}
	}

	//if the user has any cookies from this application
	public function userCookies() {		
		if (isset($_COOKIE[self::$USERNAME]) && isset($_COOKIE[self::$PASSWORD])) {
			return true;
		}
		return false;
	}

	//If the login should fail, asign a message for the user
	public function loginFail() {
		if ($this->userCookies()) {
			$this->message = "<p>Fel information i cookies</p>";
			$this->removeCookies();
		} else {
			if ($this->getUsername() == "") {
				$this->message = "<p>Ange ett Användarnamn!</p>";
			}
			else if ($this->getPassword() == "") {
				$this->message = "<p>Ange ett Lösenord!</p>";
			}
			else {
				$this->message = "<p>Fel Användarnamn eller Lösenord</p>";
			}
		}
	}
}

