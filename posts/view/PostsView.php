<?php

namespace posts\view;

getcwd();
include_once("posts/model/postsDAL.php");

class PostsView {

	private $postDAL;
	private $message;

	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->postsDAL = new \posts\model\PostsDAL($baseDAL);
	}

	public function getAllPosts() {		
		$posts = $this->postsDAL->getAllPosts();
		$html = "<div id='posts'>";
		foreach ($posts as $post) {
			$html .= "<div class='post'>";
			$html .= "<h2><a href='?'>$post->Title</a></h2>";
			$html .= "<img src='$post->imagePath' class='img-thumb' />";
			$html .= "</div>";
		}
		$html .= "</div>";
		return $html;
	}

	public function postFailed() {

	}
}