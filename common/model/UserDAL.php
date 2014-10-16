<?php

namespace common\model;

include_once("common/model/User.php");

class UserDAL {

	private static $tableName = "users";

	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->mysqli = $baseDAL->mysqli;
	}

	public function findUser(\common\model\User $user) {
		return $this->getUser($user->username);
	}

    public function userExists(\common\model\User $user) {
        $dbUser = $this->getUser($user->username);
        if ($dbUser->username != null) {
            return true;
        }
        else {
            return false;
        }
    }

    public function addUser(\common\model\User $user) {
        $username = $user->username;
        $password = $user->encryptPassword();

        $sql = "INSERT INTO " . self::$tableName . " ( username, password ) VALUES(?, ?)";

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->bind_param("ss", $username, $password) === false) {
            throw new \Exception("Binding of $sql failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql failed");
        }
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
        /*$result = $statement->get_result();
        $object = $result->fetch_array(MYSQLI_ASSOC);        
        $user = new \common\model\User($object["username"], $object["password"]);*/

        $statement->bind_result($username, $password, $id); 
        $statement->fetch();
        $user = new \common\model\User($username, $password, $id);
        
        return $user;
    }
}