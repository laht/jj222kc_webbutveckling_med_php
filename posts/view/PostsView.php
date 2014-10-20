<?php

namespace posts\view;

include_once("posts/model/postsDAL.php");

class PostsView {

	private static $TITLE = 'PostView::Title';
	private static $TEXT = 'PostView::Text';
	private static $SUBMIT = 'AddPost';
	private static $POSTID = 'postid';
	private static $FILEUPLOAD = 'fileInput';

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
			$html .= "<h2><a href='?postid=$post->ID'>$post->Title</a></h2>";
			$html .= "<img src='$post->imagePath' class='img-thumb' />";
			$html .= "</div>";
		}
		$html .= "</div>";
		return $html;
	}

	public function getSingle($id) {
		$post = $this->postsDAL->getSinglePost($id);
		$html = "<div id='post'>
					<h2>$post->Title</h2>
					<h3>By $post->username</h3>
					<img src='$post->imagePath' />
					<p>$post->description</p>
				</div>";
		return $html;
	}

	public function showSingle() {
		if (isset($_GET[self::$POSTID]) && !empty($_GET[self::$POSTID])) {
			return true;
		}
		return false;
	}

	public function getPostId() {
		if (isset($_GET[self::$POSTID])) {
			return $_GET[self::$POSTID];
		}
	}

	public function postFailed() {

	}
}