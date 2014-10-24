<?php

namespace posts\controller;

require_once("common/model/UserDAL.php");
require_once("login/model/LoginModel.php");
require_once("posts/model/PostsDAL.php");
require_once("posts/model/ImageModel.php");
require_once("posts/model/PostsModel.php");

class PostsController {
	private $view;
	private $user;
	private $loginModel;
	private $imageModel;
	private $postDAL;

	public function __construct(\posts\view\PostsView $view, \common\model\BaseDAL $baseDAL) {
		$this->view = $view;
		$this->userDAL = new \common\model\UserDAL($baseDAL);
		$this->loginModel = new \login\model\LoginModel($baseDAL);
		$this->postsDAL = new \posts\model\PostsDAL($baseDAL);		
	}

	public function runPosts() {
		if ($this->view->userPosting()) {
			//get the logged in user
			$currentUser = $this->loginModel->getSessionUser();		
			//get the user from the database
			$dbUser = $this->userDAL->findUser(new \common\model\User($currentUser, ""));
			//get post data from the client
			$post = $this->view->getPostData($dbUser);
			//get file form client
			$image = $this->view->getUploadedFile();
			//initiate image model with uploaded image
			$this->imageModel = new \posts\model\ImageModel($image);
			try {
				$ftp_server = "eu5.org";
				$ftp_conn = ftp_connect($ftp_server) or die("couldn't connect");
				$login = ftp_login($ftp_conn, "laht.eu5.org", "sonickkk123");
				$file = "images";
				ftp_chmod($ftp_conn, 0777, $file);
				ftp_close($ftp_conn);
				$post->validatePost($post);
				//validate image
				$this->imageModel->validateImage();
				//if no exceptions are thrown resize and save image
				//$this->imageModel->processImage();
				$this->imageModel->saveImage();
				//add new post to database
				$this->postsDAL->addPost($post, $this->imageModel);
				$this->view->postSuccess();
			} catch (\Exception $e) {				
				$this->view->postFailed($post, $image);
			}					
		}
	}
}