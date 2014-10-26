<?php

namespace comments\view;

require_once("comments/model/CommentsDAL.php");

class CommentsView {

	//add some static variables for html and global variables
	private static $COMMENTING = "comment";
	private static $TEXT = 'CommentView::Text';
	private static $SUBMIT = "AddComment";
	private static $UPDATE = "UpdateComment";
	private static $DELETE = "DeleteComment";
	private static $COMMENTID = "CommentId";

	//member variables for dependencies
	private $commentDAL;
	private $userDAL;
	private $loginModel;

	//message for the user
	private $addMessage;
	private $updateMessage;

	//initiate member variables
	public function __construct(\common\model\baseDAL $baseDAL) {
		$this->commentDAL = new \comments\model\CommentsDAL($baseDAL);
		$this->userDAL = new \common\model\UserDAL($baseDAL);
		$this->loginModel = new \login\model\LoginModel($baseDAL);
	}

	//fetch the users posted comment
	public function getUsersComment(\common\model\User $user) {
		$userId = $user->id;
		$text = strip_tags($this->getCommentText());
		$commentId = $this->getCommentId();
		return new \comments\model\CommentsModel($text, $userId, "", $commentId);
	}

	//return the comments id 
	private function getCommentId() {
		if (isset($_POST[self::$COMMENTID])) {
			return $_POST[self::$COMMENTID];
		}
	}
	
	//return the comments text
	private function getCommentText() {
		if (isset($_POST[self::$TEXT])) {
			return $_POST[self::$TEXT];
		}
	}

	//return the html for the adding comment form
	public function getAddComments() {
		$html = 
		"<div id='addCommentForm'>
			<form action='' method='post' enctype='multipart/form-data'>				
				<fieldset>
					<p>$this->addMessage</p>
					<textarea maxlength='255' class='PostText' 
					 placeholder='Skriv en kommentar här' rows='4' cols='17' name='".self::$TEXT."'></textarea>
					<input id='SubmitID' type='submit' value='Skicka' name='".self::$SUBMIT."' /> 
				</fieldset>
			</form>
		</div>
		<div class='clearfix'></div>";
		return $html;
	}

	public function commentFailed() {
		if ($this->userCommenting()) {
			$this->addMessage = "Du måste ange en kommentar!";	
		}
		else if ($this->userUpdatingComment()) {
			$this->updateMessage = "Du måste ange en kommentar!";		
		}
		else if ($this->userDeletingComment()) {
			$this->updateMessage = "Något oväntat hände!";
		}
	}

	//return html for all comments for the selected post
	public function getAllComments($postId) {
		$comments = $this->commentDAL->getAllComments($postId);
		$html = "<div id='comments'>";		
		$currentUser = $this->userDAL->findUser(new \common\model\User($this->loginModel->getSessionUser(), ""));
		foreach ($comments as $comment) {
			$html .= "<div class='comment'>";
			$html .= "<div class='commentData'>";
			$user =  $this->userDAL->findUserById($comment->commentOwner);
			$html .= "<h3>By $user->username</h3>";
			$html .= "<p class='date'>$comment->date</p>";
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

	//return the html for the update comment form
	private function getUpdateComment($commentId) {
		$html = 
		"<div class='updatePostForm'>
			<form action='' method='post' enctype='multipart/form-data'>				
				<fieldset>
					<p>$this->updateMessage</p>					
					<textarea maxlength='255' class='PostText' 
					 placeholder='Uppdatera kommentar' rows='4' cols='17' name='".self::$TEXT."' ></textarea>
					<input id='SubmitID' type='submit' value='Update' name='".self::$UPDATE."' /> 
					<input type='hidden' name='".self::$COMMENTID."' value='$commentId' />
				</fieldset>
			</form>
		</div>";
		return $html;
	}

	//return the html for the delete comment form
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

	//return if user is commenting
	public function userCommenting() {
		return isset($_POST[self::$SUBMIT]);
	}

	//return if user is updating comment
	public function userUpdatingComment() {
		return isset($_POST[self::$UPDATE]);
	}

	//return if user is deleting comment
	public function userDeletingComment() {
		return isset($_POST[self::$DELETE]);
	}
}