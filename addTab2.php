<?php
    session_start();
    require_once __DIR__ . '/src/Facebook/autoload.php';
    $mysqli = new mysqli("localhost", "docconsu_test", "F2Y]os-jc((J", "docconsu_test");
    $fb = new Facebook\Facebook([
        'app_id' => '507994349541183',
        'app_secret' => '086f3329a66b06d5e9c5f842fd7e218e',
        'default_graph_version' => 'v2.11',
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'manage_pages', 'pages_show_list'];
    try {
        if (isset($_SESSION['facebook_access_token'])) {
            $accessToken = $_SESSION['facebook_access_token'];
        } else {
            $accessToken = $helper->getAccessToken();
        }
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    if (isset($accessToken)) {
        if (isset($_SESSION['facebook_access_token'])) {
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        } else {
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            $oAuth2Client = $fb->getOAuth2Client();
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        if (isset($_GET['code'])) {
            header('Location: ./');
        }
        try {
            $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
            $profile = $profile_request->getGraphNode()->asArray();
            $helper = $fb->getPageTabHelper();
            $signedRequest = $helper->getSignedRequest();
            $signedRequest=$signedRequest->getPayload();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            header("Location: ./");
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (!empty($signedRequest)){
    ?>
    <?php       
        $pageid = $signedRequest[page][id];
        $pages = $mysqli->query("SELECT * FROM page_tab WHERE page_id='$pageid' ORDER BY id DESC LIMIT 1");
        foreach ($pages as $page) {
            if (!empty($page['doc_id'])){
                $_GET['id']=$page['doc_id'];
            } else if (!empty($page['client_id'])){
                $_GET['cid']=$page['client_id'];
            }
        }
        include("tab.php");
    ?>
    <?php
        }
    } else {
        $loginUrl = $helper->getLoginUrl('https://www.docconsult.in/ni/addTab2/', $permissions);
        echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
?>