<html>
<head>
</head>
<body>
<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "docconsu_db");
$results = $mysqli->query("SELECT * FROM page_tab WHERE page_id='844795362356091' order by id");
foreach ($results as $result) {
  print_r($result);
  echo "<br />";
}
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

    if(isset($accessToken)){ ?>
      <?php
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
        $sql = "SELECT name, id FROM clinic WHERE id IN ('1', '2' , '3' , '4')";
        $clinictable = $mysqli->query($sql);
        print_r($clinictable);
      ?>
      <?php if (!empty($testdata)) { ?>
        <form action="" method="POST">
          <select name="cdid" single>
            <option value="<?php echo "DoKKy" ?>"><?php echo "Dr. Nikhil Mehra"; ?></option>
            <?php foreach ($clinictable as $clinic) { ?>
              <option value="<?php echo ($clinic['id']); ?>"><?php echo ($clinic['name']); ?></option>
            <?php } ?>
          </select>
          <select name="page" single>
            <?php foreach ($testdata as $key) { ?>
                <option value="<?php echo $key['id']; ?>"><?php echo $key['name']; ?></option>
            <?php }?>
          </select>
          <input type="hidden" value="<?php echo $key['access_token']; ?>" />
          <input type="submit" name="submit" />
        </form>
      <?php } else {?>
        <div>
          No Facebook Page exists
        </div>
      <?php } ?>

    <?php } else {
      $loginUrl = $helper->getLoginUrl('http://localhost:4001/addTabPC.php', $permissions);
      echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    } ?>
  
  <?php
  if (isset($_POST['submit'])){
    $page = $fb->get('/'.$_POST['page'].'?fields=access_token, name, id');
    $page = $page->getGraphNode()->asArray();
    $addTab = $fb->post('/'.$page['id'].'/tabs', array('app_id' => '507994349541183'), $page['access_token']);
    $addTab = $addTab->getGraphNode()->asArray();
    $pageid=$_POST['page'];
    print_r($addTab);
    if ($addTab[success] == 1){
      if ($_POST['cdid'] == "DoKKy") {
        $userid = $_SESSION['login_id'];
        $mysqli->query("INSERT INTO page_tab SET doc_id='$userid', page_id='$pageid'");
      } else {
        $clinicid = $_POST['cdid'];
        $mysqli->query("INSERT INTO page_tab SET clinic_id='$clinicid', page_id='$pageid'");
      }
      echo "tab added";
    } else {
      echo "There is some error. Please RELOAD the page and try again";
    }
  }
  ?>

</body>

</html>


