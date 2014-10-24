<?php

namespace comments\controller;

require_once('common/model/UserDAL.php');
require_once('comments/model/CommentsDAL.php');
require_once('comments/model/CommentsModel.php');
require_once("login/model/LoginModel.php");


class CommentsController {

	// \comments\view\CommentsView
	private $view;
	// \login\model\LoginModel
	private $loginModel;
	// \comments\model\CommentsDAL
	private $commentDAL;
	// \common\model\UserDAL
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

	//
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

	private function updateComment() {
		$currentUser = $this->loginModel->getSessionUser();
		$dbUser = $this->userDAL->findUser(new \common\model\User($currentUser, ""));
		$comment = $this->view->getUsersComment($dbUser);		

		try {
			$this->commentDAL->updateComment($comment);
		} catch (\Exception $e) {
			//something unexpected happened
		}	
	}

	private function deleteComment() {
		$currentUser = $this->loginModel->getSessionUser();
		$dbUser = $this->userDAL->findUser(new \common\model\User($currentUser, ""));
		$comment = $this->view->getUsersComment($dbUser);	
					
		try {
			$this->commentDAL->deleteComment($comment);
		} catch (\Exception $e) {
			//something unexpected happened
		}	
	}
}