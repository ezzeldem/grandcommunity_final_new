<!-- <p> {{$influencer->name}}<p> -->

<head>
    <meta charset="UTF-8">
	<meta property="og:description" content="you can find here your account information and your qrcode">
     <meta property="og:title" content="Grand Community, influencer profile">
     <meta property="og:image" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/brand/logo.png')}}">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>{{ $influencer->name }} | Grand community</title>
</head>
<style>
    body {
        background-color: #0c0c0c;
        font-family: Roboto, sans-serif;
        margin: 0rem;
        padding: 0rem;
        box-sizing: border-box;
    }

    .degital-card {
        padding: 0rem 1rem;
    }

    .navbar {
        background: #121212;
        padding: 1rem 0rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a8822c;
        text-transform: uppercase;
        font-weight: 500;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
        position: sticky;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1;
        width: 100%;

    }

    .navbar .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row-reverse;
    }

    .navbar .logo-container img {
        max-width: 60px;
        max-height: 50px;
    }

    .navbar .logo-container .navbar-brand {
        text-transform: uppercase;
        font-size: 1.6rem;
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .navbar .logo-container .navbar-brand {
            font-size: 0.9rem;
        }
    }

    .container {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 97vh;
        margin-top: 2rem;
    }

    .user-card {
        color: #fff;
        background: #121212;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
        padding: 1rem;
        border-radius: 5px;
        width: 100%;
        max-width: 420px;
        position: relative;
    }

    .user-card .badge {
        position: absolute;
        width: fit-content;
        background: #a8822c;
        padding: 3px 10px;
        top: 5px;
        right: 5px;
        border-radius: 4px;
        text-transform: uppercase;
        font-size: 15px;
        font-weight: 600;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
    }

    .user-card .user-info {
        text-align: center;
    }

    .user-card .user-info .user-img {
        position: relative;
        width: fit-content;
        margin: 1rem auto;
    }

    .user-card .user-info .user {
        width: 100%;
        max-width: 120px;
        background: #fff;
        border-radius: 50%;
        padding: 2px;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;

    }

    .user-card .user-info .user-country {
        position: absolute;
        width: 30px;
        background: #fff;
        border-radius: 50%;
        padding: 2px;
        bottom: 0;
        right: 0;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;

    }

    .user-card .user-info .user-country img {
        width: 100%;
        height: 100%;
    }

    .user-card .user-info .user-text .name {
        margin-bottom: 0.5rem;
    }

    .user-card .user-info .user-text .location {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        gap: 7px;
        opacity: 0.6;
    }

    .user-card .user-info .user-text i {
        font-size: 20px;
        color: #fff;
    }

    .user-card .user-info .user-text i {
        font-size: 20px;
        color: #fff;
    }

    .user-card .user-info .user-text .rate {
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .user-card .user-info .user-text .rate i {
        font-size: 16px;
        color: #967429;
        padding: 7px 5px;
    }

    .user-card .user-info .social-info {
        overflow-y: hidden;
        overflow-x: scroll;
        position: relative;
    }

    .user-card .user-info .social-info .wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 100%;
        width: 100%;
        padding: 10px 0px;
        min-width: 300px;
    }

    .user-card .user-info .social-info .wrapper .social-item {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.3rem;
        gap: 6px;
    }

    .user-card .user-info .social-info .wrapper .social-item .count {
        font-size: 16px;
    }


    .user-card .center {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 1rem;
    }

    .user-card input {
        background: transparent;
        color: #fff;
        outline: none;
        border: 1px solid #fff;
        border-radius: 4px;
        padding: 7px 5px;
        font-size: 15px;
        max-width: 78px;
    }

    .user-card .center button {
        background: #a8822c;
        color: #fff;
        font-size: 18px;
        height: 100%;
        padding: 6px 10px;
        border-radius: 5px;
        outline: none;
        cursor: pointer;
    }

    .user-card .aqcodeContainer {
        text-align: center;
    }

    .user-card .aqcodeContainer .scanner {
        width: fit-content;
        margin: auto;
        display: block;
        border: 2px solid;
        color: #967429;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
    }

    .user-card .aqcodeContainer .scanner img {
        width: 100%;
        max-width: 270px;
        height: 100%;
        display: block;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 0px;
        height: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        width: 3px;
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        width: 3px;
        background: #a8822c;
        border-radius: 10px;
    }
</style>

<section class="degital-card">
    <nav class="navbar">
        <div class="logo-container">
            <span class="navbar-brand mb-0 h1">grand community</span>
            <img src="{{asset('assets/img/brand/logo.png')}}" alt="grand community">
        </div>
    </nav>

    <div class="container">
        <div class="card user-card">
            <!-- if user is vip  -->
            <!-- <div class="badge">
                vip
            </div> -->
            <!-- if user is vip  -->

            <div class="user-info">
                <div class="user-img">
                    <img class="user" src="{{ isset($influencer->instagram) ? $influencer->instagram->insta_image : $influencer->image  }}" alt="{{ $influencer->insta_uname }}">
                    
					@if(isset($influencer->nationalityRelation) && !empty($influencer->nationalityRelation))
					<div class="user-country">
                        <img src="{{ "https://hatscripts.github.io/circle-flags/flags/".\Str::lower($influencer->nationalityRelation->code).'.svg' }}" alt="{{ $influencer->insta_uname }}">
                    </div>
					@endif
                </div>
                <div class="user-text">
                    <h3 class="name">
                        {{$influencer->insta_uname}}
                    </h3>
                    <div class="location">
                        <i class="fa fa-map-marker"></i>
                        {{$influencer->country->name}}
                    </div>
                    <!-- <div class="rate" onclick="getRate(3)">
                        <i class="fa fa-star"></i>
                    </div> -->
                </div>
                <div class="social-info">
                    <div class="wrapper">

					@foreach($influencer->SocialMedia() as $soail_media)
                        <div class="social-item">
                            <div class="icon">
                                <i class="fa fa-{{$soail_media->icon}}"></i>
                            </div>
                            <div class="count">
							{{kmb($soail_media->followers)}}
                            </div>
                        </div>
					@endforeach	
                    </div>
                </div>
            </div>
            <div class="center" >
                <input type="text" id="copy_text" readonly   value="{{$influencer->influ_code}}">
                <button>
                    <i class="fa fa-copy"></i>
                    <span onclick="copyToClipboard()">
                        Copy
                    </span>
                </button>
            </div>
            <div class="aqcodeContainer">
                <h2 class="title">
                    QR Code
                </h2>
                <dev class="scanner">

				<a title="{{$influencer->insta_uname}}" id="qrcode" download="{{$influencer->insta_uname}}.png" href="{{ $influencer->qrcode  }}">
                       <img src="{{ $influencer->qrcode  }}" alt="{{$influencer->insta_uname}}">
                  </a>
                </dev>
            </div>
        </div>

    </div>
</section>
<script>
    let getRate = (rate) => {
        if (!rate) {
            return
        }
        let intrate = parseInt(rate);

        let rateArr = [];

        for (let i = 0; i < 5; i++) {
            if (intrate > 0) {
                rateArr.push('fa fa-star');
                intrate--;
            }
        }
        return rateArr;
    }

	let copyToClipboard = ()=> {
		var textBox = document.getElementById("copy_text");
		textBox.select();
		document.execCommand("copy");
	}
</script>
