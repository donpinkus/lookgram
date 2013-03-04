<?php require_once("../includes/initialize.php"); ?>

<?php 

	if ($_POST['undo_vote'] == 1) {
		Photo::undo_vote($_POST['photo_id']);
	} else {
		Photo::undo_vote($_POST['photo_id']);
		Photo::vote($_POST['photo_id'], $_POST['vote']);
	}
	
	// This new score is received in the Ajax callback of voting.
	// The callback uses the $new_score to update the front-end. 
	$new_score = Photo::get_votes($_POST['photo_id']);
	echo $new_score;
	
?>