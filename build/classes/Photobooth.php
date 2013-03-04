<?php

class Photobooth extends Photo {
	
	public $comments;

	function __construct($photo_id) {
		parent::__construct($photo_id);
		$this->set_comments();
	}

	public function set_comments() {
		$this->comments = Comment::get_comments_by_photo_id($this->photo_id);
	}

	public function print_comment_wall() {
		global $firephp;
		$comments = Comment::get_comments_by_photo_id($this->photo_id);
		$firephp->log($comments);
		foreach ($comments as $comment) {
			$commenter = new User($comment['poster_id']);
			// Create nice date stamp.
			$comment_timestamp = Comment::format_datestamp($comment['timestamp']);
			$comment_html = '
				<li class="photobooth-comment">
					<span class="username">
						<a href="/profile.php?user_id=' . $commenter->user_id . '">' . $commenter->user_handle . '</a>
					</span>
					<span class="comment-text">
						' . $comment['comment_text'] . '
					</span>
					<span class="comment-time">
						' . $comment_timestamp . '
					</span>
				</li>';
			$firephp->log($comment);
			$firephp->log($comment_html);
			echo $comment_html;
		}; 
	}

}

?>