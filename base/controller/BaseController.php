<?php

namespace base\controller;

require_once('login/controller/LoginController.php');
require_once('login/view/LoginView.php');
require_once('base/view/View.php');

class BaseController {
	private $loginController;
	private $view;

	public function __construct() {		
		$loginView = new \login\view\LoginView();
		$this->loginController = new \login\controller\LoginController($loginView);
		$this->view = new \base\view\View($loginView);
	}

	public function runApp() {
		$this->loginController->runLogin();		
		return $this->view->getLoggedOutPage();
	}
}