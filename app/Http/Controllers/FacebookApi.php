<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookApi extends Controller
{
    var $fb = '';
    var $permissions = [
        'email','public_profile','user_likes','user_posts','publish_actions','user_photos', 'user_friends', 'user_birthday', 'publish_pages', 'publish_actions', 'instagram_basic',
        'manage_pages', 'user_events'
    ],
        $helper, $accessToken;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('activation');
        $this->fb = new \Facebook\Facebook([
            'app_id' => '140541336639465',
            'app_secret' => '0d563e073aa6dbf6837c9b2f73944ef9',
            'default_graph_version' => 'v2.11',
        ]);
    }

    public function index() {
        session_start();

        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        try {
            if (isset($_SESSION['facebook_access_token'])) {
                $this->accessToken = $_SESSION['facebook_access_token'];
            } else {
                $this->accessToken = $this->helper->getAccessToken();
            }
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (isset($this->accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
                // getting short-lived access token
                $_SESSION['facebook_access_token'] = (string) $this->accessToken;
                // OAuth 2.0 client handler
                $oAuth2Client = $this->fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                // setting default access token to be used in script
                $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }
            // redirect the user back to the same page if it has "code" GET variable
//            if (isset($_GET['code'])) {
//                header('Location: ./');
//            }
            // getting basic info about user - ME : 10208546631303190
            try {
                $profile_request = $this->fb->get('/10214889748302477/likes');
                $profile = $profile_request->getGraphEdge()->asArray();
                foreach ($profile as $key) {
                    if($key['id'] == '10208546631303190')
                        return 'true';
                }
                return 'false';
            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // redirecting user back to app login page
                exit;
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            // Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
        } else {
            // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
            $loginUrl = $this->helper->getLoginUrl(url('/login-fb'), $this->permissions);
            echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
        }
    }
}
