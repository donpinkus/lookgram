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
    <!-- topic-page JS -->
    <script src="js/topic-page.js" type="text/javascript"></script>
    <!-- photobooth JS -->
    <script src="js/photobooth.js" type="text/javascript"></script>
    
    <!-- topic page -->
    <title>Lookgr.am Topic</title>

    <!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

	</head>
	<body id="topic">
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
			<div class="main">
					<?php 
						// Topic page controller prints out the topic page.
					  // Uses $_GET array to determine topic.
					  // Takes gender, article, and brand values.
						$topic_page = new TopicPageController()
					?>
			</div>
		</div>
		<!-- .page -->
		<!-- SASS -->
		<!-- Included JS Files (Uncompressed) -->
		<!-- removed jquery specific to foundation since it broke my js -->		
		
		<script src="javascripts/foundation/jquery.cookie.js"></script>
		
		<script src="javascripts/foundation/jquery.event.move.js"></script>
		
		<script src="javascripts/foundation/jquery.event.swipe.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.accordion.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.alerts.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.buttons.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.clearing.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.forms.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.joyride.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.magellan.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.mediaQueryToggle.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.navigation.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.orbit.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.reveal.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.tabs.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.tooltips.js"></script>
		
		<script src="javascripts/foundation/jquery.foundation.topbar.js"></script>
		
		<script src="javascripts/foundation/jquery.placeholder.js"></script>

	  <!-- Application Javascript, safe to override -->
	  <script src="javascripts/foundation/app.js"></script>
	</body>
</html>