@extends('layouts.app')

@section('content')
    <div class="edit-profile-container">
        <div class="block-title">
            <h4 class="grey"><i class="fas fa-home"></i> Welcome, {{ ucfirst(\Illuminate\Support\Facades\Auth::user()->first_name) }}</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block">
            {!! $fb_access !!}
            {!! $insta_access !!}
            <br><br>
            {{ isset($insta_code) ? $insta_code : '' }}
            <br>
            <pre>{{ print_r($_SESSION, TRUE) }}</pre>
        </div>
    </div>
@endsection
