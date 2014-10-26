<?php

namespace base\controller;

//require the dependencies
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

//class that decides which page is presented to the user
class BaseController {

	//member variables for dependencies 
	private $loginController;
	private $registerController;
	private $commentsController;
	private $postsController;
	private $registerView;
	private $postsView;
	private $view;

	//initiate membervariables and their dependencies
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

	//decide which page should be presented to the user
	public function runApp() {
		//start login controller
		$this->loginController->runLogin();
		//start register controller
		$this->registerController->runRegister();
		//start comments controller
		$this->commentsController->runComments();
		//start posts controller
		$this->postsController->runPosts();

		//if the user is logged in
		if ($this->loginController->userSession()) {
			//show adding post view
			if ($this->postsView->addingPost()) {
				return $this->view->getAddingPostPage();
			}
			//show single logged in post view
			if ($this->postsView->showSingle()) {
				$postId = $this->postsView->getpostId();
				return $this->view->getSingleLoggedIn($postId);
			}
			//show all posts view
			return $this->view->getLoggedInPage();
		}
		//if user is registrating
		//show the registration view
		else if ($this->registerView->userRegistrating()) {
			return $this->view->getRegisterView();
		}
		//if user is logged out
		//show the logged out single view
		else if ($this->postsView->showSingle()) {
			$postId = $this->postsView->getpostId();
			return $this->view->getSingleLoggedOut($postId);
		}
		//show the all posts view
		return $this->view->getLoggedOutPage();
	}
}