<?php
    include("../mainframe.php"); 
    session_start();
    require_once __DIR__ . '/src/Facebook/autoload.php';
    $fb = new Facebook\Facebook([
        'app_id' => '507994349541183',
        'app_secret' => '086f3329a66b06d5e9c5f842fd7e218e',
        'default_graph_version' => 'v2.11',
    ]);

    $helper = $fb->getPageTabHelper();

    try {
        $accessToken = $helper->getAccessToken();

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();

    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();

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
            $pageid = $signedRequest[page][id];
            $pages = $functions->db->query("SELECT * FROM page_tab WHERE page_id='$pageid' ORDER BY id DESC LIMIT 1");
            foreach ($pages as $page) {
                if ($page['doc_id'] != ''){
                    $_GET['id']=$page['doc_id'];
                    include("../appointment_detail.php");
                } else if ($page['clinic_id'] != ''){
                    $_GET['cid']=$page['clinic_id'];
                    include("../appointment_detail.php");
                }
            }
        }
    }
?>