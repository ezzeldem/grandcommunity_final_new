<!-- breadcrumb -->
<div class="breadcrumb-header mb-6 mt-4">
  <div class="row" style="width :100%">
    <div class="col-12 mb-6  mb-4" style="color: #ac862c;">
      <h2 class="tx-24 mg-b-1 mg-b-lg-1"> {{-- <i class="fas fa-paperclip"></i> --}} {{$title}} Page</h2>
      @if($title == 'Settings' || $title == 'Statistics' || $title == 'Home Control')
      <p class="mg-b-0" style="font-size: 18px;color:#fff">This {!! $title !!} You can edit elements on this page</p>
      @elseif($title == 'Brand Details')
      <p class="mg-b-0" style="font-size: 18px;color:#fff">You can see the brand's details here</p>
      @elseif($title == 'Influencer Social')
      <p class="mg-b-0" style="font-size: 18px;color:#fff">This {!! $title !!} You can see the influencer's Social Media
        data here</p>
      @else
      <p class="mg-b-0 " style="font-size: 18px;color:#fff">You can add, edit and delete elements on this page</p>
      @endif
    </div>
    <!-- <div class="col-12">
            @isset($statistics)
            <div class="app-actions mb-4">
                @foreach($statistics as $key => $statistic)
                <button id="{{isset($statistic['id'])?$statistic['id']:''}}" type="button" class="btn d-block" style="padding-top: 10px;min-width: 115px;
                            border: 2px solid #A27929;border-radius: 20px;">
                    @if(isset($statistic['icon']) && $statistic['icon'])
                    <span style="font-weight: bold;color: #fff !important;font-size: 17px !important;">{{$statistic['title']}}</span> <br>
                    <span style="color: #fff !important;font-size: 15px !important;" id="count_{{ $statistic['id'] ??  $key }}">{{$statistic['count']}}</span> <i class="{{$statistic['icon']}}" style="color: #AFAFAF;margin-left: 2px;"></i>
                    @endif
                </button>
                @endforeach
            </div>

            @endisset
        </div>  -->
  </div>








  <!----end--------------------->
  @isset($statistics)
  <div class="row gutters">
    @foreach($statistics as $key => $statistic)
    <a class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 status_influencer_statistic" @isset($statistic['value'])
      value="{{$statistic['value']}}" @endisset>
      <div class="info-stats2  card">
        <h4>{{$statistic['count']}}</h4>
        <h6>{{$statistic['title']}}</h6>
      </div>
    </a>
    @endforeach
  </div>
  <!-- Row end -->
  <!-- start statistics-box -->
  <div class="row pt-4 pb-4 mb-4">
    <div class="col-md-3">
      <div class="grand-statistics-box">
        <h3 class="number">20</h3>
        <h3 class="title"><span>Visit Campaigns </span></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="grand-statistics-box">
        <h3 class="number">20</h3>
        <h3 class="title"><span>Delivery Campaign </span></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="grand-statistics-box">
        <h3 class="number">20</h3>
        <h3 class="title"><span>Mix Campaign</span></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="grand-statistics-box">
        <h3 class="number">20</h3>
        <h3 class="title"><span>Post
            Campaign</span></h3>
      </div>
    </div>
  </div>


  <div class="gran-date-tag">
    Today
  </div>
  <div class="gran-date-tag last">
    Last Month
  </div>

  <!-- end statistics-box -->

  @endisset


</div>

@include('admin.dashboard.layouts.includes.filter_section')

<!-- /breadcrumb -->
