<?php

namespace posts\view;

include_once("posts/model/postsDAL.php");

class PostsView {

	//declare some static variables for HTML and global variables
	private static $TITLE = 'PostView::Title';
	private static $TEXT = 'PostView::Text';
	private static $SUBMIT = 'addpost';
	private static $POSTID = 'postid';
	private static $FILEUPLOAD = 'fileInput';
	private static $POSTSPERPAGE = 12;
	private static $PAGENR = "page";

	//member variables for dependencies
	private $postDAL;
	private $message;
	private $numberOfPages;

	//initiate the postDAL member variable
	public function __construct(\common\model\BaseDAL $baseDAL) {
		$this->postsDAL = new \posts\model\PostsDAL($baseDAL);
	}

	//return the html for the add post button
	public function getPostHeader() {
		$html = "<div id='uploadBtn'>
					<a href='?addpost'>Ladda upp bild</a>
				</div>";
		return $html;
	}

	//return if the user wants to add a post
	public function addingPost() {
		return isset($_GET[self::$SUBMIT]);
	}

	//return the number of pages that will be needed for pagination
	private function getNumberOfPages() {
		$total = $this->postsDAL->getNumberOfRows();
		$pageNumber = ceil($total/self::$POSTSPERPAGE);
		return $pageNumber;
	}

	//fetch the page number from the querystring
	//if it is not set the page numger is 0 so return 0
	private function getPageNr() {
		if (isset($_GET[self::$PAGENR])) {
			return $_GET[self::$PAGENR];
		}
		else {
			return 0;
		}
	}

	//get the numbers that represents the range of posts will be shown
	private function getPostsRange() {
		$pageNr = $this->getPageNr();		
		$start = $pageNr*self::$POSTSPERPAGE;
		$end = $start+self::$POSTSPERPAGE;

		return array('start' => $start, 'end' => $end);
	}

	//if the post was successful go to the front page to present the added post
	public function postSuccess() {
		header("Location:http://www.".getenv('HTTP_HOST'));
		die();
	}

	//assemble and return the html for all posts that will be shown to the user
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

	//return the html for the add post form
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

	//return html for the single post view
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

	//return if the user wants to view a single post
	public function showSingle() {
		if (isset($_GET[self::$POSTID]) && !empty($_GET[self::$POSTID])) {
			return true;
		}
		return false;
	}

	//return the post id from the query string
	public function getPostId() {
		if (isset($_GET[self::$POSTID])) {
			return $_GET[self::$POSTID];
		}
	}

	//return if the user wants to submit their post
	public function userPosting() {
		return isset($_POST[self::$SUBMIT]);
	}

	//return the file the user uploaded 
	public function getUploadedFile() {
		if (isset($_FILES[self::$FILEUPLOAD])) {
			return $_FILES[self::$FILEUPLOAD];
		}
	}
	
	//return the title from the submited post
	private function getTitle() {
		if (isset($_POST[self::$TITLE])) {
			return $_POST[self::$TITLE];
		}
	}

	//return the text from the submited post
	private function getText() {
		if (isset($_POST[self::$TEXT])) {
			return $_POST[self::$TEXT];
		}
	}

	//assemble the submited post and return it
	public function getPostData(\common\model\User $user) {
		$username = $user->username;
		$id = $user->id;
		$title = strip_tags($this->getTitle());
		$text = strip_tags($this->getText());
		$image = $this->getUploadedFile();
		return new \posts\model\PostsModel($username, $id, $title, $text, "");
	}

	//if the post failed show the appropriate message to the user
	public function postFailed($post, $uploadedFile) {
		if ($post->Title == "") {
			$this->message = "<p>Du måste ange en titel!</p>";
		}
		else if ($uploadedFile["type"] == "") {
			$this->message = "<p>Filens format godkändes inte</p>";
		}
	}
}