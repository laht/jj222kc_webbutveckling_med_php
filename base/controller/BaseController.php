<?php

namespace base\controller;

require_once('login/controller/LoginController.php');
require_once('login/view/LoginView.php');
require_once('login/model/LoginModel.php');
require_once('posts/view/PostsView.php');
require_once('posts/controller/PostsController.php');
require_once('base/view/View.php');
require_once('posts/model/PostsDAL.php');
require_once('common/model/BaseDAL.php');
require_once('register/view/RegisterView.php');
require_once('register/controller/RegisterController.php');
require_once('comments/view/CommentsView.php');
require_once('comments/controller/CommentsController.php');

class BaseController {
	private $loginController;
	private $registerController;
	private $commentsController;
	private $postsController;
	private $registerView;
	private $postsView;
	private $view;

	public function __construct() {
		$baseDAL = new \common\model\BaseDAL();
		$loginModel = new \login\model\LoginModel($baseDAL);
		$loginView = new \login\view\LoginView($loginModel);
		$commentsView = new \comments\view\CommentsView($baseDAL);
		$this->postsView = new \posts\view\PostsView($baseDAL);
		$this->postsController = new \posts\controller\PostsController($this->postsView, $baseDAL);
		$this->registerView = new \register\view\RegisterView();
		$this->registerController = new \register\controller\RegisterController($this->registerView, $baseDAL);
		$this->loginController = new \login\controller\LoginController($loginView, $baseDAL);
		$this->commentsController = new \comments\controller\CommentsController($commentsView, $baseDAL);
		$this->view = new \base\view\View($loginView, $this->postsView, $this->registerView, $commentsView);
		
	}

	public function runApp() {
		$this->loginController->runLogin();
		$this->registerController->runRegister();
		$this->commentsController->runComments();
		$this->postsController->runPosts();

		if ($this->loginController->userSession()) {
			if ($this->postsView->addingPost()) {
				return $this->view->getAddingPostPage();
			}
			if ($this->postsView->showSingle()) {
				$postId = $this->postsView->getpostId();
				return $this->view->getSingleLoggedIn($postId);
			}
			return $this->view->getLoggedInPage();
		}
		else if ($this->registerView->userRegistrating()) {
			return $this->view->getRegisterView();
		}
		else if ($this->postsView->showSingle()) {
			$postId = $this->postsView->getpostId();
			return $this->view->getSingleLoggedOut($postId);
		}

		return $this->view->getLoggedOutPage();
	}
}