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
	//return html
	public function getHTMLForm() {
		$html =
		"<div id='login_form'>
			<form action='?login' method='post' enctype='multipart/form-data'>
				<fieldset>
					<p>$this->message</p>
					<input id=".self::$USERID." placeholder='Användarnamn' name=".self::$USERNAME." />
					<input id=".self::$PASSID." placeholder='Lösenord' type='password' name=".self::$PASSWORD." />
					<input id=".self::$SUBMITID." type='submit' name=".self::$SUBMIT." value='Logga in' />					
					<input id=".self::$REMEMBER." type='checkbox' name=".self::$REMEMBER." />
				</fieldset>
			</form>
			<a id='registerBtn' href='?register'>Registrera</a>
		</div>";

		return $html;
	}

	//Return html for the logged in state header
	//return html
	public function getLoggedInHeader() {
		$html = 
		"Logged in as ".$_SESSION['USERNAME']."
			<a class='logoutBtn' href='?".self::$LOGOUT."'>Logout</a>
		";
		return $html;
	}

	//Remove the user from the persistent logged in state
	public function logout() {
		$this->removeCookies();
	}

	//the login was successful
	public function loginSuccess() {
		//get the users information
		$username = $this->getUsername();
		$password = $this->model->hashPassword($this->getPassword());
		//and if the user wants to be saved
		if ($this->rememberUser()) {
			//set cookies for the username and password
			setcookie(self::$USERNAME, $username, $this->model->cookieExperation());
			setcookie(self::$PASSWORD, $password, $this->model->cookieExperation());
		}
	}

	//set the expiration time of applications 
	//cookies to -10 to remove them
	private function removeCookies() {
		setcookie(self::$USERNAME, "", time()-10);
		setcookie(self::$PASSWORD, "", time()-10);
	}

	//Does the user want to log out?
	//return bool
	public function userLoggingOut() {
		return isset($_GET[self::$LOGOUT]);
	}

	public function rememberUser() {		
		return isset($_POST[self::$REMEMBER]);
	}

	//Does the user want to log in?
	//return bool
	public function userLoggingIn() {
		return isset($_POST[self::$SUBMIT]);
	}

	//Fetch the username input by the user
	//return string
	private function getUsername() {
		if (isset($_POST[self::$USERNAME])) {
			return $_POST[self::$USERNAME];
		}
	}

	//Fetch the password input by the user
	//return string
	private function getPassword() {
		if (isset($_POST[self::$PASSWORD])) {
			return $_POST[self::$PASSWORD];
		}
	}

	//Return the input from the user as a \common\model\User object
	public function getUserLoginInput() {
		//does the user have any cookies from this application
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
	//return bool
	public function userCookies() {		
		if (isset($_COOKIE[self::$USERNAME]) && isset($_COOKIE[self::$PASSWORD])) {
			return true;
		}
		return false;
	}

	//If the login should fail, asign a message for the user
	public function loginFail() {
		//if the user has any cookies available
		if ($this->userCookies()) {
			//there is something wrong with the cookies data
			$this->message = "<p>Fel information i cookies</p>";
			//remove the users cookies
			$this->removeCookies();
		} else {
			//empty usernames are not allowed
			if ($this->getUsername() == "") {
				$this->message = "<p>Ange ett Användarnamn!</p>";
			}
			//empty passwords are not allowed 
			else if ($this->getPassword() == "") {
				$this->message = "<p>Ange ett Lösenord!</p>";
			} 
			//the username and password doesn't match
			else {
				$this->message = "<p>Fel Användarnamn eller Lösenord</p>";
			}
		}
	}
}

