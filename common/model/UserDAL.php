<?php

namespace common\model;

require_once("common/model/User.php");

class UserDAL {

	private static $tableName = "users";

	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->mysqli = $baseDAL->mysqli;
	}

	public function findUser(\common\model\User $user) {
		return $this->getUser($user->username);
	}

	private function getUser($username) {
        $sql = "SELECT username, password, pk FROM ".self::$tableName." WHERE username ='".$username."';";

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {        	
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql statement failed");
        }
        $result = $statement->get_result();
        $object = $result->fetch_array(MYSQLI_ASSOC);        
        $user = new \common\model\User($object["username"], $object["password"]);
        
        return $user;
    }
}