<?php require_once("build/includes/initialize.php"); ?>
<?php $photobooth_photo = new Photobooth($_GET['photo_id']); ?>
<html>
<head>
</head>
<body>
	<?php require_once("build/includes/analyticstracking.php"); ?>
	<div class="photobooth-photo-page" data-photo-id="<?php echo $_GET['photo_id']; ?>">
		<div class="photobooth-photo-container">
			<?php 
				echo '<img src="../..' . $photobooth_photo->photo_path . '" />';
			?>
		</div>
		<div class="photobooth-social-container">
			<div class="photobooth-favorites-container">
				<div class="photobooth-favorites-count">
					<span class="photobooth-favorites-number"><?php echo $photobooth_photo->votes; ?>
					</span>
				</div>
				<div class="photobooth-favorites-people">
				</div>
			</div>
			<div class="photobooth-conversation-container">
				<div class="photobooth-conversation-caption photobooth-comment">
					<span class="username">
						<a href="/profile.php?user_id=<?php echo $photobooth_photo->user_id; ?>">
							<?php echo $photobooth_photo->user_handle; ?>
						</a>
					</span>
					<span class="comment-text">
						<?php echo $photobooth_photo->photo_description; ?>
					</span>
					<?php $photobooth_photo->print_tags(); ?>
					<span class="comment-time">
						<?php
							$datestamp = Comment::format_datestamp($photobooth_photo->photo_date);
							echo $datestamp;
						?>
					</span>
				</div>
				<ul id="commemtWall">
					<?php $photobooth_photo->print_comment_wall(); ?>
				</ul>
				<form class="photobooth-comment-composer">
					<textarea value="Add a comment">Add a comment</textarea>
				</form>
			</div>
		</div>
		<div class="photobooth-sidebar-container">
		</div>
	</div>
</body>
</html>