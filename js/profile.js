$(document).ready(function(){
	// Fancybox
	$('.photo a').fancybox({
		margin: 0,
		padding: 0,
		autoSize: 0,
		height: 612,
		width: 924,
		arrows: 0,
		nextEffect: 'none'
	});


	// Masonry for images
	var $container = $('.profile-feed');
	$container.imagesLoaded( function(){
	  $container.masonry({
	    itemSelector : '.photo',
	    columnWidth : 198
	  });
	});

	// Add in follow on click functionality
	$(".button.user-following").click(function(){
		var followee_id;
		var currently_following;

		// Set followee_id.
		followee_id = getParameterByName('user_id');

		// Set following value.
		if ($('.user-following').hasClass('following-true')) {
			currently_following = 1;
			console.log('Currently following is true');
		} else if ($('.user-following').hasClass('following-false')) {
			currently_following = 0;
			console.log('currently following is false');
		} else {
			console.log('There is no following status set on the button.');
		}

		// Ajax on click
		$.ajax({
			type: "POST",
			url: "/build/ajaxes/follow.php",
			data: {currently_following: currently_following, followee_id: followee_id},
			success: function(data){
				console.log('Following response: ' + data);
				// Update the following button's color and text depending on original status.
				// You can improve protection by updating based on new status?
				if (currently_following == 1) {
					$('.user-following').removeClass('following-true').addClass('following-false');
					$('.user-following').text('Follow');
				} else if (currently_following == 0) {
					$('.user-following').removeClass('following-false').addClass('following-true');
					$('.user-following').text('Following');
				}
			}
		})

	});
});