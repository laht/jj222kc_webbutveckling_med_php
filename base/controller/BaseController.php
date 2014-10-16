<?php

namespace base\controller;

include_once('login/controller/LoginController.php');
include_once('login/view/LoginView.php');
include_once('login/model/LoginModel.php');
include_once('posts/view/PostsView.php');
include_once('base/view/View.php');
include_once('posts/model/PostsDAL.php');
include_once('common/model/BaseDAL.php');
include_once('register/view/RegisterView.php');
include_once('register/controller/RegisterController.php');

class BaseController {
	private $loginController;
	private $registerController;
	private $registerView;
	private $view;

	public function __construct() {
		$baseDAL = new \common\model\BaseDAL();
		$loginModel = new \login\model\LoginModel($baseDAL);
		$loginView = new \login\view\LoginView($loginModel);
		$postsView = new \posts\view\PostsView($baseDAL);
		$this->registerView = new \register\view\RegisterView();
		$this->registerController = new \register\controller\RegisterController($this->registerView, $baseDAL);
		$this->loginController = new \login\controller\LoginController($loginView, $baseDAL);
		$this->view = new \base\view\View($loginView, $postsView, $this->registerView);		
	}

	public function runApp() {
		$this->loginController->runLogin();
		$this->registerController->runRegister();

		if ($this->loginController->userSession()) {
			return $this->view->getLoggedInPage();
		}
		else if ($this->registerView->userRegistrating()) {
			return $this->view->getRegisterView();
		}

		return $this->view->getLoggedOutPage();
	}
}