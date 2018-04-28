<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\FacebookApi;
use App\Page;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('activation');
    }

    public function addNewPost()
    {
        return view('user.add');
    }

    public function show()
    {
        $pages = Page::where('user_id', Auth::user()->id)->get();
        return view('user.pages')->with([
            'pages' => $pages
        ]);
    }

    public function referral()
    {
        $ref = User::where('ref_user_id', Auth::user()->ref_id)->get();
        return view('user.referral')->with([
            'ref' => $ref
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'url'  => 'required',
            'ppc'  => 'required'
        ]);

        try {
            Page::create([
                'user_id'      => Auth::user()->id,
                'fb_user_id'   => Auth::user()->fb_user_id,
                'type'         => $request->get('type'),
                'url'          => $request->get('url'),
                'img'          => $request->get('img'),
                'ppc'          => $request->get('ppc'),
                'daily_clicks' => $request->get('daily_clicks'),
                'max_clicks'   => $request->get('max_clicks'),
            ]);

            return redirect()->back()->with('data', [
                'status' => 'success',
                'msg'    => 'Page Added Successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('data', [
                'status' => 'danger',
                'msg'    => $e
            ]);
        }
    }

    public function profile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('user.profile')->with([
            'user' => $user
        ]);
    }

    public function profile_edit(Request $request)
    {
        $request->validate([
            'first_name'            => 'required',
            'last_name'             => 'required',
            'country'               => 'required',
            'password'              => 'nullable|min:6',
            'password_confirmation' => 'nullable|required_with:password|same:password|min:6'
        ]);

        try {
            $user = User::where('id', Auth::user()->id)->first();
            $user->fill([
                'first_name' => $request->get('first_name'),
                'last_name'  => $request->get('last_name'),
                'country'    => $request->get('country'),
            ]);

            if ($request->get('password')) {
                $user->fill([
                    'password' => Hash::make($request->get('password'))
                ]);
            }

            $user->save();

            return redirect()->back()->with('data', [
                'status' => 'success',
                'msg'    => 'Profile Saved Successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('data', [
                'status' => 'danger',
                'msg'    => $e
            ]);
        }
    }

    public function toggleStatus(Request $request)
    {
        $id = $request->get('page_id');
        $page = Page::where('id', $id)->first();
        if ($page->trash) {
            $page->trash = 0;
        } else {
            $page->trash = 1;
        }
        $page->save();
    }

    public function moveToTrash(Request $request) {
        $id = $request->id;
        Page::where('id', $id)->delete();

        return redirect()->back()->with('data', [
            'status' => 'success',
            'msg'    => 'Page removed successfully!'
        ]);
    }
}
