<?php

namespace comments\controller;

require_once('common/model/UserDAL.php');
require_once('comments/model/CommentsDAL.php');
require_once('comments/model/CommentsModel.php');
require_once("login/model/LoginModel.php");


class CommentsController {

	//member variables for dependencies
	private $view;
	private $loginModel;
	private $commentDAL;
	private $userDAL;

	//initiate member variables
	public function __construct(\comments\view\CommentsView $view, \common\model\BaseDAL $baseDAL) {
		$this->view = $view;
		$this->userDAL = new \common\model\UserDAL($baseDAL);
		$this->loginModel = new \login\model\LoginModel($baseDAL);
		$this->commentDAL = new \comments\model\CommentsDAL($baseDAL);
	}

	//What does the user want to do?
	public function runComments() {
		//add a comment
		if ($this->view->userCommenting()) {
			$this->addComment();
		}
		//update a comment
		else if ($this->view->userUpdatingComment()) {
			$this->updateComment();
		}
		//delete a comment
		else if ($this->view->userDeletingComment()) {
			$this->deleteComment();
		}
	}

	//add the users comment to the database
	private function addComment() {
		$currentUser = new \common\model\User($this->loginModel->getSessionUser(), "");
		$dbUser = $this->userDAL->findUser($currentUser);
		$comment = $this->view->getUsersComment($dbUser);

		try {
			$this->commentDAL->addComment($comment);
		} catch (\Exception $e) {
			$this->view->commentFailed();
		}
	}

	//update the users selected comment 
	private function updateComment() {
		$currentUser = $this->loginModel->getSessionUser();
		$dbUser = $this->userDAL->findUser(new \common\model\User($currentUser, ""));
		$comment = $this->view->getUsersComment($dbUser);		

		try {
			$this->commentDAL->updateComment($comment);	
		} catch (\Exception $e) {
			$this->view->commentFailed();
		}
		
	}

	//delete the users selected comment
	private function deleteComment() {
		$currentUser = $this->loginModel->getSessionUser();
		$dbUser = $this->userDAL->findUser(new \common\model\User($currentUser, ""));
		$comment = $this->view->getUsersComment($dbUser);	
		try {
			$this->commentDAL->deleteComment($comment);	
		} catch (\Exception $e) {
			$this->view->commentFailed();
		}
		
	}
}