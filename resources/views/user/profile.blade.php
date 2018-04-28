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
            <h4 class="grey"><i class="fas fa-user"></i> My Profile</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block">
            <form action="{{ route('page.profile.edit') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="url">First Name</label>
                    <div class="col-6">
                        <input class="form-control" name="first_name" type="text" value="{{ $user->first_name }}">
                        @if ($errors->has('first_name'))
                            <div class="error">{{ $errors->first('first_name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="url">Last Name</label>
                    <div class="col-6">
                        <input class="form-control" name="last_name" type="text" value="{{ $user->last_name }}">
                        @if ($errors->has('last_name'))
                            <div class="error">{{ $errors->first('last_name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="url">New Password</label>
                    <div class="col-6">
                        <input class="form-control" name="password" type="password">
                        @if ($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="url">Confirm Password</label>
                    <div class="col-6">
                        <input class="form-control" name="password_confirmation" type="password">
                        @if ($errors->has('password_confirmation'))
                            <div class="error">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="url">Email</label>
                    <div class="col-6">
                        <input class="form-control" name="email" type="text" disabled  value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="url">Country</label>
                    <div class="col-6">
                        <input class="form-control" name="country" type="text"  value="{{ $user->country }}">
                        @if ($errors->has('country'))
                            <div class="error">{{ $errors->first('country') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-primary">Save Profile</button>
                </div>
            </form>
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
