<html>
<head>
</head>
<body>

<?php
  require_once __DIR__ . '/vendor/autoload.php';
  $fb = new Facebook\Facebook([
    'app_id' => '{507994349541183}',
    'app_secret' => '{086f3329a66b06d5e9c5f842fd7e218e}',
    'default_graph_version' => 'v2.11',
    ]);
    $helper = $fb->getCanvasHelper();
    
    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    
    if (! isset($accessToken)) {
      echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
      exit;
    }
    
    // Logged in
    echo '<h3>Signed Request</h3>';
    var_dump($helper->getSignedRequest());
    
    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());



    
    // OAuth 2.0 client handler
    $oAuth2Client = $fb->getOAuth2Client();

    // Exchanges a short-lived access token for a long-lived one
    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken('{access-token}');
  // echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    
  // $helper = $fb->getPageTabHelper();

  // try {
  //   $accessToken = $helper->getAccessToken();
  // } catch(Facebook\Exceptions\FacebookResponseException $e) {
  //   // When Graph returns an error
  //   echo 'Graph returned an error: ' . $e->getMessage();
  //   exit;
  // } catch(Facebook\Exceptions\FacebookSDKException $e) {
  //   // When validation fails or other local issues
  //   echo 'Facebook SDK returned an error: ' . $e->getMessage();
  //   exit;
  // }

  // if (! isset($accessToken)) {
  //   echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
  //   exit;
  // }

  // // Logged in
  // echo '<h3>Page ID</h3>';
  // var_dump($helper->getPageId());

  // echo '<h3>User is admin of page</h3>';
  // var_dump($helper->isAdmin());

  // echo '<h3>Signed Request</h3>';
  // var_dump($helper->getSignedRequest());

  // echo '<h3>Access Token</h3>';
  // var_dump($accessToken->getValue());
  ?>
<html>
<head>
</head>
<body>
<body>

</html>
<body>

</html>
