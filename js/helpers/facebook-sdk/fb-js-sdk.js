// FB js sdk loading

// Additional JS functions here
window.fbAsyncInit = function() {
  FB.init({
    appId      : '217282335081747', // App ID
    channelUrl : '//lookgr.am/channel.html', // Channel File
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });

  FB.getLoginStatus(function(response) {
    if(response.status === 'connected') {
      // connected
      console.log('connected');
    } else if (response.status === 'not_authorized') {
      // not_authorized
      console.log('not authorized');
    } else {
      // not_logged_in
      console.log('not logged into facebook...');
    }
  });

  // Additional init code here

};

// Load the SDK Asynchronously
(function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
 }(document));
