<?php require_once("../includes/initialize.php"); ?>

<?php 
// Logout user
global $firephp;
session_destroy();
$firephp->log('session destroyed?');
?>