<?php require_once("build/includes/initialize.php"); ?>

<div class="upload-photo-page">
	<div class="lightbox-header">
		<h1>Upload a Look</h1>
	</div>
	<div class="lightbox-content">
		<div class="upload-button-container">
			<input type="file" id="image-input" name="images[]"></input>
		</div>
		<div class="upload-meta-container">
			<div class="image-preview">
			</div>
			<div class="right-column">
				<div class="image-description">
					<textarea rows="2">Describe your look...</textarea>
				</div>
				<div class="image-tagger">
					<div class="tag-form">
						<input type="text" name="article" value="Article"></input>
						<input type="text" name="gender" value="Gender"></input>
						<input type="text" name="brand" value="Brand"></input>
					</div>
					<button class="add-tag blue-button">
						Add a tag
					</button>
				</div>
				<button class="image-post blue-button" id="post-image">
					Post
				</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="../js/photo-uploader.js"></script>