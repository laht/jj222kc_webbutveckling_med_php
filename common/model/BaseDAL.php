<?php

namespace common\model;

//basic class that connects to the database
class BaseDAL {

	//member variable to help use the database connection in other classes
	public $mysqli;

 	public function __construct() { 		
 		$this->mysqli = new \mysqli("localhost", "467985", "sonickkk123", "467985");
 		$this->mysqli->set_charset('utf8');
 	}
}