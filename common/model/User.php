<?php

namespace common\model;

class User {

	public $username;
	public $password;

	public function __construct($username, $password) {

		$this->username = $username;
		$this->password = $password;
	}

	public function encryptPassword() {
		return md5($this->password);
	}
}