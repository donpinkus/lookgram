<?php require_once("../includes/initialize.php"); ?>

<?php 
// Authenticate user
$log_in_sequence = User::log_in_sequence();
echo json_encode($log_in_sequence);

?>