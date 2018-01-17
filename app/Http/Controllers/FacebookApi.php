<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookApi extends Controller
{
    var $fb = '';
    var $permissions = ['user_likes','user_posts'],
        $helper, $accessToken;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('activation');

        $this->fb = new \Facebook\Facebook([
            'app_id' => '140541336639465',
            'app_secret' => '0d563e073aa6dbf6837c9b2f73944ef9',
            'default_graph_version' => 'v2.11',
        ]);
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
    }

    public function index() {

        $access_token = $this->helper->getAccessToken();

        if(empty($access_token)) {
            echo "<a href='{$this->helper->getLoginUrl("http://localhost:8888/liker/public/test")}'>Login with Facebook </a>";
        }

        if(isset($access_token)) {
            try {
                $response = $this->fb->get('/2008908772469279/likes',$access_token);
                $fb_user = $response->getGraphUser();
                dd($fb_user);
                //  var_dump($fb_user);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo  'Graph returned an error: ' . $e->getMessage();
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
            }
        }
    }
}
