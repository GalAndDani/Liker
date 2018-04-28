<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class InstagramApi extends Controller
{
    var $client, $insta, $options;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('activation');
        $this->options = [
            'client_id'     => 'f91da8eb774e48ee98dc81baef20ed51',
            'client_secret' => '080a12472dbc4941aa9dd2c1c7a100b5',
            'redirect_uri'  => url('/'),
            'grant_type'    => 'authorization_code',
        ];
        $this->client = new Client();
    }

    public function insta_register()
    {
        $url = 'https://www.instagram.com/oauth/authorize/?client_id=' . $this->options['client_id'] . '&redirect_uri=' . $this->options['redirect_uri'] . '&response_type=code';
        return '<a href="' . $url . '" class="btn btn-danger" style="font-size: 18px">Log in with Instagram!</a>';
    }

    public function login_code($code)
    {
        $request = $this->client->post('https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'client_id'     => $this->options['client_id'],
                'client_secret' => $this->options['client_secret'],
                'grant_type'    => $this->options['grant_type'],
                'redirect_uri'  => $this->options['redirect_uri'],
                'code'          => $code,
            ]
        ]);
        dd($request->getBody()->getContents());
    }
}
