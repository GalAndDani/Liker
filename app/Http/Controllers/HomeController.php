<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('welcome', 'welcomeRef');
        $this->middleware('activation')->except('welcome', 'welcomeRef');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        if(Auth::user() && Auth::user()->verified == 1) {
            return $this->dashboard();
        }
        return view('welcome');
    }

    public function welcomeRef($ref_id)
    {
        if(Auth::user() && Auth::user()->verified == 1) {
            return $this->dashboard();
        }
        return view('welcome')->with([
            'user_ref_id' => $ref_id
        ]);
    }

    public function dashboard()
    {
        $fb = new FacebookApi();
        $insta = new InstagramApi();

        $insta_code = app('request')->input('code');
        if($insta_code) {
            $insta->login_code($insta_code);
        }

        return view('home')->with([
            'fb_access' => $fb->fb_register(),
            'insta_access' => $insta->insta_register(),
        ]);
    }

    public function verified() {
        return view('email.emailconfirm');
    }

    public function unverified() {
        return view('email.verification');
    }
}
