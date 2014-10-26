<?php

namespace posts\model;

//class that represents a post
class postsModel {

	public $username;
	public $Title;
	public $description;
	public $imagePath;

	public $ID;
	const postId = "postId";

	//set class properties
	public function __construct($username, $postID, $postTitle, $description, $imagePath) {
		$this->username = $username;
		$this->Title = $postTitle;
		$this->description = $description;
		$this->ID = $postID;
		$this->imagePath = $imagePath;
		$this->savePostId($this->ID);
	}	

	//save the current postId to session
	public function savePostId($id) {
		$_SESSION[self::postId] = $id;
	}

	public function validatePost(\posts\model\PostsModel $post) {
		if ($post->Title == "") {
			throw new \Exception("The post must have a title, none given");
		}
		if ($post->username == "") {
			throw new \Exception("The post must have an author, none given");
		}
	}
}