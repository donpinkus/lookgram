<?php

class Session {
	
	function __construct() {
		session_start();
	}
	
	public function set_data($user_handle, $user_id){
		$_SESSION['user_handle'] = $user_handle;
		$_SESSION['user_id'] = $user_id;
	}
	
	// Sets the login state.
	public function log_in() {
		$_SESSION['logged_in'] = true;
	}

	// Log-out the user.
	public function log_out() {
		$_SESSION['logged_in'] = false;
	}
	
	// Gets log-in state (boolean).
	public function get_logged_in() {
		return $this->logged_in;
	}	
	
	// Gets the session data.
	public function get_session_data() {
		//$arr = array('userID' => $_SESSION['userID'], 'userHandle' => $_SESSION['userHandle'], 'userFirstName' => $_SESSION['userFirstName'], 'userLastName' => $_SESSION['userLastName'], 'userCity' => $_SESSION['userCity'], 'userState' => $_SESSION['userState'], 'userCountry' => $_SESSION['userCountry'], 'userRace' => $_SESSION['userRace'], 'userLeague' => $_SESSION['userLeague']);
		
		$arr = json_encode($_SESSION);
		return $arr;
	}
}

// When this file is required, session_start() is called in the __construct.
$session = new Session();


?>



