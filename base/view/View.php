<?php

namespace base\view;

require_once("common/view/Page.php");

class View {

	//member variables for dependencies
	private $loginView;
	private $postView;
	private $registerView;
	private $commentsView;

	//initiate member variables
	public function __construct(\login\view\LoginView $loginView, 
								\posts\view\PostsView $postView, 
								\register\view\RegisterView $registerView, 
								\comments\view\CommentsView $commentsView) {

		$this->loginView = $loginView;
		$this->postView = $postView;
		$this->registerView = $registerView;
		$this->commentsView = $commentsView;
	}

	//return the logged out view 
	//shows all posts
	public function getLoggedOutPage() {
		$header = $this->loginView->getHTMLForm();
		$body = $this->postView->getAllPosts();
		$footer = "";
		return new \common\view\Page("Bildblogg - Utloggad", $header, $body, $footer);
	}

	//return the single post view for logged out users
	//shows a single post
	public function getSingleLoggedOut($id) {
		$header = $this->loginView->getHTMLForm();
		$body = $this->postView->getSingle($id);
		$body .= $this->commentsView->getAllComments($id);
		$footer = "";
		return new \common\view\Page("Bildblogg - Utloggad", $header, $body, $footer);
	}

	//return the singled post view for logged in users
	//shows a single post
	public function getSingleLoggedIn($id) {
		$header = $this->loginView->getLoggedInHeader();
		$header .= $this->postView->getPostHeader();
		$body = $this->postView->getSingle($id);
		$body .= $this->commentsView->getAddComments();
		$body .= $this->commentsView->getAllComments($id);
		$footer = "";
		return new \common\view\Page("Bildblogg - Inloggad", $header, $body, $footer);
	}

	//return the registration view
	public function getRegisterView() {
		$header = $this->loginView->getHTMLForm();
		$body = $this->registerView->getHTMLForm();
		$footer = "";
		return new \common\view\Page("Bildblogg - registrera användare", $header, $body, $footer);
	}

	//return the logged in view
	//shows all the posts
	public function getLoggedInPage() {
		$header = $this->loginView->getLoggedInHeader();
		$header .= $this->postView->getPostHeader();
		$body = $this->postView->getAllPosts();
		$footer = "";
		return new \common\view\Page("Bildblogg - Inloggad", $header, $body, $footer);
	}

	//return the adding post view
	public function getAddingPostPage() {
		$header = $this->loginView->getLoggedInHeader();
		$header .= $this->postView->getPostHeader();
		$body = $this->postView->getAddPost();
		$footer = "";
		return new \common\view\Page("Bildblogg - Inloggad", $header, $body, $footer);
	}
}