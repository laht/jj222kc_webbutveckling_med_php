<?php

namespace posts\model;

require_once("posts/model/PostsModel.php");

class PostsDAL {

	private static $usersTable = "users";
	private static $postsTable = "posts";
	private $mysqli;
	
	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->mysqli = $baseDAL->mysqli;
	}

    public function getSinglePost($postId) {
        $sql = "SELECT users.username, posts.postTitle, posts.pk, posts.description, posts.image
                FROM ".self::$usersTable."
                INNER JOIN ".self::$postsTable." ON users.pk = posts.ownerId
                WHERE posts.pk = ".$postId.";";

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {         
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql statement failed");
        }

        $statement->bind_result($username, $postTitle, $pk, $description, $image);
        if ($statement->fetch()) {
            $post = new \posts\model\PostsModel($username, $pk, $postTitle, $description, $image);
        }
        
        return $post;
    }

	public function getAllPosts() {
		$posts = array();
		$sql = "SELECT users.username, posts.postTitle, posts.pk, posts.description, posts.image
        		FROM ".self::$usersTable."
        		INNER JOIN ".self::$postsTable." ON users.pk = posts.ownerId;";

		$statement = $this->mysqli->prepare($sql);
        if ($statement === false) {
            throw new \Exception("Preparation of $sql statement failed");
        }
        if ($statement->execute() === false) {
            throw new \Exception("Execution of $sql statement failed");
        }        
        $statement->bind_result($username, $postTitle, $id, $description, $image);

        while ($statement->fetch()) {
            $posts[] = new \posts\model\PostsModel($username, $id, $postTitle, $description, $image);
        }

        return array_reverse($posts);
	}
}