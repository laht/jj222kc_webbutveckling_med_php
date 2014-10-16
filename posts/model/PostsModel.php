<?php

namespace posts\model;

class postsModel {

	public $username;

	public $Title;

	public $Text;

	public $imagePath;

	public $ID;
	const postId = "postId";

	//set membervariables
	public function __construct($username, $postID, $postTitle, $postText, $imagePath) {
		$this->username = $username;
		$this->Title = $postTitle;
		$this->Text = $postText;
		$this->ID = $postID;
		$this->imagePath = $imagePath;
		$this->savePostId($this->ID);
	}	

	//save the current postId to session
	public function savePostId($id) {
		$_SESSION[self::postId] = $id;
	}

	public function validatePost(\posts\model\Post $post) {
		if ($post->Title == "") {
			throw new \Exception("The post must have a title, none given");
		}
		if ($post->username == "") {
			throw new \Exception("The post must have an author, none given");
		}
	}
}