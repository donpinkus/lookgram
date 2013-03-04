$(document).ready(function() {	

	// Navigate gallery on click.
	$('body').delegate('.photobooth-photo-container', 'click', function(){
		$.fancybox.next();
	});

	// Stack overflows method to see bottom of scroll. 
	// TODO: Get this working.
	// var comment_box = window.getElementById('commentWall');
	// comment_box.scrollTop = comment_box.scrollHeight;

	// Pretty js on comment box.
	$('body').on('focus', '.photobooth-comment-composer textarea', function() {
		$(this).text('');
	});

	// Submit a comment.
	$('body').on('keydown','.photobooth-comment-composer textarea', function(event) {
    if (event.keyCode == 13) {
      console.log('Enter was pressed');
      var photo_id;
      var text;
      var new_comment; // HTML that gets appended to the comments in the photobooth.

      photo_id = $('.photobooth-photo-page').attr('data-photo-id');
      text = $('.photobooth-comment-composer textarea').val();
      $('.photobooth-comment-composer textarea').val('');
      console.log(photo_id);
      console.log(text);
	    $.ajax({
				type: "POST",
				data: {photo_id: photo_id, text: text},
				url: "/build/ajaxes/post-comment.php",
				success: function(data){
					console.log('finished comment!');
					console.log(data);
					// Append to comment list as newest comment
					new_comment = '<li class="photobooth-comment">  \
						<span class="username"> \
							<a href="#">You</a> \
						</span> \
						<span class="comment-text"> \
							' + text + ' \
						</span> \
						<span class="comment-time"> \
							2d \
						</span> \
 					</li> \
					';

					$('.photobooth-conversation-container > ul').append(new_comment);
				}
			});	
    }
  });
});