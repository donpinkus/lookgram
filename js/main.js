// General functions

function getParameterByName(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function handleVoteClicks() {
	
}

// Objects
function currentUser() {

}


// Event bindings
$(document).ready(function() {	

	// Account dropdown
	$("body").on("click", "#link_profile", function(){
		$(".dropdown").toggleClass("hidden");
	});

	// Log out
	$("body").on("click", "#log-out", function(){
		$.ajax({
			type: "POST",
			url: "../../build/ajaxes/logout-user.php",
			success: function(){
				// Remove logged in state.
				$(".account-state .actions").remove();
				// Replace with buttons.
				$.get('../../build/includes/header-logged-out-buttons.php', function(data){
					$(".account-state").append(data);
				});
			}
		})
	});

	// Log in / sign up fancybox functions
	$('.account.fancybox').fancybox({
		margin: 0,
		padding: 0,
		autoSize: 1,
		arrows: 0
	});

	$('.photo-upload-fancybox').fancybox({
		margin: 0,
		padding: 0,
		autoSize: 1,
		arrows: 0
	});


	$("body").on("focus", ".loginItem input", function(){
		if ($(this).val() == "Username" || $(this).val() == "Password") {
			$(this).val("");
		}
	});

	$("body").on("blur", ".loginItem input[name='username']", function(){
		if ($(this).val() == "") {
			$(this).val("Username");
		}
		// Makes user input text darker than prompts.
		if ($(this).val() != "" && $(this).val() != "Username" && $(this).val() != "Password") {
			$(this).addClass("filledOut");
		}
	});

	$("body").on("blur", ".loginItem input[name='password']", function(){
		if ($(this).val() == "") {
			$(this).val("Password");
		}
		// Makes user input text darker than prompts.
		if ($(this).val() != "" && $(this).val() != "Username" && $(this).val() != "Password") {
			$(this).addClass("filledOut");
		}
	});

	// Sign up submit
	$("body").on("click", "#signUp .loginSubmit button", function(){
		// Get username and password
		var username = $(".loginItem input[name='username']").val();
		var password = $(".loginItem input[name='password']").val();
		console.log(username + " " + password);
		
		// Send to server
		$.ajax({
			type: "POST",
			data: {username: username, password: password},
			url: "../../build/ajaxes/register-new-user.php",
			success: function(data){
				$.fancybox.close();

				// Remove buttons.
				$(".account-state .actions").remove();

				// Replace with logged in state.
				$.get('../../build/includes/header-account-info.php', function(data){
					$('.account-state').append(data);
				});
			}
		});
	});

	// Log in submit
	$("body").on("click", "#logIn .loginSubmit button", function(){
		// Get username and password
		var username = $(".loginItem input[name='username']").val();
		var password = $(".loginItem input[name='password']").val();
		console.log(username + " " + password);
		
		// Send to server
		$.ajax({
			type: "POST",
			data: {username: username, password: password},
			url: "../../build/ajaxes/login-user.php",
			success: function(data){
				if (data == 1) {
					// Authentication succesful.
					$.fancybox.close();
					// Remove buttons.
					$(".account-state .actions").remove();
					// Replace with logged in state.
					$.get('../../build/includes/header-account-info.php', function(data){
						$('.account-state').append(data);
					});
				} else if (data == 2) {
					// Password incorrect.
					$("#username p").html("");
					$("#password p").html("Password incorrect.");

				}	else if (data == 3) {
					// User not found.
					$("#username p").html("User not found.");
					$("#password p").html("");
				}
			}
		});
	});

	// Photo votes
	$(".vote").click(function(){
		var photo_id = $(this).parents(".vote-photo-element").attr('data-photo-id');
		var vote; 
		var vote_button = $(this); 

		console.log('it was clicked!');
		console.log('photo id is: ' + photo_id);
		
		console.log('checking if user is logged in');
		// Check logged-in state.
		// Right now this is done by ajax to $_SESSION but should just be a js user object.
		$.ajax({
			type: "POST",
			url: "../../build/ajaxes/check-logged-in.php",
			success: function(data){
				console.log('Log in check returned: ' + data);
				// Data returns 1 if logged in. 0 if not logged in.
				if (data == 1) {
					// Submit vote
					console.log('Submitting vote');
					if (vote_button.hasClass('selected')) {
						// Uncast vote.
						// Remove class 
						vote_button.removeClass('selected');
						// Remove vote ajax
						$.ajax({
							type: "POST",
							data: {photo_id: photo_id, undo_vote: 1},
							url: "../../build/ajaxes/vote.php",
							success: function(data){
								console.log('finished unvote!');
								console.log(data);
								$('.vote-photo-element[data-photo-id = ' + photo_id + ']').find('.rating-number').text(data);
							}
						});
					} else {
						// Cast vote.
						// Add class
						vote_button.siblings('.vote').removeClass('selected');
						vote_button.addClass('selected');
						// Vote Ajax
						vote_button.hasClass('upvote') ? vote = 1 : vote = -1;
						$.ajax({
							type: "POST",
							data: {photo_id: photo_id, vote: vote, undo_vote: 0},
							url: "../../build/ajaxes/vote.php",
							success: function(data){
								console.log('finished vote!');
								console.log(data);
								$('.vote-photo-element[data-photo-id = ' + photo_id + ']').find('.rating-number').text(data);
							}
						});			
					}
				} else if (data == 0) {
					// Log in prompt
					console.log('Prompting login');
					$.fancybox.open({
						href: '/log-in.php',
						type: 'ajax'
					});
				} else {
					// Error
					console.log('Your code sucks.');
				}
			}
		});
	});
});