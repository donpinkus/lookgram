<?php require_once("../includes/initialize.php"); ?>

<?php 

  // The call should pass two things
  // 1. follow or unfollow
  // 2. The user_id to follow 
	if ($_POST['currently_following'] == 0) {
		Profile::follow($_POST['followee_id']);
		echo "followed";
	} else if ($_POST['currently_following'] == 1) {
		Profile::unfollow($_POST['followee_id']);
		echo "unfollowed";
	} else {
		echo "follow.php didn't have a currently_following value of 0 or 1.";
	}
	
?>