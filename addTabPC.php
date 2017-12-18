<html>
<head>
</head>
<body>
<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "docconsu_db");
$result = $mysqli->query("SELECT * FROM page_tab");
print_r($result);
?>
<?php
  session_start();
  $_SESSION['id']="Testing";
  require_once __DIR__ . '/vendor/autoload.php';
  $fb = new Facebook\Facebook([
    'app_id' => '1912556462327602',
    'app_secret' => 'a98e53d12469111ece622c4ced035685',
    'default_graph_version' => 'v2.10',
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
      $testdata = $fb -> get('/me/accounts');
      $testdata = $testdata->getGraphEdge()->asArray();
      //print_r($testdata);
      echo 'Logged in as ' . $userNode->getName();
    } else {
      $loginUrl = $helper->getLoginUrl('http://localhost:4001/addTabPC.php', $permissions);
      
      echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
  ?>
  <form action="" method="POST">
    <select name="page" single>
    <?php
      foreach ($testdata as $key) {
        ?>
        <option value="<?php echo $key['id']; ?>"><?php echo $key['name']; ?></option>
        <?php }?>
    </select>
    <input type="hidden" value="<?php echo $key['access_token']; ?>" />
    <input type="submit" name="submit" />
  </form>
  <?php
  if (isset($_POST['submit'])){
    $page = $fb->get('/'.$_POST['page'].'?fields=access_token, name, id');
    $page = $page->getGraphNode()->asArray();
    //print_r($page);
    $addTab = $fb->post('/'.$page['id'].'/tabs', array('app_id' => '507994349541183'), $page['access_token']);
    $addTab = $addTab->getGraphNode()->asArray();
    print_r($addTab);
    $userid=$_SESSION['id'];
    $pageid=$_POST['page'];
    $mysqli->query("INSERT INTO page_tab SET doc_id='$userid', page_id='$pageid'");
  }
  ?>

</body>

</html>
