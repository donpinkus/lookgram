<?php require_once("../includes/initialize.php"); ?>

<?php 
// Enter new records.
User::register_user($_POST['username'], $_POST['password']);

// Authenticate the user to be consistent with log in process
User::authenticate($_POST['username'], $_POST['password']);

// TODO: Return content to be loaded into account button space.

?>