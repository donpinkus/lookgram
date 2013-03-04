<?php require_once("initialize.php"); ?>

	<ul class="actions">
		<li class="link-signin">
			<a href="photo-upload.php" class="photo-upload-fancybox fancybox fancybox.ajax">
				<span class="add-prompt">&#128247;</span><strong>Add</strong>
			</a>
		</li>
		<li id="link_profile" class="link-signin">
			<a href="#">
				<i>
				</i>
				<strong><?php echo $_SESSION['user_handle']; ?></strong>
			</a>
			<div class="dropdown hidden">
				<i></i>
				<ul>
					<li>
						<a href="/profile.php">View Profile</a>
					</li>
					<li>
						<a href="/edit-profile.php">Edit Profile</a>
					</li>
					<li>
						<a id="log-out" href="#">Log Out</a>
					</li>
				</ul>
			</div>
		</li>
	</ul>