<?php

namespace common\model;

class User {

	public $username;
	public $password;
	public $id;

	public function __construct($username, $password, $id='') {
		$this->username = $username;
		$this->password = $password;
		$this->id = $id;
	}

	public function encryptPassword() {
		return md5($this->password);
	}
}