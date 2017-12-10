<html>
<head>
</head>
<body>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '507994349541183',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v2.10'
    });
    FB.api('/me', 'GET', {fields: 'id, name, likes, posts'}, (res)  => console.log(res))
    }, {scope: 'email,user_likes,user_posts'});
    FB.AppEvents.logPageView();
  };
    
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<body>

</html>