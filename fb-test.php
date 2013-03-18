<?php require_once("build/includes/initialize.php"); ?>

<?php

	$app_id = "217282335081747";
	$app_secret = "b73279947c2f41c0911045a1564e3fd0";
	$my_url = "http://www.lookgr.am";

	$code = $_REQUEST["code"];

	if(empty($code)) {
		// CSRF protection
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); 
    
    // The dialog URL
    $dialog_url = "https://www.facebook.com/dialog/oauth?"
      . "client_id="     . $app_id 
      . "&redirect_uri=" . urlencode($my_url) 
      . "&state="        . $_SESSION['state']
      . "&scope="        . "user_birthday, read_stream";

    // The request
    header("Location: " . $dialog_url);
	}

	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
		// state variables matches
		$token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id="      . $app_id 
       . "&redirect_uri="  . urlencode($my_url)
       . "&client_secret=" . $app_secret 
       . "&code="          . $code;

		$response = file_get_contents($token_url);
		$params = null;
		parse_str($response, $params);
		$_SESSION['access_token'] = $params['access_token'];

		// test
		$graph_url = "https://graph.facebook.com/me?access_token=" 
		 . $params['access_token'];

		$user = json_decode(file_get_contents($graph_url));
		echo("Hello " . $user->name);
     
	} else {
		echo("The state does not match. You may be a victim of CSRF.");
	}

?>

<h1>Test</h1>