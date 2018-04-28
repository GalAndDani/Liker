@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.14/components/card.min.css">
@endsection

@section('content')
    <div class="edit-profile-container">
        <div class="block-title">
            <h4 class="grey"><i class="fab fa-facebook"></i> Get Free Point From Facebook Shares</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block text-center">
            <div id="status" class="alert"></div>
            <div class="panel-body" id="posts">
                <i class="fas fa-circle-notch fa-5x fa-spin" id="loader"></i>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/facebook/photo/shares.js') }}"></script>
@endsection