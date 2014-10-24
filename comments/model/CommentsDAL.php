<?php

namespace comments\model;

require_once("comments/model/CommentsModel.php");

class CommentsDAL {

	private static $commentTable = 'comments';

	private $mysqli;

	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->mysqli = $baseDAL->mysqli;
	}

	public function getAllComments($postId) {
		$comments = array();
        $sql = "SELECT pk, comment, commenterId, ownerId, Date 
        		FROM ".self::$commentTable." 
        		WHERE ownerid='".$postId."';";

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql statement failed");
        }

        $statement->bind_result($pk, $comment, $commenterId, $ownerId, $date);        
        while ($statement->fetch()) {
        	$comments[] = new \comments\model\CommentsModel($comment, $commenterId, $date, $pk);
        }
        return array_reverse($comments);
	}

	public function addComment(\comments\model\CommentsModel $comment) {
		$text = $comment->comment;
		$userId = $comment->commentOwner;
		$postId = $comment->postId;

		if ($text == '' || $userId == '' || $postId == '') {
			throw new \Exception('Invalid comment input');
		}

		$sql = "INSERT INTO ".self::$commentTable."( comment, commenterId, ownerId ) VALUES(?, ?, ?)";        
		$statement = $this->mysqli->prepare($sql);

        if ($statement === false) {
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->bind_param("sii" ,$text, $userId, $postId) === false) {
            throw new \Exception("Binding of $sql failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql failed");
        }
	}

	public function deleteComment(\comments\model\CommentsModel $comment) {
        $sql = "DELETE FROM ".self::$commentTable." WHERE pk = $comment->commentId";    
        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql failed");
        }    
    }

    public function updateComment(\comments\model\CommentsModel $comment) {
        $text = $comment->comment;        
        if ($text == "") {
            throw new \Exception("Input was empty");
        }              
        $sql = "UPDATE ".self::$commentTable." SET comment = ? WHERE pk = $comment->commentId";    
        $statement = $this->mysqli->prepare($sql);      
        if ($statement === false) {
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->bind_param("s" ,$text) === false) {
            throw new \Exception("Binding of $sql failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql failed");
        }    
    }
}