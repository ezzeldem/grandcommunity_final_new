<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            @if(Request::segment(2) == '')
                <h4 class="content-title mb-0 mr-2 my-auto">Dashboard</h4>
            @endif
            <div class="mr-auto text-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                        @isset($routes)
                            @foreach($routes as $route)
                                <li class="breadcrumb-item"><a href="{{$route['route']}}">{{$route['name']}}</a></li>
                            @endforeach
                        @endisset
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /breadcrumb -->
<!-- Page header start -->
<div class="page-header">

    <!-- Breadcrumb start -->
    <ol class="breadcrumb">
            @isset($routes)
                @foreach($routes as $route)
                    @if(!is_null($route['name']) && Request::segment(2) == $route)
                    {{--  <li class="breadcrumb-item"><a href="{{$route['route']}}">{{$route['name']}}</a></li>  --}}
                    <li class="breadcrumb-item">{{$route['name']}}</li>
                    @endif
                @endforeach
            @endisset
    </ol>
    <!-- Breadcrumb end -->

{{--    <!-- App actions start -->--}}
{{--    <div class="app-actions">--}}
{{--        <button type="button" class="btn">Today</button>--}}
{{--        <button type="button" class="btn">Yesterday</button>--}}
{{--        <button type="button" class="btn">7 days</button>--}}
{{--        <button type="button" class="btn">15 days</button>--}}
{{--        <button type="button" class="btn active">30 days</button>--}}
{{--    </div>--}}
{{--    <!-- App actions end -->--}}

</div>
<!-- Page header end -->



