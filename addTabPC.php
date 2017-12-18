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
  $_SESSION['cid']="Testin";
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
      print_r($testdata);
      echo "<hr/>";
      echo ($testdata[0][perms][0]);
      echo "<hr/>";
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



<?php

$arr = "(
    [app:protected] => Facebook\FacebookApp Object
        (
            [id:protected] => 507994349541183
            [secret:protected] => 086f3329a66b06d5e9c5f842fd7e218e
        )

    [rawSignedRequest:protected] => A-tCrQ9ywSu3fgIU1bYyPks0z54Y5jDor35DoK6YKPQ.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImV4cGlyZXMiOjE1MTM1OTg0MDAsImlzc3VlZF9hdCI6MTUxMzU5MjA3Miwib2F1dGhfdG9rZW4iOiJFQUFIT0JLYkFsejhCQUJRNkI2c0xUR3g0QXBSRXBRTkV5c0ZUa1R4UUFHTExVNkt1QW80dDhiN3JtdDhhTVQ0YWdmUFdNczFkMHZ1eDNxWG9aQXhoSjhwMVdBS1VsbE44bHBpUkNqR3p0dkRHb2diZE5NejM1MmdGU1NnMUxFUldURzd0eFNxS0U5N2ZNUWJkcnYxekRzSXVqU080NG5kb1VCeVFaQkZjT0lnMlJoalRSTElWbjdYQVdOa2NzWkQiLCJwYWdlIjp7ImlkIjoiODQ0Nzk1MzYyMzU2MDkxIiwiYWRtaW4iOnRydWV9LCJ1c2VyIjp7ImNvdW50cnkiOiJpbiIsImxvY2FsZSI6ImVuX0dCIiwiYWdlIjp7Im1pbiI6MTgsIm1heCI6MjB9fSwidXNlcl9pZCI6IjE5MjUyMTgxNDQzNjI3MTUifQ
    [payload:protected] => Array
        (
            [algorithm] => HMAC-SHA256
            [expires] => 1513598400
            [issued_at] => 1513592072
            [oauth_token] => EAAHOBKbAlz8BABQ6B6sLTGx4ApREpQNEysFTkTxQAGLLU6KuAo4t8b7rmt8aMT4agfPWMs1d0vux3qXoZAxhJ8p1WAKUllN8lpiRCjGztvDGogbdNMz352gFSSg1LERWTG7txSqKE97fMQbdrv1zDsIujSO44ndoUByQZBFcOIg2RhjTRLIVn7XAWNkcsZD
            [page] => Array
                (
                    [id] => 844795362356091
                    [admin] => 1
                )

            [user] => Array
                (
                    [country] => in
                    [locale] => en_GB
                    [age] => Array
                        (
                            [min] => 18
                            [max] => 20
                        )

                )

            [user_id] => 1925218144362715
        )

)";
print "<pre>";
print_r($arr);
print "</pre>";

$arr1 = json_encode($arr);
$arr2 = json_decode($arr1);

print "<pre>";
print_r($arr2);
print "</pre>";

?>
