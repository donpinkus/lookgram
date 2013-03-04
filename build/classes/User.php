<?php

class User {

  public $user_id;
  public $user_handle;
  public $user_firstname;
  public $user_lastname;

  function __construct ($user_id) {
    $this->set_user_data($user_id);
  }

  public function set_user_data ($user_id) {
    $user_info = User::find_user_info_by_id($user_id);
    $this->user_id = $user_id;
    $this->user_handle = $user_info['handle'];
    $this->first_name = $user_info['first_name'];
    $this->last_name = $user_info['last_name'];
  }

  public static function find_user_info ($handle) {
    $sql = "
      SELECT user_id, handle, first_name, last_name
      FROM user_id
      WHERE handle = '{$handle}';";
    $dbo = mysql_query($sql);
    $user_info = mysql_fetch_array($dbo);
    return $user_info;
  }

  public static function find_user_info_by_id ($user_id) {
    $sql = "
      SELECT user_id, handle, first_name, last_name
      FROM user_id
      WHERE user_id = '{$user_id}';";
    $dbo = mysql_query($sql);
    $user_info = mysql_fetch_array($dbo);
    return $user_info;   
  }

  public static function get_user_handle ($user_id) {
    $user_info = self::find_user_info_by_id($user_id);
    $user_handle = $user_info['handle'];
    return $user_handle;
  }

  // Registration
  public static function register_user($user_handle, $password) {
    // Create record in user_auth
    $sql = "INSERT INTO user_auth (user_handle, password) VALUES ('{$user_handle}', '{$password}'); ";
    $do_it_bitch = mysql_query($sql);
    // Create record in user_id
    $sql = "INSERT INTO user_id (handle) VALUES ('{$user_handle}'); ";
    $do_it_bitch = mysql_query($sql);
    // Create directory for photo uploads.
    $user_info = self::find_user_info($user_handle);
    $user_id = $user_info['user_id'];
    mkdir("../../photos/" . $user_id, 0777);
  }


  // Log in a user. 
  public static function log_in_sequence() {
    if (User::authenticate($_POST['username'], $_POST['password']) == true) {
      return 1;
    } else if (User::find_user_info($_POST['username']) != false) {
      // Incorrect password.
      return 2;
    } else if (User::find_user_info($_POST['username']) == false) {
      // User does not exist.
      return 3;
    } else {
      // Your code sucks.
      return 4;
    }
  }

  // Authenticate a user by their username and password. 
  // Creates $current_user. 
  // Handles $session data. 
  public static function authenticate($handle, $password) {
    global $session;
    
    $sql = "SELECT * FROM user_auth WHERE user_handle='{$handle}' AND password='{$password}' ";
    $user_dbo = mysql_query($sql);
    $user_row = mysql_fetch_array($user_dbo);
    if (isset($user_row['user_id'])) {
      $current_user = new User($user_row['user_id']);
      $session->log_in();
      $session->set_data($current_user->user_handle, $current_user->user_id);
      return true;
    } else {
      return false;
    }
  }
}

?>
