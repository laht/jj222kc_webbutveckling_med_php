<?php

namespace posts\view;

include_once("posts/model/postsDAL.php");

class PostsView {

	private static $TITLE = 'PostView::Title';
	private static $TEXT = 'PostView::Text';
	private static $SUBMIT = 'addpost';
	private static $POSTID = 'postid';
	private static $FILEUPLOAD = 'fileInput';
	private static $POSTSPERPAGE = 12;
	private static $PAGENR = "page";


	private $postDAL;
	private $message;
	private $numberOfPages;

	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->postsDAL = new \posts\model\PostsDAL($baseDAL);
	}

	public function getPostHeader() {
		$html = "<div id='uploadBtn'>
					<a href='?addpost'>Ladda upp bild</a>
				</div>";
		return $html;
	}

	public function addingPost() {
		return isset($_GET[self::$SUBMIT]);
	}

	private function getNumberOfPages() {
		$total = $this->postsDAL->getNumberOfRows();
		$pageNumber = ceil($total/self::$POSTSPERPAGE);
		return $pageNumber;
	}

	private function getPageNr() {
		if (isset($_GET[self::$PAGENR])) {
			return $_GET[self::$PAGENR];
		}
		else {
			return 0;
		}
	}

	private function getPostsRange() {
		$pageNr = $this->getPageNr();		
		$start = $pageNr*self::$POSTSPERPAGE;
		$end = $start+self::$POSTSPERPAGE;

		return array('start' => $start, 'end' => $end);
	}

	public function postSuccess() {
		header("Location:http://www.".getenv('HTTP_HOST'));
		die();
	}

	public function getAllPosts() {
		$nrPages = $this->getNumberOfPages();
		$range = $this->getPostsRange();
		$posts = $this->postsDAL->getAllPosts($range['start'], $range['end']);
		
		$html = "<div id='posts'>";
		foreach ($posts as $post) {
			$html .= "<div class='post'>";
			$html .= "<h2><a href='?postid=$post->ID'>$post->Title</a></h2>";
			$html .= "<div class='post-img'>";
			$html .= "<img src='$post->imagePath' class='img-thumb' />";
			$html .= "</div>";
			$html .= "</div>";
		}
		$html .= "<div class='clearfix'></div>";
		$html .= "</div>";
		$html .= "<div id='pagination'>";
		for ($i=0; $i < $nrPages; $i++) { 
			$pageNr = $i;
			$html .= "<a href='?page=$pageNr'>$pageNr</a>";
		}
		$html .= "</div>";
		
		return $html;
	}

	public function getAddPost() {
		$html = 
		"<div id='addPostForm'>
			<form action='?".self::$SUBMIT."' method='post' enctype='multipart/form-data'>				
				<fieldset>
					<p>$this->message</p>
					<input id='TitleID' placeholder='Titel' name='".self::$TITLE."' /> 
					<input id='uploadId' type='file' name='".self::$FILEUPLOAD."' />
					<textarea maxlength='255' id='PostTextID' 
					 placeholder='Bildtext' rows='4' cols='17' name='".self::$TEXT."' ></textarea> <br />
					<input id='SubmitID' type='submit' value='Send' name='".self::$SUBMIT."' /> 
				</fieldset>
			</form>
		</div>";

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

	public function userPosting() {
		return isset($_POST[self::$SUBMIT]);
	}

	public function getUploadedFile() {
		if (isset($_FILES[self::$FILEUPLOAD])) {
			return $_FILES[self::$FILEUPLOAD];
		}
	}
	
	private function getTitle() {
		if (isset($_POST[self::$TITLE])) {
			return $_POST[self::$TITLE];
		}
	}

	private function getText() {
		if (isset($_POST[self::$TEXT])) {
			return $_POST[self::$TEXT];
		}
	}

	public function getPostData(\common\model\User $user) {
		$username = $user->username;
		$id = $user->id;
		$title = strip_tags($this->getTitle());
		$text = strip_tags($this->getText());
		$image = $this->getUploadedFile();
		return new \posts\model\PostsModel($username, $id, $title, $text, "");
	}

	public function postFailed($post, $uploadedFile) {
		if ($post->Title == "") {
			$this->message = "<p>Du måste ange en titel!</p>";
		}
		else if ($uploadedFile["type"] == "") {
			$this->message = "<p>Filens format godkändes inte</p>";
		}
	}
}