<?php

namespace comments\model;

//class to represent a comment object
class CommentsModel {

	public $date;
	public $comment;
	public $commentOwner;
	public $postId;
	public $commentId;

	public function __construct($comment, $commentOwner, $date, $id='') {
		$this->comment = $comment;
		$this->commentOwner = $commentOwner;
		$this->date = $date;
		$this->commentId = $id;
		$this->setPostId();
	}

	//save the posts id to the session
	private function setPostId() {
		if (isset($_SESSION[\posts\model\PostsModel::postId])) {
			$this->postId = $_SESSION[\posts\model\PostsModel::postId];
		}
	}
}