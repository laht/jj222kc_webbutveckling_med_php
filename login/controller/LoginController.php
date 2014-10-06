<?php

namespace login\controller;

require_once('login/model/LoginModel.php');
require_once('common/model/User.php');

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
		if ($this->view->userLoggingIn()) {
			var_dump($_POST);
			try {
				$this->model->login($this->view->getUserLoginInput());	
			} catch (\Exception $e) {
				$this->view->loginFail($e->getMessage());
			}			
		}
	}
}