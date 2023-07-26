<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta name="robots" content="noarchive">
<meta property="og:type" content="article" />


<link rel="icon" href="{{getLogoImage()}}" type="image/x-icon"/>
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="{{asset('/front/css/all.min.css')}}" id="style-all"/>
<link rel="stylesheet" href="{{asset('/front/css/normalize.css')}}" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/full-screen-helper.css') }}">




@if(app()->getLocale() == 'en')
<meta name="keywords" content="Grand Community" />
@else
    <meta name="keywords" content="جراند كومينيتي" />
@endif

@if(count(\request('returnTag')) > 0)
    @foreach(\request('returnTag') as $key=>$meta)
        @if($key == 'title')
            <title>{{$meta}}</title>
        @else
            @foreach($meta as $m)
                <meta @if(isset($m['property'])) property="{{$m['property']}}" @else name="{{$m['name']}}" @endif  content="{{$m['content']}}">
            @endforeach
        @endif
    @endforeach
@endif

<link rel="stylesheet" href="{{mix('css/app.css')}}" />

<!--
 @if(app()->getLocale() ==='ar')
    <link  rel="stylesheet" href="{{asset('/front/css/page-ar.css')}}" />
    <link  rel="stylesheet" href="{{asset('/front/css/Flow1-ar.css')}}" />
    @else
    <link rel="stylesheet" href="{{asset('/front/css/Flow1.css')}}" />
    <link  rel="stylesheet" href="{{asset('/front/css/page.css')}}" />
@endif -->




