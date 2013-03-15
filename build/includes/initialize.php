<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// The site root, while on MAMP.
// /Users/mluster/Projects/lookgr.am
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'donald'.DS.'Projects'.DS.'lookgram');
// defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'/home/content/10/10084510/html/mirrorme');

// The class path.
defined('CLASS_PATH') ? null : define('CLASS_PATH', SITE_ROOT.DS.'build'.DS.'classes'.DS);

// The include path
defined('INCLUDE_PATH') ? null : define('INCLUDE_PATH', SITE_ROOT.DS.'build'.DS.'includes'.DS);


// First require the database. Then the user class can check the database. Then instantiate the session.
// This is required from index.php. So the source directory is /dev/public
require_once(CLASS_PATH . "FirePHP.class.php");
$firephp = FirePHP::getInstance(true);
require_once(CLASS_PATH . "Database.php");
require_once(CLASS_PATH . "Resize.php"); 
require_once(CLASS_PATH . "User.php");
require_once(CLASS_PATH . "Session.php");
require_once(CLASS_PATH . "Photo.php");
require_once(CLASS_PATH . "Profile.php");
require_once(CLASS_PATH . "Photofeed.php");
require_once(CLASS_PATH . "Tag.php");
require_once(CLASS_PATH . "Comment.php");
require_once(CLASS_PATH . "Photobooth.php");
require_once(CLASS_PATH . "TopicPageController.php");
$firephp->log('Initialized');

?>
