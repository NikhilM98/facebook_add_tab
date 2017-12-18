<html>
<head>
</head>
<body>

<?php
  session_start();
  require_once __DIR__ . '/src/Facebook/autoload.php';
  $fb = new Facebook\Facebook([
    'app_id' => '507994349541183',
    'app_secret' => '086f3329a66b06d5e9c5f842fd7e218e',
    'default_graph_version' => 'v2.11',
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'manage_pages', 'pages_show_list'];
    try {
      if (isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
      } else {
        $accessToken = $helper->getAccessToken(); 
      }
    } catch (Facebook\Exceptions\FacebookResponseException $e){
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e){
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if(isset($accessToken)){
      if (isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
      } else {
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        $oAuth2Client = $fb->getOAuth2Client();
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken('{access-token}');
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
      }

      try {
        $response = $fb -> get('/me');
        $userNode = $response->getGraphUser();
      } catch (Facebook\Exceptions\FacebookResponseException $e){
        echo 'Graph returned an error: ' . $e->getMessage();
        unset($_SESSION['facebook_access_token']);
        exit;
      } catch (Facebook\Exceptions\FacebookSDKException $e){
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }

      $page_id = "";
      $sr = $facebook->getSignedRequest();
      print_r($sr);
      // if($page = $sr['page']) {
      //     $page_id = $page['id'];
      // }

      echo 'Logged in as ' . $userNode->getName();
    } else {
      $loginUrl = $helper->getLoginUrl('https://www.docconsult.in/ni/whichPage/', $permissions);
      echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
  ?>

</body>

</html>