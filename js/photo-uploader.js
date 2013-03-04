$(document).ready(function(){

	var input = document.getElementById("image-input"), 
			formdata,
			description,
			taggingHTML,
			tags,
			article,
			gender,
			brand;

	// Textarea behavior
	$(".image-description textarea").focus(function(){
		if($(this).html() == 'Describe your look...') {
			$(this).html('');
		}
	});

	$(".image-description textarea").blur(function(){
		if($(this).html() == '') {
			$(this).html('Describe your look...');
		}
	});	

	// Tagging behavior
	taggingHTML = '\
					<div class="tag-form">\
						<input type="text" name="article" value="Article"></input>\
						<input type="text" name="gender" value="Gender"></input>\
						<input type="text" name="brand" value="Brand"></input>\
					</div>';

	$(".add-tag").click(function(){
		$(".add-tag").before(taggingHTML);
	});

	// Image preview
	function showUploadedItem(source) {
		var	img  = document.createElement("img");
		img.src  = source;
		$(".image-preview").html(img);
	}

	// Add event handler to 'image-input' for previewing images 
	// Create FormData.
	formdata = new FormData();

	if (input.addEventListener) {
		input.addEventListener("change", function(evt){
			var i   = 0, 
					len = this.files.length, 
					img, 
					render, 
					file;

					console.log(len);

			// Display loading message.
			// document.getElementById("response").innerHTML = "Uploading...";
			
			// Append images to our previewer.
			for ( ; i < len; i++) {
				// Set files based on input's "this". 
				file = this.files[i];
				if (!!file.type.match(/image.*/)) {
					if (window.FileReader) {
						reader = new FileReader();
						reader.onloadend = function (e) {
							showUploadedItem(e.target.result);
						};
						reader.readAsDataURL(file);
					}
					if (formdata) {
						formdata.append("images[]", file);
					}
				}
			}
		}, false);
	}


	// Submitting
	$("#post-image").click(function(){
		// Get the description text
		description = $(".image-description textarea").val();
		if (description == 'Describe your look...') {
			description = false;
		}
		formdata.append('description', description);

		// Get the tags
		tags = new Array();
		$('.tag-form').each(function(i){
			article = $(this).find('input[name="article"]').val();
			gender = $(this).find('input[name="gender"]').val();
			brand = $(this).find('input[name="brand"]').val();
			tag = {
				article : article,
				gender : gender,
				brand : brand
			};	
			tags.push(tag);
		});
		console.log(tags);
		console.log(JSON.stringify(tags))
		formdata.append('tags', JSON.stringify(tags));

		// Send to server
		$.ajax({
			url: "../../build/ajaxes/upload-photo.php",
			type: "POST",
			data: formdata,
			processData: false,
			contentType: false,
			success: function (response) {
				console.log(response);
				$.fancybox.close();
			}
		});
	});
});





