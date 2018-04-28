@extends('layouts.app')

@section('content')
    <!-- Basic Information
              ================================================= -->
    <div class="edit-profile-container">
        @if(session('data'))
            <div class="alert alert-{{session('data.status')}}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"
                                                                                     aria-hidden="true"></i></a>
                <strong style="text-transform: capitalize">{{session('data.status')}}!</strong><br>{{session('data.msg')}}
            </div>
        @endif
        <div class="block-title">
            <h4 class="grey"><i class="fas fa-plus-square"></i> Add New Page</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block">
            <div class="load"></div>
            <form action="{{ route('page.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group col-sm-6 col-xs-12 {{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="type">Page Type</label>
                    <div class="col-10">
                        <select class="custom-select form-control" name="type">
                            <option selected disabled>Choose Page Type</option>
                            <option value="fb_photo_like">Facebook Photo Like</option>
                            <option value="fb_photo_share">Facebook Photo Share</option>
                            <option value="fb_post_like">Facebook Post Like</option>
                            <option value="fb_post_share">Facebook Post Share</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12 {{ $errors->has('url') ? ' has-error' : '' }}">
                    <label for="url">Choose <span id="type"></span></label>
                    <div class="col-6">
                        <span class="btn btn-info" style="width: 100%" id="openModal" disabled>Browse</span>
                        <input class="form-control" name="url" type="hidden">
                        <input class="form-control" name="img" type="hidden">
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12 {{ $errors->has('ppc') ? ' has-error' : '' }}">
                    <label for="cpa">PPC
                        <small>(Points Per Click)</small>
                    </label>
                    <div class="col-6">
                        <input class="form-control" type="number" min="5" max="30" name="ppc">
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12 {{ $errors->has('max_clicks') ? ' has-error' : '' }}">
                    <label for="max_clicks">Max Clicks</label>
                    <div class="col-6">
                        <input class="form-control" type="number" min="0" name="max_clicks">
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12 {{ $errors->has('daily_clicks') ? ' has-error' : '' }}">
                    <label for="daily_clicks">Daily Clicks</label>
                    <div class="col-6">
                        <input class="form-control" type="number" min="0" name="daily_clicks">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <button type="submit"
                            class="btn btn-primary" {!! isset(Auth::user()->fb_user_token) ? '' : 'style="background: #df541e; font-weight: normal" disabled' !!}>{{ isset(Auth::user()->fb_user_token) ? 'Add New Page' : 'You need to resigter facebook on dashboard' }}</button>
                </div>
                <div class="form-group col-sm-12">
                    <label for="daily_clicks">Image Preview</label>
                    <div class="col-6">
                        <img src="" alt="" class="img-prev">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div id="Modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose</h4>
                </div>
                <div class="modal-body">
                    <div id="response"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-heading">Add New Page</div>--}}
    {{--<div class="panel-body">--}}
    {{--<form action="{{ route('page.store') }}" method="POST">--}}
    {{--{{ csrf_field() }}--}}
    {{--<div class="form-group row">--}}
    {{--<label for="type" >Page Type</label>--}}
    {{--<div class="col-10">--}}
    {{--<select class="custom-select form-control-static" name="type">--}}
    {{--<option selected disabled>Choose Page Type</option>--}}
    {{--<option value="facebook_likes">Facebook Like</option>--}}
    {{--<option value="facebook_share">Facebook Share</option>--}}
    {{--</select>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row">--}}
    {{--<label for="url" >Url</label>--}}
    {{--<div class="col-6">--}}
    {{--<input class="form-control" name="url" type="url">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row">--}}
    {{--<label for="cpa" >PPC<br>--}}
    {{--<small>(Points Per Click)</small>--}}
    {{--</label>--}}
    {{--<div class="col-6">--}}
    {{--<input class="form-control" type="number" min="5" max="30" name="ppc">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row">--}}
    {{--<label for="max_clicks" >Max Clicks</label>--}}
    {{--<div class="col-6">--}}
    {{--<input class="form-control" type="number" min="0" name="max_clicks">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group row">--}}
    {{--<label for="daily_clicks" >Daily Clicks</label>--}}
    {{--<div class="col-6">--}}
    {{--<input class="form-control" type="number" min="0" name="daily_clicks">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<div class="offset-2 col-6">--}}
    {{--<button type="submit" class="btn btn-primary">Add New Page</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection

@section('js')
    <script src="{{ asset('js/user/add-page.js') }}"></script>
@endsection