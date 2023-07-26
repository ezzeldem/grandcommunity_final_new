<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('front.layouts.includes.head')
</head>
<body dir="{{(app()->getLocale()=="ar"?'rtl':"ltr")}}">
    <!-- class for app => page_container -->

<div class="page_container" id="app">
    @yield('content')
</div>
<script src="{{asset('front/js/jquery-3.js')}}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
@stack('js')
</body>
</html>
