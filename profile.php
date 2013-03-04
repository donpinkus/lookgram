<?php require_once("build/includes/initialize.php"); ?>
<html class="no-js" id="lookgram" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script src="javascripts/foundation/modernizr.foundation.js"></script>
    
    <?php require_once("build/includes/head-css.php"); ?>
    
		<?php require_once("build/includes/head-js-libs.php"); ?>

    <!-- main JS -->
    <script src="js/main.js" type="text/javascript"></script>
    <!-- profile JS -->
    <script src="js/profile.js" type="text/javascript"></script>
    
    <!-- profile page -->
    <title>Lookgr.am</title>

    <!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
		
	</head>
	<body id="profile">
		<?php require_once("build/includes/analyticstracking.php"); ?>
		<div class="page">
			<header class="top-nav">
				<div class="wrapper">
					<a href="/" class="home-button">
						<div>
							<span class="entypo">&#8962;</span>
						</div>
					</a>
					<hgroup>
						<h1 class="logo">
							<a href="/">Lookgr.am</a>
						</h1>
					</hgroup>
					<div class="account-state">
					  <?php
					    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
					      require('build/includes/header-logged-out-buttons.php');
					    } else if ($_SESSION['logged_in'] == 'true') {
					      require('build/includes/header-account-info.php');
					    }
					  ?>
					</div>
				</div>
			</header>
			<?php 
				if (isset($_GET['user_id'])) {
					$profile_id = $_GET['user_id'];
				} elseif (isset($_SESSION['user_id'])) {
					$profile_id = $_SESSION['user_id'];
				} else {
					// This should never happen since you can only get to a profile page 
					// through clicking and getting a user_id in URL, or by viewing own
					// profile.
				}
				$current_profile = new Profile($profile_id); 
				$current_profile->print_profile();
			?>
		</div>
		<!-- .page -->
		<div class="footer">
			<ul>
				<li><a href="#">YOUR ACCOUNT</a></li>
				<li><a href="#">ABOUT US</a></li>
				<li><a href="#">SUPPORT</a></li>
				<li><a href="#">BLOG</a></li>
				<li><a href="#">API</a></li>
				<li><a href="#">JOBS</a></li>
				<li><a href="#">PRIVACY</a></li>
				<li><a href="#">TERMS</a></li>
			</ul>
			<span>COPYRIGHT 2012 TRENDI</span> 
		</div>
	</body>
</html>