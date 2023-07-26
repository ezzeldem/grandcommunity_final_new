@extends('admin.dashboard.layouts.app')
@section('title','Influencer Social Media')
@section('style')
@include('admin.dashboard.layouts.includes.general.styles.index')
<style>
.padding {
  padding: 3rem !important;
}

.card-img-top {
  height: 200px
}

.card-no-border .card {
  border-color: #d7dfe3;
  border-radius: 4px;
  margin-bottom: 30px;
  -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05)
}

.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  padding: 1.25rem
}

.pro-img {
  margin-bottom: 20px
}

.little-profile .pro-img img {
  width: 128px;
  height: 128px;
  -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  border-radius: 100%;
  margin: auto;
}

html body .m-b-0 {
  margin-bottom: 0px
}

h3 {
  line-height: 30px;
  font-size: 21px
}

.btn-rounded.btn-md {
  padding: 12px 35px;
  font-size: 16px
}

html body .m-t-10 {
  margin-top: 10px
}

.btn-primary,
.btn-primary.disabled {
  background: #7460ee;
  border: 1px solid #7460ee;
  -webkit-box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
  box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
  -webkit-transition: 0.2s ease-in;
  -o-transition: 0.2s ease-in;
  transition: 0.2s ease-in
}

.btn-rounded {
  border-radius: 60px;
  padding: 7px 18px
}

.m-t-20 {
  margin-top: 20px
}

.text-center {
  text-align: center !important
}

.btn-group,
.btn-group-vertical {
  display: flex !important;
  margin-bottom: 10px !important;
  width: fit-content !important;
}

.card-title i {
  display: inline-block;
  background: #0b1426;
  color: #fff;
  padding: 9px 11px 9px 11px;
  border-radius: 2px;
}

.nav_center {
  justify-content: center;
}

.nav_main li {
  /* border-right: 1px solid #9ca6b9 !important; */
}

.nav_main li:last-child {
  border-right: none !important;
}

.nav-pills .nav-link.active {
  background-color: transparent !important;
  color: #000 !important;
  font-weight: bold !important;
}

.tab-content .count {
  background: #e7ebf5;
  min-height: 143px;
  border-radius: 4px;
  border: 1px solid #bed4ff;
  margin-top: 20px;
  margin-bottom: 20px;
}

.tab-content .count span {
  display: block;
  background: #0b1426;
  color: #fff;
  padding: 8px 0px 8px 0px;
  font-size: 16px;
  margin: 3px;
  border-radius: 4px;
}

.tab-content .count h5 {
  margin-top: 33px;
  font-size: 26px;
}

.second_section {
  margin-top: 50px;
  margin-bottom: 50px;
}

.scrape_data .main_data img {
  width: 100px;
  height: 100px;
  border: 1px solid #9ca6b9;
  border-radius: 50%;
  padding: 2px;
  display: inline-block;
}

.scrape_data .main_data .parent_names span {
  display: block;
}

.scrape_data .main_data {
  display: flex;
  justify-content: flex-start;
  gap: 12px;
}

.scrape_data .main_data .parent_names {
  padding-top: 26px;
}

#brand_campaigns_table tbody tr .style_td_action {
  display: flex;
  flex-direction: column;
}

.loader {
  background: white;
  width: 101%;
  height: 101%;
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 100;
  text-align: center;
  transform: translate(-50%, -50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.loader-wheel {
  animation: spin 1s infinite linear;
  border: 2px solid rgba(30, 30, 30, 0.5);
  border-left: 4px solid #030303;
  border-radius: 50%;
  height: 100px;
  margin-bottom: 10px;
  width: 100px;
}

.loader-text {
  color: #030303;
  font-family: arial, sans-serif;
  font-weight: bold;
  font-size: 20px;
}

.loader-text:after {
  content: 'Loading';
  animation: load 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

.card {
  /* border: 1px dashed #d0d5dd !important; */
}

@keyframes load {
  0% {
    content: 'Loading';
  }

  33% {
    content: 'Loading.';
  }

  67% {
    content: 'Loading..';
  }

  100% {
    content: 'Loading...';
  }
}

#tiktok_h5_header,
#insta_h5_header,
#snap_h5_header {
  text-align: center;
  background: var(--body-bg-color);
  min-width: 50px;
  max-width: 250px;
  margin: auto;
  margin-bottom: 35px;
  margin-top: 35px;
  padding: 15px 5px 15px 5px;
  color: #fff;
  border-radius: 4px;
}

</style>

@endsection

@section('page-header')
<!-- breadcrumb -->
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Influencer Social Media'])
<!-- /breadcrumb -->
@stop

@section('content')


<!-- <div class="row row-sm">
  <input type="hidden" id="influ_id" value="{{$influencer->id}}">
  <div class="col-xl-12">
    <div class="card mg-b-20">
      <div class="card-header pb-0">
        <ul class="nav nav_center nav_main nav-pills mb-3 list-social-scrap" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-view-tab" data-toggle="pill" href="#pills-view" role="tab"
              aria-controls="pills-view" aria-selected="true">Overview</a>
          </li>
          @if($influencer->insta_uname && !empty($instagramData))
          <li class="nav-item">
            <a class="nav-link " id="pills-insta-tab" data-toggle="pill" href="#pills-instagram" role="tab"
              aria-controls="pills-overview" aria-selected="true">Instagram</a>
          </li>
          @endif
          @if($influencer->snapchat_uname && !empty($snapchatData))
          <li class="nav-item">
            <a class="nav-link" id="pills-snapchat-tab" data-toggle="pill" href="#pills-snapchat" role="tab"
              aria-controls="pills-branches" aria-selected="false">Snapchat</a>
          </li>
          @endif
          @if($influencer->tiktok_uname && !empty($tiktokdata))

          <li class="nav-item">
            <a class="nav-link" id="pills-tiktok-tab" data-toggle="pill" href="#pills-tiktok" role="tab"
              aria-controls="pills-subbrand" aria-selected="false">Tiktok</a>
          </li>
          @endif

          {{-- <li class="nav-item">--}}
          {{-- <a class="nav-link" id="pills-camps-tab" data-toggle="pill" href="#pills-twitter" role="tab" aria-controls="pills-camps" aria-selected="true">Twitter</a>--}}
          {{-- </li>--}}
          {{-- <li class="nav-item">--}}
          {{-- <a class="nav-link" id="pills-influs-tab" data-toggle="pill" href="#pills-facebook" role="tab" aria-controls="pills-influs" aria-selected="false">Facebook</a>--}}
          {{-- </li>--}}
        </ul>


        <div class="card-body">



          <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active text-center" id="pills-view" role="tabpanel"
              aria-labelledby="pills-vie-tab">
              <input type="hidden" id="instagram_uname" value="{{$influencer->insta_uname}}" />
              <input type="hidden" id="instagram_follwers" value="{{@$instagramData->followers}}" />
              @include('admin.dashboard.influencers.social_scrape.view')
            </div>

            @if(!empty($influencer->insta_uname && !empty($instagramData)))
            <div class="tab-pane fade show  text-center" id="pills-instagram" role="tabpanel"
              aria-labelledby="pills-overview-tab">
              @include('admin.dashboard.influencers.social_scrape.instagram')
            </div>
            @endif

            @if(!empty($influencer->snapchat_uname && !empty($snapchatData)))
            <div class="tab-pane fade" id="pills-snapchat" role="tabpanel" aria-labelledby="pills-branches-tab">
              @include('admin.dashboard.influencers.social_scrape.snapchat')
            </div>
            @endif

            @if(!empty($influencer->tiktok_uname && !empty($tiktokdata)))
            <div class="tab-pane fade" id="pills-tiktok" role="tabpanel" aria-labelledby="pills-subbrand-tab">
              @include('admin.dashboard.influencers.social_scrape.tiktok')
            </div>
            @endif

            {{-- <div class="tab-pane fade" id="pills-twitter" role="tabpanel" aria-labelledby="pills-influs-tab">--}}
            {{-- <h2 class="text-center">Twitter</h2>--}}
            {{-- </div>--}}

            {{-- <div class="tab-pane fade" id="pills-facebook" role="tabpanel" aria-labelledby="pills-influs-tab">--}}
            {{-- <h2 class="text-center">Facebook</h2>--}}
            {{-- </div>--}}


          </div>


        </div>

      </div>
    </div>
  </div>
</div> -->

@endsection
@section('js')
@include('admin.dashboard.layouts.includes.general.scripts.index')

<script>
$(document).on('click', '.acceptRow', function() {
  $('#expre_date_err').hide();
  $('#expre_date_err').text('')
  let id = $(this).data('id');
  let data_flag = $(this).data('flag');
  $('#add_expiration_date').modal('show')
  $(document).on('click', '#active_user', function() {
    swalAccept(id, data_flag);
  });
});
//inaccept row
$(document).on('click', '.InAcceptRow', function() {

  let id = $(this).data('id');
  let data_flag = $(this).data('flag');
  swalAccept(id, data_flag);
});

//reject Row
$(document).on('click', '.rejectRow', function() {
  let id = $(this).data('id');
  let data_flag = $(this).data('flag');
  swalAccept(id, data_flag);
});

function swalAccept(id, data_flag) {
  console.log(data_flag);
  let accetp_swal = Swal.fire({
    title: "Are you sure you want to " + data_flag + "?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: data_flag,
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    closeOnCancel: false
  }).then(function(result) {
    if (result.isConfirmed) {
      let expire_date = ($('#expire_date_input').val() != '' && $('#expire_date_input').val() != null) ? $(
        '#expire_date_input').val() : -1;
      $.ajax({
        url: `/dashboard/influencer-accept/${id}`,
        type: 'post',
        data: {
          expire_date,
          data_flag
        },
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
          if (data.status) {
            // $('.acceptRow').attr("disabled", 'disabled');
            $('.fa-circle').addClass('active')
            $('.fa-circle').attr('title', 'Active')
            $('.fa-circle').attr('data-original-title', 'Active')
            $('#add_expiration_date').modal('hide')
            $('#expire_date_input').val('')
            Swal.fire("accepted!", data.message, "success");
            location.reload();
          } else {
            Swal.fire.close();
            let err = data.message.expirations_date[0];
            $('#expre_date_err').show();
            $('#expre_date_err').text(err)
          }
        },
        error: (data) => {
          // console.log(data);
        }
      })
    } else {
      $('#add_expiration_date').modal('hide')
      $('#expire_date_input').val('')
      Swal.fire("Cancelled", "canceled successfully!", "error");
    }
  })
}
</script>
@endsection
