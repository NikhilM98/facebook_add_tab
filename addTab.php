<html>
<head>
</head>
<body>
<?php
  session_start();
  $mysqli = new mysqli("localhost", "docconsu_test", "F2Y]os-jc((J", "docconsu_test");
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
  if (isset($_GET['code'])) {
    header('Location: ./');
  }
  if(isset($accessToken)) { ?>
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
      //print_r($testdata);
      echo 'Logged in as ' . $userNode->getName();
    ?>
    <?php
      echo ($_SESSION['login_id']);
      $clinics = json_decode(($_SESSION['doc_details']['clinic']), true);
      $clinicid = array();
      foreach ($clinics as $clinic) {
        $clinicid[] = $clinic['clinic_id']; 
      };
      $clinicid = implode(',', $clinicid);
      $sql = "SELECT name, id FROM table WHERE id IN ('$clinicid')";
      $clinictable = $mysqli->query($sql);
    ?>
    <?php if (!empty($testdata)) { ?>
      <form action="" method="POST">
        <select name="cdid" single>
          <option value="<?php echo "DoKKy" ?>"><?php echo ($_SESSION['name']); ?></option>
          <?php foreach ($clinictable as $clinic) { ?>
            <option value="<?php echo ($clinic['id']); ?>"><?php echo ($clinic['name']); ?></option>
          <?php } ?>
        </select>
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
    <?php } else {?>
      <div>
          No Facebook Page exists
      </div>
    <?php } ?>
  <?php } else {
    $loginUrl = $helper->getLoginUrl('https://www.docconsult.in/ni/addTab/', $permissions);
    
    echo '<a href="' . $loginUrl . '">Connect with Facebook!</a>';
  } ?>
  <?php
  if (isset($_POST['submit'])){
    $pageid=$_POST['page'];    
    if ($_POST['cdid'] == "DoKKy") {
      $userid = $_SESSION['login_id'];
      $allow = $mysqli->query("SELECT allow FROM practice WHERE doctor_id = '$userid' ");
      $perm = 4;
      foreach ($allow as $permission) {
        if ($permission['allow'] < $perm){
          if ($permission['allow'] == 0){
            continue;
          } else {
            $perm = $permission['allow']; 
          }
        }
      }
      if ($perm == 1) {
        $tabname = "Book an Appointment";
      } else if ($perm == 2) {
        $tabname = "Request for Call";
      } else if ($perm == 3) {
        $tabname = "On Call";
      } else if ($perm == 4) {
        $tabname = "View Doctor Profile";
      }
      $mysqli->query("INSERT INTO page_tab SET doc_id='$userid', page_id='$pageid'");
      sendGetReq($fb, $tabname);
    } else {
      $clinicid = $_POST['cdid'];
      $allow = $mysqli->query("SELECT allow FROM clinic WHERE id = '$clinicid' ");
      $perm = 3;
      foreach ($allow as $permission) {
        if ($permission['allow'] < $perm){
          if ($permission['allow'] == 0){
            continue;
          } else {
            $perm = $permission['allow']; 
          }
        }
      }
      if ($perm == 1) {
        $tabname = "Book an Appointment";
      } else if ($perm == 2) {
        $tabname = "Request for Call";
      } else if ($perm == 3) {
        $tabname = "View Doctor Profile";
      }
      $mysqli->query("INSERT INTO page_tab SET clinic_id='$clinicid', page_id='$pageid'");
      sendGetReq($fb, $tabname);
    }
    
  }
  function sendGetReq($fb, $tabname) {
    $page = $fb->get('/'.$_POST['page'].'?fields=access_token, name, id');
    $page = $page->getGraphNode()->asArray();
    $addTab = $fb->post('/'.$page['id'].'/tabs', array('app_id' => '507994349541183', 'custom_name' => $tabname), $page['access_token']);
    $addTab = $addTab->getGraphNode()->asArray();
    if ($addTab[success] == 1){
      echo "tab added";
    } else {
      echo "There is some error. Please RELOAD the page and try again";
    }
  }
  ?>

</body>

</html>
