@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-3">
            <button class="btn btn-success btn-lg" style="display: block; width: 100%; margin-bottom: 10px">ADD NEW POST</button>
            <button class="btn btn-success btn-lg" style="display: block; width: 100%; margin-bottom: 10px">MY POSTS</button>
            <div class="panel panel-default">
                <div class="panel-heading">Facebook</div>
                <div class="panel-body">
                    <li><a href="#">Facebook Likes</a></li>
                    <li><a href="#">Facebook Followers</a></li>
                    <li><a href="#">Facebook Views</a></li>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Instagram</div>
                <div class="panel-body">
                    <li><a href="#">Instagram Likes</a></li>
                    <li><a href="#">Instagram Followers</a></li>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Youtube</div>
                <div class="panel-body">
                    <li><a href="#">Youtube Likes</a></li>
                    <li><a href="#">Youtube Followers</a></li>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
