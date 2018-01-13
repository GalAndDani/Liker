<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;

class FacebookApi extends Controller
{
    var $fb = '';
    public function __construct() {
        $this->middleware('auth');
        $this->fb = new Facebook([
            'app_id' => '962795670534191',
            'app_secret' => 'db0e41ea01cb2a6e8a32b6f2fbcfa108',
            'default_graph_version' => 'v2.11',
            //'default_access_token' => '{access-token}', // optional
        ]);
    }

    public function index() {

//    Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $this->fb->get('/me', '962795670534191|UvYnFoOrpKAmAHGRtR6NqZ8mcb4');
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $me = $response->getGraphUser();
        echo 'Logged in as ' . $me->getName();
    }


}
