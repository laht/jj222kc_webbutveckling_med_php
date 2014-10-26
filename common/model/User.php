<?php

namespace common\model;
	
//class that represents a user object
class User {

	public $username;
	public $password;
	//value thats set for users that exist in the database
	public $id;

	public function __construct($username, $password, $id='') {
		$this->username = $username;
		$this->password = $password;
		$this->id = $id;
	}

	//set the users clear text password as an ecrypted string
	public function encryptPassword() {
		return md5($this->password);
	}
}