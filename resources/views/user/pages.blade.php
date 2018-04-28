@extends('layouts.app')

@section('content')
    <!-- Basic Information
              ================================================= -->
    <div class="edit-profile-container">
        @if(session('data'))
            <div class="alert alert-{{session('data.status')}}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"
                                                                                     aria-hidden="true"></i></a>
                <strong style="text-transform: capitalize">{{session('data.status')}}
                    !</strong><br>{{session('data.msg')}}
            </div>
        @endif
        <div class="block-title">
            <h4 class="grey"><i class="fas fa-file-alt"></i> My Pages</h4>
            <div class="line"></div>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate</p>
            <div class="line"></div>
        </div>
        <div class="edit-block">
            {{--{{ dd($pages) }}--}}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Preview</th>
                    <th>Type</th>
                    <th>PPC</th>
                    <th>Daily Clicks</th>
                    <th>Max Clicks</th>
                    <th>Active</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody style="vertical-align: middle">
                @foreach($pages as $page)
                    <tr>
                        <td class="valign">
                            @if (in_array($page->type, ['fb_photo_like','fb_photo_share']))
                                <a href="{{ $page->url }}" target="_blank"><img src="{{ $page->img }}" alt=""
                                                                                style="height: 50px; width: 50px; border-radius: 50%"></a>
                            @else
                                {{ $page->img }}
                            @endif
                        </td>
                        <td class="valign">{{ \App\Http\Helper::getPageType($page->type) }}</td>
                        <td class="valign"><strong>{{ $page->ppc }}</strong></td>
                        <td class="valign">{{ isset($page->daily_clicks) ? $page->daily_clicks : '-' }}</td>
                        <td class="valign">{{ isset($page->max_clicks) ? $page->max_clicks : '-' }}</td>
                        <td class="valign">
                            <!-- Rounded switch -->
                            <label class="toggleStatus">
                                <input type="checkbox"
                                       data-page-id="{{ $page->id }}" {{ $page->trash == 1 ? '' : 'checked' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        {{--<td class="text-center">{!! $page->trash == 0 ? '<i class="fas fa-toggle-on fa-2x" style="color: green"></i>' : '<i class="fas fa-toggle-off fa-2x"></i>' !!}</td>--}}
                        <td class="valign">
                            <form action="{{ route('page.moveToTrash') }}" method="GET">
                                <input type="hidden" name="id" value="{{ $page->id }}">
                                <button type="submit" class="btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
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
            $('.toggleStatus input').click(function () {
                var id = $(this).attr('data-page-id');
                $.get('./pages/toggleStatus', {page_id: id})
            });
        })
    </script>
@endsection
