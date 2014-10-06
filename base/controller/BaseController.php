<?php

namespace base\controller;

require_once('login/controller/LoginController.php');
require_once('login/view/LoginView.php');
require_once('base/view/View.php');
require_once("common/model/BaseDAL.php");

class BaseController {
	private $loginController;
	private $view;

	public function __construct() {
		$baseDAL = new \common\model\BaseDAL();
		$loginView = new \login\view\LoginView();
		$this->loginController = new \login\controller\LoginController($loginView, $baseDAL);
		$this->view = new \base\view\View($loginView);		
	}

	public function runApp() {
		$this->loginController->runLogin();

		if ($this->loginController->userSession()) {
			return $this->view->getLoggedInPage();
		}

		return $this->view->getLoggedOutPage();
	}
}