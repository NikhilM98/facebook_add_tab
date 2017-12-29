<?php
    session_start();
        // Start the SESSION

    require_once __DIR__ . '/src/Facebook/autoload.php';
        // Import FB PHP SDK

    $mysqli = new mysqli("host", "username", "password", "database_name");
        // Connect to database

    $fb = new Facebook\Facebook([
        'app_id' => '{Your App ID}',
        'app_secret' => '{Your App Secret}',
        'default_graph_version' => '{Your Graph Version}',
    ]);
        // Create a facebook object
        // It is used to connect with your app each time a request is made

    $helper = $fb->getPageTabHelper();
        // Create a getPageTabHelper
        // This helper is used to get access_token from facebook tab

    try {
        $accessToken = $helper->getAccessToken();
            // Use helper to get accessToken

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
            // When Graph returns an error

    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
            // When validation fails or other local issues

    }

    if (isset($accessToken)) {
        // If $accessToken is set

	    if (isset($_SESSION['facebook_access_token'])) {
                // If facebook_access_token is set

            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                // Set setDefaultAccessToken equal to facebook_access_token
                // Now you don't need to provide $accessToken whenever you make any request

	    } else {
            // If facebook_access_token is not set

            $_SESSION['facebook_access_token'] = (string) $accessToken;
                // getting short-lived access token

            $oAuth2Client = $fb->getOAuth2Client();
                // OAuth 2.0 client handler

            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                // Exchanges a short-lived access token for a long-lived one

            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                // Set the short-lived access token in session equal to long-lived access token

            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                // setting default access token to be used in script

        }

        if (isset($_GET['code'])) {

            header('Location: ./');
                // redirect the user back to the same page if it has "code" GET variable

        }

        try {

            $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
                // Create a GET request to get basic info about user

            $profile = $profile_request->getGraphNode()->asArray();
                // Convert the data from the GET request into Array

            $helper = $fb->getPageTabHelper();
                // Create a new getPageTabHelper

            $signedRequest = $helper->getSignedRequest();
                // Get Signed Request using the helper

            $signedRequest=$signedRequest->getPayload();
                // Exteract Payload from the Signed Request

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
                // When Graph returns an error

            header("Location: ./");
            exit;
                // redirecting user back to app login page

        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
                // When validation fails or other local issues

        }

        if (!empty($signedRequest)){
            // If $signedRequest object is not empty
            
            $pageid = $signedRequest[page][id];
                // Set $pageid equal to page-id obtained using signedRequest

            $pages = $mysqli->query("SELECT * FROM page_tab WHERE page_id='$pageid' ORDER BY id DESC LIMIT 1");
                // Make a query to obtain user corresponding to the page_id
            
            foreach ($pages as $page) {
                if (!empty($page['doc_id'])){
                    $_GET['id']=$page['doc_id'];
                    $showtab = 1;
                } else if (!empty($page['client_id'])){
                    $_GET['cid']=$page['client_id'];
                    $showtab = 1;
                }
                    // My Custom properties which I used to create dynamic page
                    // You can insert your properties here
            }

            if (isset($showtab) && $showtab == 1){
                include("tab.php");
                    // Now import the page. My page is made such that it reacts to the GET Requests
            }
        } else {
            echo "Token Obtained but Sign Request Failed /n";
        } 
    } else {
        echo "Failed to obtain token";
    }
?>