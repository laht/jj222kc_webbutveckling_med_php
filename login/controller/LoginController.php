<?php

namespace login\controller;

include_once('login/model/LoginModel.php');
include_once('common/model/User.php');

class LoginController {
	private $view;
	private $loginController;
	private $model;

	public function __construct(\login\view\LoginView $view, \common\model\BaseDAL $baseDAL) {
		$this->view = $view;
		$this->model = new \login\model\LoginModel($baseDAL);
	}

	public function userSession() {
		if ($this->model->isSessionSet()) {
			if ($this->model->validateSession()) {
				return true;
			}
		}
		return false;
	}

	//User wants to login with either input or cookies
	public function runLogin() {
		if ($this->view->userLoggingOut()) {
			$this->view->logout();
			$this->model->logout();
		}
		else if ($this->view->userCookies()) {
			try {
				$user = $this->view->getUserLoginInput();
				$this->model->login($user);
				$this->view->loginSuccess();
			} catch (\Exception $e) {
				$this->view->loginFail();
			}
		}
		if ($this->view->userLoggingIn()) {
			try {
				$user = $this->view->getUserLoginInput();
				$this->model->login($user);
				$this->view->loginSuccess();
			} catch (\Exception $e) {
				$this->view->loginFail();
			}			
		}
	}
}