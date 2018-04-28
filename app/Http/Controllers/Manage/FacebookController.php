<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\FacebookApi;
use App\Page;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('activation');
    }

    // Pages View
    public function fb_photo_likes()
    {
        $fb = new FacebookApi();
        return view('facebook.photo.likes')->with([
            'fb' => $fb
        ]);
    }

    public function fb_photo_shares()
    {
        $fb = new FacebookApi();
        return view('facebook.photo.shares')->with([
            'fb' => $fb
        ]);
    }

    public function fb_post_likes()
    {
        $fb = new FacebookApi();
        return view('facebook.post.likes')->with([
            'fb' => $fb
        ]);
    }

    public function fb_post_shares()
    {
        $fb = new FacebookApi();
        return view('facebook.post.shares')->with([
            'fb' => $fb
        ]);
    }

    ///
    /// FACEBOOK PHOTOS
    ///

    public function get_pages_photo_like()
    {
        $fb = new FacebookApi();
        $data = [];
        $pages = Page::where([
            [ 'ppc', '<', Auth::user()->points ],
            [ 'type', 'fb_photo_like' ],
//            [ 'user_id', '!=', Auth::user()->id ],
            [ 'trash', '!=', 1 ]
        ])
            ->orderByRaw("RAND()")
            ->limit(1)->get()->each(function ($page) use ($fb, &$data) {
                parse_str($page['url'], $url);
                $post_id = $url['https://www_facebook_com/photo_php?fbid'];
                $posts = $fb->get_fb_photo_like($post_id, $page->user_id);
//                foreach ($posts['likes'] as $like) {
//                    if ($like['id'] == Auth::user()->fb_user_id) {
//                        return false;
//                    }
//                }
                $obj = new \stdClass();
                $obj->user_id = $page->user_id;
                $obj->post_id = $page->id;
                $obj->fb_post_id = $posts['id'];
                $obj->fb_user_id = $page->fb_user_id;
                $obj->url = $page->url;
                $obj->pic = $posts['picture'];
                $obj->desc = isset($posts['name']) ? $posts['name'] : 'N/A';
                $obj->ppc = $page->ppc;
                $obj->likes = count($posts['likes']);
                $obj->shares = isset($posts['sharedposts']) ? count($posts['sharedposts']) : 0;
                $data[] = $obj;
            });

        return count($data) == 0 ? 'no-result' : $data;
    }

    public function check_pages_photo_like(Request $request)
    {
        $fb = new FacebookApi();
        $post_id = $request->get('fb_post_id');
        $user_id = $request->get('user_id');
        $points = $request->get('points');
        $posts = $fb->check_fb_post_like($post_id, $user_id, $points);
        return $posts;
    }



    public function get_pages_photo_share()
    {
        $fb = new FacebookApi();
        $data = [];
        $pages = Page::where([
            [ 'ppc', '<', Auth::user()->points ],
            [ 'type', 'fb_photo_share' ],
//            [ 'user_id', '!=', Auth::user()->id ],
            [ 'trash', '!=', 1 ]
        ])
            ->orderByRaw("RAND()")
            ->limit(1)->get()->each(function ($page) use ($fb, &$data) {
                parse_str($page['url'], $url);
                $post_id = $url['https://www_facebook_com/photo_php?fbid'];
                $posts = $fb->get_fb_photo_share($post_id, $page->user_id);
//                foreach ($posts['likes'] as $like) {
//                    if ($like['id'] == Auth::user()->fb_user_id) {
//                        return false;
//                    }
//                }
                $obj = new \stdClass();
                $obj->user_id = $page->user_id;
                $obj->post_id = $page->id;
                $obj->fb_post_id = $posts['id'];
                $obj->fb_user_id = $page->fb_user_id;
                $obj->url = $page->url;
                $obj->pic = $posts['picture'];
                $obj->desc = isset($posts['name']) ? $posts['name'] : 'N/A';
                $obj->ppc = $page->ppc;
                $obj->likes = count($posts['likes']);
                $obj->shares = isset($posts['sharedposts']) ? count($posts['sharedposts']) : 0;
                $data[] = $obj;
            });

        return count($data) == 0 ? 'no-result' : $data;
    }

    public function check_pages_photo_share(Request $request)
    {
        $fb = new FacebookApi();
        $post_id = $request->get('fb_post_id');
        $user_id = $request->get('user_id');
        $points = $request->get('points');
        $posts = $fb->check_fb_photo_share($post_id, $user_id, $points);
        return $posts;
    }


    ///
    ///  FACEBOOK POSTS
    ///

    public function get_pages_post_like()
    {
        $fb = new FacebookApi();
        $data = [];
        $pages = Page::where([
            [ 'ppc', '<', Auth::user()->points ],
            [ 'type', 'fb_post_like' ],
//            [ 'user_id', '!=', Auth::user()->id ],
            [ 'trash', '!=', 1 ]
        ])
            ->orderByRaw("RAND()")
            ->limit(1)->get()->each(function ($page) use ($fb, &$data) {
                $post_id = $page->url;
                $posts = $fb->get_fb_post_like($post_id, $page->user_id);
//                foreach ($posts['likes'] as $like) {
//                    if ($like['id'] == Auth::user()->fb_user_id) {
//                        return false;
//                    }
//                }
                $user = User::where('id', $page->user_id)->first();
                $obj = new \stdClass();
                $obj->user_id = $page->user_id;
                $obj->post_id = $page->id;
                $obj->fb_post_id = $page->url;
                $obj->fb_user_id = $page->fb_user_id;
                $obj->url = 'https://www.facebook.com/'. $user->fb_user_id .'/posts/' . $page->url;
                $obj->pic = $user->picture;
                $obj->desc = $page->img;
                $obj->ppc = $page->ppc;
                $obj->likes = count($posts);
                $obj->shares = isset($posts['sharedposts']) ? count($posts['sharedposts']) : 0;
                $data[] = $obj;
            });

        return count($data) == 0 ? 'no-result' : $data;
    }

    public function check_pages_post_like(Request $request)
    {
        $fb = new FacebookApi();
        $post_id = $request->get('fb_post_id');
        $user_id = $request->get('user_id');
        $points = $request->get('points');
        $posts = $fb->check_fb_post_like($post_id, $user_id, $points);
        return $posts;
    }


    public function get_pages_post_share()
    {
        $fb = new FacebookApi();
        $data = [];
        $pages = Page::where([
            [ 'ppc', '<', Auth::user()->points ],
            [ 'type', 'fb_post_share' ],
//            [ 'user_id', '!=', Auth::user()->id ],
            [ 'trash', '!=', 1 ]
        ])
            ->orderByRaw("RAND()")
            ->limit(1)->get()->each(function ($page) use ($fb, &$data) {
                $post_id = $page->url;
                $posts = $fb->get_fb_post_share($post_id, $page->user_id);
//                foreach ($posts['likes'] as $like) {
//                    if ($like['id'] == Auth::user()->fb_user_id) {
//                        return false;
//                    }
//                }
                $user = User::where('id', $page->user_id)->first();
                $obj = new \stdClass();
                $obj->user_id = $page->user_id;
                $obj->post_id = $page->id;
                $obj->fb_post_id = $page->url;
                $obj->fb_user_id = $page->fb_user_id;
                $obj->url = 'https://www.facebook.com/'. $user->fb_user_id .'/posts/' . $page->url;
                $obj->pic = $user->picture;
                $obj->desc = $page->img;
                $obj->ppc = $page->ppc;
                $obj->likes = count($posts);
                $obj->shares = isset($posts['sharedposts']) ? count($posts['sharedposts']) : 0;
                $data[] = $obj;
            });

        return count($data) == 0 ? 'no-result' : $data;
    }

    public function check_pages_post_share(Request $request)
    {
        $fb = new FacebookApi();
        $post_id = $request->get('fb_post_id');
        $user_id = $request->get('user_id');
        $points = $request->get('points');
        $posts = $fb->check_fb_post_share($post_id, $user_id, $points);
        return $posts;
    }
}
