$(document).ready(function(){

	var $container = $('.main');
	$container.imagesLoaded( function(){
	  $container.masonry({
	    itemSelector : '.photo-column',
	    columnWidth : 238
	  });
	});

	// Window resize
	// Set size on page load.
	set_wrapper_div_width();
	set_main_div_width();

	// Set size when window is resized.
	$(window).resize(function(){
		set_wrapper_div_width();
		set_main_div_width();
	});

	// Fancybox on photos.
	$('.vote-photo-element a').fancybox({
		margin: 0,
		padding: 0,
		autoSize: 0,
		height: 612,
		width: 924,
		arrows: 0,
		nextEffect: 'none'
	});
});