@extends('layouts.verification')
@section('content')
    <div class="edit-profile-container">
        <div class="block-title">
            <h4 class="grey"><i class="fas fa-home"></i> Registration</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block">
            <p>Your Email is successfully verified. Click here to <a href="{{url('/login')}}">login</a></p>
        </div>
    </div>
@endsection