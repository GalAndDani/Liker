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
            <h4 class="grey"><i class="fas fa-users"></i> My Referrals</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Joined At</th>
                    <th>Verify</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ref as $key => $person)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ ucfirst($person->first_name) . ' ' . ucfirst($person->last_name) }}</td>
                        <td>{{ $person->created_at }}</td>
                        <td>{!! $person->verified == 1 ? '<i class="fas fa-check fa-2x" style="color: green"></i>' : '<i class="far fa-clock fa-2x"></i>' !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
@endsection
