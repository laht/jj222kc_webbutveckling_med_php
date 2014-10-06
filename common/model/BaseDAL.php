<?php

namespace common\model;

class BaseDAL {

	public $mysqli;

 	public function __construct() {
 		$this->mysqli = new \mysqli("localhost", "root", "", "Bildblogg_v2");
 		$this->mysqli->set_charset('utf8');
 	}
}