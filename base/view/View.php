<?php

namespace base\view;

require_once("common/view/Page.php");

class View {
	private $loginView;

	public function __construct(\login\view\LoginView $loginView) {
		$this->loginView = $loginView;
	}

	public function getLoggedOutPage() {
		$header = $this->loginView->getHTMLForm();
		$body = "";
		$footer = "";
		return new \common\view\Page("Bildblogg - Utloggad", $header, $body, $footer);
	}
}