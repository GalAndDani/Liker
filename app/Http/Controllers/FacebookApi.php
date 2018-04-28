<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacebookApi extends Controller
{
    var $fb = '';
    var $permissions = [
        'email','public_profile', 'user_likes', 'user_posts', 'publish_actions', 'user_photos', 'user_friends', 'user_birthday', 'publish_pages', 'publish_actions', 'instagram_basic',
        'manage_pages', 'user_events'
    ],
        $helper, $accessToken;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('activation');
        session_start();
        $this->fb = new \Facebook\Facebook([
            'app_id'                => '140541336639465',
            'app_secret'            => '0d563e073aa6dbf6837c9b2f73944ef9',
            'default_graph_version' => 'v2.11',
        ]);
    }

    // Facebook registration
    public function fb_register()
    {
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        try {
            if (isset($_SESSION['facebook_access_token'])) {
                $this->accessToken = $_SESSION['facebook_access_token'];
            } else {
                $this->accessToken = $this->helper->getAccessToken(url('/home'));
            }
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (isset($this->accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
                // getting short-lived access token
                $_SESSION['facebook_access_token'] = (string)$this->accessToken;
                // OAuth 2.0 client handler
                $oAuth2Client = $this->fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string)$longLivedAccessToken;
                // setting default access token to be used in script
                $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }

            try {
                $profile_request = $this->fb->get('/me?fields=picture');
                $profile = $profile_request->getGraphUser();
                if (Auth::user()) {
                    $user = User::find(Auth::user()->id);
                    $user->fb_user_id = $profile['id'];
                    $user->picture = $profile['picture']['url'];
                    $user->fb_user_token = $_SESSION['facebook_access_token'];
                    $user->save();
                }
                return '<span class="btn btn-success" style="font-size: 18px">Facebook Verified</span>';
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // redirecting user back to app login page
                exit;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            // Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
        } else {

            // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
            $loginUrl = $this->helper->getLoginUrl(url('/home'), $this->permissions);
            return '<a href="' . $loginUrl . '" class="btn btn-info">Log in with Facebook!</a>';
        }
    }

    //
    //
    //   FACEBOOK LIKES
    //
    //


    // Get likes from facebook on Page
    public function get_fb_photo_like($id, $user_id)
    {
        $token = User::where('id', $user_id)->first()->fb_user_token;
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/' . $id . '/?fields=picture,name,likes.limit(1000),sharedposts', $token);
            $profile = $profile_request->getGraphNode()->asArray();
            return $profile;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Checking if was like on some pages
    public function check_fb_photo_like($id, $user_id, $points)
    {
        $user = User::where('id', $user_id)->first();
        $token = $user->fb_user_token;

        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/' . $id . '/likes?limit=1000', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            foreach ($profile as $data) {
                if ($data['id'] == Auth::user()->fb_user_id) {
                    Auth::user()->increment('points', $points);
                    $user->decrement('points', $points);
                    return 'liked';
                }
            }
            return 'Not Liked';
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Get all fb images for Add Page Image Gallery
    public function get_fb_my_images()
    {
        $token = User::where('id', Auth::user()->id)->first()->fb_user_token;
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/me/photos/uploaded/?fields=link,picture&limit=500', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            return $profile;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }



    //
    //
    //   FACEBOOK SHARES
    //
    //

    // Get likes from facebook on Page
    public function get_fb_photo_share($id, $user_id)
    {
        $token = User::where('id', $user_id)->first()->fb_user_token;
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/' . $id . '/?fields=picture,name,likes.limit(1000),sharedposts', $token);
            $profile = $profile_request->getGraphNode()->asArray();
            return $profile;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Checking if was like on some pages
    public function check_fb_photo_share($id, $user_id, $points)
    {
        $user = User::where('id', $user_id)->first();
        $token = $user->fb_user_token;

        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/' . $id . '/sharedposts?fields=id,name', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            foreach ($profile as $data) {
                $id = explode('_', $data['id']);
                if ($id[0] == Auth::user()->fb_user_id) {
                    Auth::user()->increment('points', $points);
                    $user->decrement('points', $points);
                    return 'shared';
                }
            }
            return 'Not Shared';
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }


    ///
    /// FACEBOOK POSTS
    ///

    // Get likes from facebook on Page
    public function get_fb_post_like($id, $user_id)
    {
        $token = User::where('id', $user_id)->first()->fb_user_token;
        $user_fb_id = User::where('id', $user_id)->first()->fb_user_id;
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/'. $user_fb_id .'_'. $id .'/likes?limit=10000&summary=true', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            return $profile;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Get all fb images for Add Page Image Gallery
    public function get_fb_my_posts()
    {
        $token = User::where('id', Auth::user()->id)->first()->fb_user_token;
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/me?fields=posts.limit(50)', $token);
            $profile = $profile_request->getGraphNode()->asArray();
            return $profile;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Checking if was like on some pages
    public function check_fb_post_like($id, $user_id, $points)
    {
        $user = User::where('id', $user_id)->first();
        $user_fb_id = User::where('id', $user_id)->first()->fb_user_id;
        $token = $user->fb_user_token;

        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/'. $user_fb_id .'_'. $id .'/likes?limit=10000&summary=true', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            foreach ($profile as $data) {
                if ($data['id'] == Auth::user()->fb_user_id) {
                    Auth::user()->increment('points', $points);
                    $user->decrement('points', $points);
                    return 'liked';
                }
            }
            return 'Not Liked';
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Get likes from facebook on Page
    public function get_fb_post_share($id, $user_id)
    {
        $token = User::where('id', $user_id)->first()->fb_user_token;
        $user_fb_id = User::where('id', $user_id)->first()->fb_user_id;
        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/'. $user_fb_id .'_'. $id .'/likes?limit=10000&summary=true', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            return $profile;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    // Checking if was like on some pages
    public function check_fb_post_share($id, $user_id, $points)
    {
        $user = User::where('id', $user_id)->first();
        $user_fb_id = User::where('id', $user_id)->first()->fb_user_id;
        $token = $user->fb_user_token;

        $this->helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $profile_request = $this->fb->get('/'. $user_fb_id .'_'. $id .'/sharedposts?fields=id,name', $token);
            $profile = $profile_request->getGraphEdge()->asArray();
            foreach ($profile as $data) {
                $id = explode('_', $data['id']);
                if ($id[0] == Auth::user()->fb_user_id) {
                    Auth::user()->increment('points', $points);
                    $user->decrement('points', $points);
                    return 'shared';
                }
            }
            return 'Not Shared';
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // redirecting user back to app login page
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}
