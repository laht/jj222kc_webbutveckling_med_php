<?php

namespace comments\view;

require_once("comments/model/CommentsDAL.php");

class CommentsView {

	//add some static variables for such and such
	private static $COMMENTING = "comment";
	private static $TEXT = 'CommentView::Text';
	private static $SUBMIT = "AddComment";
	private static $UPDATE = "UpdateComment";
	private static $DELETE = "DeleteComment";
	private static $COMMENTID = "CommentId";

	private $commentDAL;
	private $userDAL;
	private $loginModel;

	private $message;

	public function __construct(\common\model\baseDAL $baseDAL) {
		$this->commentDAL = new \comments\model\CommentsDAL($baseDAL);
		$this->userDAL = new \common\model\UserDAL($baseDAL);
		$this->loginModel = new \login\model\LoginModel($baseDAL);
	}

	public function getUsersComment(\common\model\User $user) {
		$userId = $user->id;
		$text = strip_tags($this->getCommentText());
		//$commentId = $this->getCommentId();
		return new \comments\model\CommentsModel($text, $userId, "", $commentId='');
	}
	
	private function getCommentText() {
		if (isset($_POST[self::$TEXT])) {
			return $_POST[self::$TEXT];
		}
	}

	public function getAddComments() {
		$html = 
		"<div id='addPostForm'>
			<form action='' method='post' enctype='multipart/form-data'>				
				<fieldset>
					<p>$this->message</p>
					<textarea maxlength='255' class='PostText' 
					 placeholder='Skriv en kommentar här' rows='4' cols='17' name='".self::$TEXT."'></textarea>
					<input id='SubmitID' type='submit' value='Send' name='".self::$SUBMIT."' /> 
				</fieldset>
			</form>
		</div>";
		return $html;
	}

	public function getAllComments($postId) {
		$comments = $this->commentDAL->getAllComments($postId);
		$html = "<div id='comments'>";		
		$currentUser = $this->userDAL->findUser(new \common\model\User($this->loginModel->getSessionUser(), ""));
		foreach ($comments as $comment) {
			$html .= "<div class='comment'>";
			$html .= "<div class='commentData'>";
			$user =  $this->userDAL->findUserById($comment->commentOwner);
			$html .= "<h3>By $user->username</h3>";
			$html .= "<p>$comment->date</p>";
			$html .= "<p>$comment->comment</p>";	
			$html .= "</div>";		
			if ($currentUser->id == $comment->commentOwner) {
				$html .= $this->getUpdateComment($comment->commentId);
				$html .= $this->getDeleteComment($comment->commentId);
			}
			$html .= "<div class='clearfix'></div>";
			$html .= "</div>";
		}
		$html .= "</div>";

		return $html; 
	}

	private function getUpdateComment($commentId) {
		$html = 
		"<div class='updatePostForm'>
			<form action='' method='post' enctype='multipart/form-data'>				
				<fieldset>		
					<legend>Update Comment</legend>
					<p>$this->message</p>					
					<textarea maxlength='255' class='PostText' 
					 placeholder='Post text' rows='4' cols='17' name='".self::$TEXT."' /></textarea>
					<input id='SubmitID' type='submit' value='Update' name='".self::$UPDATE."' /> 
					<input type='hidden' name='".self::$COMMENTID."' value='$commentId' />
				</fieldset>
			</form>
		</div>";
		return $html;
	}

	private function getDeleteComment($commentId) {
		$html = 
		"<div class='deletePostForm'>
			<form action='' method='post' enctype='multipart/form-data'>				
				<fieldset>		
					<input id='SubmitID' type='submit' value='Delete' name='".self::$DELETE."' /> 
					<input type='hidden' name='".self::$COMMENTID."' value='$commentId' />
				</fieldset>
			</form>
		</div>";
		return $html;
	}

	public function userCommenting() {
		return isset($_POST[self::$SUBMIT]);
	}

	public function userUpdatingComment() {
		return isset($_POST[self::$UPDATE]);
	}

	public function userDeletingComment() {
		return isset($_POST[self::$DELETE]);
	}
}