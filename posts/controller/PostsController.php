<?php

namespace posts\controller;

require_once("common/model/UserDAL.php");
require_once("login/model/LoginModel.php");
require_once("posts/model/PostsDAL.php");
require_once("posts/model/ImageModel.php");
require_once("posts/model/PostsModel.php");

class PostsController {

	//member variables for dependencies
	private $view;
	private $user;
	private $loginModel;
	private $imageModel;
	private $postDAL;

	//initiate member variables
	public function __construct(\posts\view\PostsView $view, \common\model\BaseDAL $baseDAL) {
		$this->view = $view;
		$this->userDAL = new \common\model\UserDAL($baseDAL);
		$this->loginModel = new \login\model\LoginModel($baseDAL);
		$this->postsDAL = new \posts\model\PostsDAL($baseDAL);		
	}

	//if the user wants to make a new post
	public function runPosts() {
		if ($this->view->userPosting()) {
			//gather the posts information
			$currentUser = $this->loginModel->getSessionUser();		
			$dbUser = $this->userDAL->findUser(new \common\model\User($currentUser, ""));
			$post = $this->view->getPostData($dbUser);
			$image = $this->view->getUploadedFile();
			$this->imageModel = new \posts\model\ImageModel($image);
			try {
				//then try to post it to the database
				$post->validatePost($post);
				$this->imageModel->validateImage();
				$this->imageModel->saveImage();
				$this->postsDAL->addPost($post, $this->imageModel);
				$this->view->postSuccess();
			} catch (\Exception $e) {				
				$this->view->postFailed($post, $image);
			}					
		}
	}
}