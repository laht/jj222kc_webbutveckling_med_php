<?php

namespace register\controller;

require_once('register/model/RegisterModel.php');

class RegisterController {

	private $view;
	private $model;

	public function __construct(\register\view\RegisterView $view, \common\model\BaseDAL $baseDAL) {
		$this->model = new \register\model\RegisterModel($baseDAL);
		$this->view = $view;
	}

	public function runRegister() {
		if ($this->view->userWantsToRegister()) {
			try {
				$user = $this->view->getUserData();
				$this->model->register($user);
			} catch (\Exception $e) {
				$this->view->registrationFailed();
			}
		}
	}

}