<?php

namespace base\view;

require_once("common/view/Page.php");

class View {

	private $loginView;
	private $postView;
	private $registerView;
	private $commentsView;

	public function __construct(\login\view\LoginView $loginView, 
								\posts\view\PostsView $postView, 
								\register\view\RegisterView $registerView, 
								\comments\view\CommentsView $commentsView) {

		$this->loginView = $loginView;
		$this->postView = $postView;
		$this->registerView = $registerView;
		$this->commentsView = $commentsView;
	}

	public function getLoggedOutPage() {
		$header = $this->loginView->getHTMLForm();
		$body = $this->postView->getAllPosts();
		$footer = "";
		return new \common\view\Page("Bildblogg - Utloggad", $header, $body, $footer);
	}

	public function getSingleLoggedOut($id) {
		$header = $this->loginView->getHTMLForm();
		$body = $this->postView->getSingle($id);
		$footer = "";
		return new \common\view\Page("Bildblogg - Utloggad", $header, $body, $footer);
	}

	public function getSingleLoggedIn($id) {
		$header = $this->loginView->getLoggedInHeader();
		$body = $this->postView->getSingle($id);
		$body .= $this->commentsView->getAddComments();
		$body .= $this->commentsView->getAllComments($id);
		$footer = "";
		return new \common\view\Page("Bildblogg - Utloggad", $header, $body, $footer);
	}

	public function getRegisterView() {
		$header = "";
		$body = $this->registerView->getHTMLForm();
		$footer = "";
		return new \common\view\Page("Bildblogg - registrera användare", $header, $body, $footer);
	}

	public function getLoggedInPage() {
		$header = $this->loginView->getLoggedInHeader();
		$body = $this->postView->getAllPosts();
		$footer = "";
		return new \common\view\Page("Bildblogg - Inloggad", $header, $body, $footer);
	}
}