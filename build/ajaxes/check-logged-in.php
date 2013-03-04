<?php require_once("../includes/initialize.php"); ?>

<?php 

	// Checks if the user is logged in. 
	echo (isset($_SESSION['user_id']) ? 1 : 0);
	
?>