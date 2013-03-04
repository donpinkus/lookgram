<?php require_once("../includes/initialize.php"); ?>
<?php
echo 'Here is the response:';
print_r($_POST);

Photo::upload_photo();
