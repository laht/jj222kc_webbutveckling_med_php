<?php

namespace base\view;

include_once("common/view/Page.php");

class View {

	private $loginView;
	private $postView;
	private $registerView;

	public function __construct(\login\view\LoginView $loginView, \posts\view\PostsView $postView, \register\view\RegisterView $registerView) {
		$this->loginView = $loginView;
		$this->postView = $postView;
		$this->registerView = $registerView;
	}

	public function getLoggedOutPage() {
		$header = $this->loginView->getHTMLForm();
		$body = $this->postView->getAllPosts();
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