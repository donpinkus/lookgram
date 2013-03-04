<?php require_once("../includes/initialize.php"); ?>

<?php 

  // Posts a comment.
	$photo_id = $_POST['photo_id'];
	$text = $_POST['text'];
	Comment::write_comment($photo_id, $text);
	echo 'end';

?>