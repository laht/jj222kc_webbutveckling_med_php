<?php

namespace common\model;

require_once("common/model/User.php");

class UserDAL {

    //database table for users
	private static $tableName = "users";
    //mysqli connection to the database
    private $mysqli;

    //initiate the mysqli connection
	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->mysqli = $baseDAL->mysqli;
	}

    //find the entered user in the database
	public function findUser(\common\model\User $user) {
		return $this->getUser($user->username);
	}

    //find the user in the database by it's id
    public function findUserById($id) {
        return $this->getUserById($id);
    }

    //see if the entered username exsists
    public function userExists(\common\model\User $user) {
        $dbUser = $this->getUser($user->username);
        if ($dbUser->username != null) {
            return true;
        }
        else {
            return false;
        }
    }

    //add the eneterd user to the database
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

    //returns a user from an Id
    private function getUserById($userId) {
        $sql = "SELECT username, password, pk FROM ".self::$tableName." WHERE pk ='".$userId."';";
        $statement = $this->mysqli->prepare($sql);

        if ($statement === false) {         
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql statement failed");
        }       

        $statement->bind_result($username, $password, $id); 
        $statement->fetch();
        $user = new \common\model\User($username, $password, $id);

         if ($user->username == "" || $user->password == "") {
            throw new \Exception("That user does not exist");
        }

        return $user;
    }

    //returns a user from a username
	private function getUser($userinput) {
        $sql = "SELECT username, password, pk FROM ".self::$tableName." WHERE username ='".$userinput."';";

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {        	
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql statement failed");
        }

        $statement->bind_result($username, $password, $id); 
        $statement->fetch();
        $user = new \common\model\User($username, $password, $id);
        return $user;
    }
}