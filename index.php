<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId            : '507994349541183',
          cookie           : true,
          autoLogAppEvents : true,
          xfbml            : true,
          version          : 'v2.11'
        });
      };
      // Load the SDK asynchronously
      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/debug.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      // Call FB.getLoginStatus
      // Function will trigger a call to Facebook to get the login status
      // and call the callback function with the results
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }      
      // Callback
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // 1. Logged into your app ('connected')
        // 2. Logged into Facebook, but not your app ('not_authorized')
        // 3. Not logged into Facebook and can't tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function.
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
          testAPI();
        } else {
          // The person is not logged into your app or we are unable to tell.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
        }
      }
      // This function is called when someone finishes with the Login
      function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
          console.log('Successful login for: ' + response.name);
          document.getElementById('status').innerHTML =
            'Thanks for logging in, ' + response.name + '!';
          console.log(response);
        });
        FB.ui(
          {
            method: 'pagetab',
            redirect_uri: 'https://www.docconsult.in/form-search.php?city=Jaipur&location=&type=The+Neurocare+%26+Stroke+clinic&docti=1&catgo=Clinic&locate=&doc_type=&page=1',
          },
          // callback
          function(response) {
            if (response && !response.error_message) {
              alert('Posting completed.');
            } else {
              alert('Error while posting.');
            }
          }
        );
      }
    </script>
    <!--
      Below we include the Login Button social plugin. This button uses
      the JavaScript SDK to present a graphical Login button that triggers
      the FB.login() function when clicked.
    -->

    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
    </fb:login-button>

    <div id="status">
    </div>
  <body>
</html>