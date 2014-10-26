<?php

namespace register\controller;

require_once('register/model/RegisterModel.php');

class RegisterController {

	//member variables for dependencies
	private $view;
	private $model;

	//initiate the member variables
	public function __construct(\register\view\RegisterView $view, \common\model\BaseDAL $baseDAL) {
		$this->model = new \register\model\RegisterModel($baseDAL);
		$this->view = $view;
	}

	//if the user wants to register
	public function runRegister() {
		//the user wants to register
		if ($this->view->userWantsToRegister()) {
			try {				
				$user = $this->view->getUserData();
				//add the user to the database
				$this->model->register($user);
				$this->view->registerSuccess();
			} catch (\Exception $e) {
				$this->view->registrationFailed();
			}
		}
	}

}