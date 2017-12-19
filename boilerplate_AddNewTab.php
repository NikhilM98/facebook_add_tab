<html>
    <head>
    </head>
    <body>
        <?php

            session_start();
                // Start the SESSION

            $mysqli = new mysqli("host", "username", "password", "database_name");
                // Import FB PHP SDK

            require_once __DIR__ . '/src/Facebook/autoload.php';
                // Import FB PHP SDK

            $fb = new Facebook\Facebook([
                'app_id' => '507994349541183',
                'app_secret' => '086f3329a66b06d5e9c5f842fd7e218e',
                'default_graph_version' => 'v2.11',
            ]);
                // Create a facebook object
                // It is used to connect with your app each time a request is made

            $helper = $fb->getRedirectLoginHelper();
                // Create a getRedirectLoginHelper
                // This helper is used to get access_token from facebook tab

            $permissions = ['email', 'manage_pages', 'pages_show_list'];
                // These are the permissions that getRedirectLoginHelper takes from the user

            try {
                if (isset($_SESSION['facebook_access_token'])) {
                    $accessToken = $_SESSION['facebook_access_token'];
                        // If facebook_access_token is set in the SESSION then set it equal to $accessToken

                } else {
                    $accessToken = $helper->getAccessToken();
                        // Else get $accessToken using $helper

                }

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
                    // When Graph returns an error

            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
                    // When validation fails or other local issues

            }

            if(isset($accessToken)) { 
                // If $accessToken is set
            ?>

                <?php 
                    if (isset($_SESSION['facebook_access_token'])){
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

                        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken('{access-token}');
                            // Exchanges a short-lived access token for a long-lived one

                        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                            // Set the short-lived access token in session equal to long-lived access token

                        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                            // setting default access token to be used in script

                    }

                    try {

                        $response = $fb -> get('/me');
                            // Create a GET request to get basic info about user

                        $userNode = $response->getGraphUser();
                            // Get User Details from the $response

                        $testdata = $fb -> get('/me/accounts');
                            // Create a GET request to get info about the pages added by the user

                        $testdata = $testdata->getGraphEdge()->asArray();
                            // Convert the data into Array

                    } catch (Facebook\Exceptions\FacebookResponseException $e){
                        echo 'Graph returned an error: ' . $e->getMessage();
                        unset($_SESSION['facebook_access_token']);
                        exit;
                            // When Graph returns an error

                    } catch (Facebook\Exceptions\FacebookSDKException $e){
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                            // When validation fails or other local issues

                    }
                ?>

                <?php

                    $clinics = json_decode(($_SESSION['doc_details']['clinic']), true);
                        // Get ID of the Clinics from the SESSION

                    $clinicid = array();
                        // Define an empty array

                    foreach ($clinics as $clinic) {
                        $clinicid[] = $clinic['clinic_id']; 
                    };
                        // ForEach loop to create array of clinics

                    $clinicid = implode(',', $clinicid);
                        // Convert $clinicid into desirable format to extract clinics from database

                    $sql = "SELECT name, id FROM table WHERE id IN ('$clinicid')";
                        // Define SQL Query to obtain table containing Clinic Names and Clinic IDs

                    $clinictable = $mysqli->query($sql);
                        // Execute the SQL query

                    if (!empty($testdata)) { 
                        // If Facebook Page exists

                        ?>

                        <form action="" method="POST">
                            <!-- Create a form -->

                            <select name="cdid" single>
                                <!-- First Select Option to Output Doctor or Clinic ID  -->

                                <option value="<?php echo "DoKKy" ?>">
                                    <?php echo ($_SESSION['name']); ?>
                                </option>
                                    <!-- If value DoKKy is output then that means that Doctor himself is selected -->

                                <?php foreach ($clinictable as $clinic) { ?>
                                    <option value="<?php echo ($clinic['id']); ?>">
                                        <?php echo ($clinic['name']); ?>
                                    </option>
                                <?php } ?>
                                    <!-- ForEach loop to iterate the clinics from the ClinicTable in the Options -->

                            </select>
                            
                            <select name="page" single>
                                <!-- Second Select Option to Output Page ID -->

                                <?php foreach ($testdata as $key) { ?>
                                    <option value="<?php echo $key['id']; ?>">
                                        <?php echo $key['name']; ?>
                                    </option>
                                <?php }?>
                                    <!-- ForEach loop to iterate the Page ID and Page Names in the Options -->

                            </select>

                            <input type="submit" name="submit" />
                                <!-- Submit Button to send a POST request on the same page -->

                        </form>

                <?php 
                    } else { 
                        // If Facebook Pages do not exists

                        ?>
                        <div>
                            No Facebook Page exists
                        </div>

                <?php 
                    } ?>

        <?php 
            } else {
                // If $accessToken is not set

                $loginUrl = $helper->getLoginUrl('https://www.website.in/boilerplate_AddNewTab/', $permissions);
                    // Create getLoginUrl helper. User should be redirected to this page again

                echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
                    // Get OAuth Authentication from user

            } ?>

        <?php
            if (isset($_POST['submit'])){
                // If POST data has Submit data

                $page = $fb->get('/'.$_POST['page'].'?fields=access_token, name, id');
                    // Create a GET request to get the page_access_token, name, id from the user

                $page = $page->getGraphNode()->asArray();
                    // Convert the data into Array

                $addTab = $fb->post('/'.$page['id'].'/tabs', array('app_id' => '507994349541183'), $page['access_token']);
                    // Create a POST request to create a new tab.
                    // App_id and Page Access Token are provides in the POST request
                    // The Response is recorded in $addTab

                $addTab = $addTab->getGraphNode()->asArray();
                    // $addTab data is converetd into Array

                $pageid=$_POST['page'];
                    // Set PageID equal to the one submitted by the user using the above form

                if ($addTab[success] == 1){
                    // If tab is successfully added
                    // Now we'll add data into database

                    if ($_POST['cdid'] == "DoKKy") {
                        // If value DoKKy is output then that means that Doctor himself is selected

                        $userid = $_SESSION['login_id'];
                            // Get Doctor ID from SESSION

                        $mysqli->query("INSERT INTO page_tab SET doc_id='$userid', page_id='$pageid'");
                            // Insert Doctor ID into Table

                    } else {
                        // If any Clinic is Selected instead of Doctor then

                        $clinicid = $_POST['cdid'];
                            // Set Clinic ID equal to one obtained from above form

                        $mysqli->query("INSERT INTO page_tab SET clinic_id='$clinicid', page_id='$pageid'");
                            // Insert Clinic ID into the Table

                    }

                    echo "tab added";
                        // Tab has been Added

                } else {
                    echo "There is some error. Please RELOAD the page and try again";
                        // Facebook returned some error. Tab was not added
                }
            }
        ?>

    </body>
</html>
