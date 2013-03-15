// This is used for responsive design on the main div and the header. 
function get_main_div_width() {
	var width = $(window).width();
	var div_width = Math.floor(width / 240) * 240 // Round down. 
	console.log(div_width);
	return div_width;
}

// This sets the header div. 
function set_wrapper_div_width() {
	var div_width;
	div_width = get_main_div_width();
	$('.wrapper').width(div_width);
}

// This sets the main div.
function set_main_div_width() {
	var div_width;
	div_width = get_main_div_width();
	$('.main').width(div_width);
}