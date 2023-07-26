@extends('admin.dashboard.layouts.app')
@section('title','User Data')
@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <link href="{{asset('css/campaign.css')}}" rel="stylesheet">
    <style>
        [data-toggle="collapse"] .fa:before {
            content: "\f139";
        }

        [data-toggle="collapse"].collapsed .fa:before {
            content: "\f13a";
        }

    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome back!</h2>
                <p class="mg-b-0">@yield('title')</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@stop

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                        <a href="{{route('dashboard.index')}}" class="btn btn-primary-gradient mt-2 mb-2 pb-2"><i class="fas fa-home"></i> home </a>
                    </div>

                </div>

                <div class="card-body">
                    <div class="top-content">
                        <div class="camp-top">
                            <div class="container user_data">
                                <div class="userImg_progress">

                                    @if($completedData->image)
                                        <img src="{{$completedData->image}}" class="img-thumbnail" alt="{{$user->user_name}} image">
                                    @else
                                        <img src="/assets/img/logo.png" alt="user Img">
                                    @endif
{{--                                    <div class="progress" style="width: 100%;">--}}
{{--                                        <div class="progress-bar" role="progressbar" style="width: 25%;height: 15px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>--}}
{{--                                      </div>--}}
                                </div>
                                <div class="camp-top-inner">
                                    <div class="userName_Opitions">
                                        <span class="name">Grand Community</span>
                                        <div class="opition">
                                            <a data-toggle="tooltip" data-placement="top" title="Back Home" href="{{route('dashboard.index')}}" class="back_btn">Back</a>
                                            @if($user->type == 1)
                                                <a data-toggle="tooltip" data-placement="top" title="Edit User" href="{{route('dashboard.influences.edit', $completedData->id)}}" class="edit_btn">Edit</a>
                                            @else
                                                <a data-toggle="tooltip" data-placement="top" title="Edit User" href="{{route('dashboard.brands.edit', $completedData->id)}}" class="edit_btn">Edit</a>
                                            @endif
                                            <button data-toggle="tooltip" data-placement="top" title="Active User" @if( !( ($user->type == 1 && $completedData->whats_number && $completedData->insta_uname &&$completedData->social_type ) || (($user->type == 0 && $completedData->whatsapp && $completedData->insta_uname ) ) )) disabled @endif class="btn btn-success mt-2 mb-2 acceptRow" id="accept-{{$user->id}}" data-id="{{$user->id}}" > Accept </button>
                                            <button data-toggle="tooltip" data-placement="top" title="Reject User" class="btn btn-warning mt-2 mb-2 forceRejectRow" id="accept-{{$user->id}}" data-id="{{$user->id}}" >Reject</button>
                                        </div>
                                    </div>
                                    <span class="spred"></span>
                                    <div class="campaign_details_parent">
                                        <div class="campaign_name campaign_details">
                                            <h6>Name : </h6>
                                            <span>{{$completedData->name}}</span>
                                        </div>
                                        <div class="campaign_name campaign_details">
                                            <h6>UserName : </h6>
                                            <span>{{$user->user_name}}</span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>type   : </h6>
                                            <span>{{$user->type?'influencer':'brand'}}</span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>email  : </h6>
                                            <span>{{$user->email}}</span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>phones   : </h6>
                                            <span>{{$user->code}}{{$user->phone}}
                                            @if($completedData->phone)
                                                @forelse($completedData->phone as $phone)
                                                       - {{$user->code}}{{ $phone }}
                                                @empty
                                                @endforelse
                                            @endif
                                            </span>
                                        </div>
                                        <div class="campaign_details">
                                            <h6>whatsapp   : </h6>
                                            <span>
                                            @if($user->type == 1)
                                                {{$completedData->whats_number}}
                                            @else
                                                {{$completedData->whatsapp}}
                                            @endif
                                            </span>
                                        </div>
                                        @if($user->type == 1)
                                            <div class=" campaign_details">
                                                <h6>Gender   : </h6>
                                                @if(isset($completedData->gender) && $completedData->gender == 0)
                                                    <span><i class="fa fa-female" aria-hidden="true"></i> Female</span>
                                                @elseif(isset($completedData->gender) && $completedData->gender == 1 )
                                                <span><i class="fa fa-male" aria-hidden="true"></i> male</span>
                                                @endif
                                            </div>
                                            <div class="campaign_details">
                                                <h6>Date Of Birth : </h6>
                                                @if($completedData->date_of_birth)
                                                    <span> {{ $completedData->date_of_birth }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class=" campaign_details">
                                            <h6>country   : </h6>
                                            @if($user->type == 1)
                                                <span>{{@$completedData->country->name}}</span>
                                            @else
                                                @if( $completedData->countries->count() > 0 )
                                                    <div>
                                                    @foreach($completedData->countries as $country)
                                                      <span>{{$country->name}}</span>
                                                    @endforeach
                                                    </div>
                                                @else
                                                    <span>No Countries....</span>
                                                @endif
                                            @endif

                                        </div>
                                        @if($user->type == 1)
                                        <div class=" campaign_details">
                                            <h6>state   : </h6>
                                            <span>{{@$completedData->state->name}}</span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>city   : </h6>
                                            <span>{{@$completedData->city->name}}</span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>nationality   : </h6>
                                            <span>{{@$completedData->nationalities->name}}</span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>Interested   : </h6>
                                            @if($completedData->interests->count() > 0)
                                            <div class="intressted">
                                                    @foreach($completedData->interests as $interest)
                                                        <span>{{ $interest->interest }}</span>
                                                    @endforeach
                                            </div>
                                            @else
                                                <span>No interests....</span>
                                            @endif
                                        </div>

                                        <div class=" campaign_details">
                                            <h6>Languages   : </h6>
                                            @if($completedData->languages)
                                                <div class="intressted">
                                                    @foreach($completedData->languages as $language)
                                                        <span>{{ $language->name }}</span>
                                                    @endforeach
                                                </div>
                                            @else

                                            @endif
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>Nationality   : </h6>
                                            @if($completedData->nationalities)
                                                <span>{{ @$completedData->nationalities->name }}</span>
                                            @endif
                                        </div>

                                        @endif
                                        <div class=" campaign_details">
                                            <h6>Address   : </h6>
                                            @if($completedData->address)
                                                 <span>{{$completedData->address}}</span>
                                            @else
                                                <span>No Address....</span>
                                            @endif
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>Website   : </h6>
                                            @if($completedData-> website_uname)
                                                <div>
                                                <a href="{{$completedData->website_uname}}" type="button" class="btn btn-info"><i class="fa fa-link" aria-hidden="true"></i> Website</a>
                                                </div>
                                           @endif
                                        </div>

                                        <div class=" campaign_details">
                                            <h6>social   : </h6>
                                            <div class="socail">
                                                @if($completedData->facebook_uname)
                                                <div>
                                                    <img src="/assets/img/facebook.png" alt="">
                                                    <a href="https://www.facebook.com/{{$completedData->facebook_uname}}">{{$completedData->facebook_uname}}</a>
                                                </div>
                                                @endif
                                                @if($completedData->snapchat_uname)
                                                <div>
                                                    <img src="/assets/img/snapchat.png" alt="">
                                                    <a href="https://accounts.snapchat.com/{{$completedData->snapchat_uname}}">{{$completedData->snapchat_uname}}</a>

                                                </div>
                                                @endif
                                                @if($completedData->insta_uname)
                                                <div>
                                                    <img src="/assets/img/instagram.png" alt="">
                                                    <a href="https://www.instagram.com/{{$completedData->insta_uname}}">{{$completedData->insta_uname}}</a>

                                                </div>
                                                @endif
                                                @if($completedData->tiktok_uname)
                                                <div>
                                                    <img src="/assets/img/tik-tok.png" alt="">
                                                    <a href="https://www.tiktok.com/{{$completedData->tiktok_uname}}">{{$completedData->tiktok_uname}}</a>
                                                </div>
                                                @endif
                                                @if($completedData->twitter_uname)
                                                    <div>
                                                        <img src="/assets/img/twitter.png" alt="">
                                                        <a href="https://twitter.com/{{$completedData->twitter_uname}}" class="link">{{$completedData->twitter_uname}}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>Complete profile   : </h6>
                                            <span>
                                                @if(($user->type == 1 && $completedData->whats_number && $completedData->insta_uname &&$completedData->social_type ) || (($user->type == 0 && $completedData->whatsapp && $completedData->insta_uname )))
                                                    <i class="fas fa-check yes"></i>
                                                @else
                                                    <i class="fas fa-times no"></i>
                                                @endif
                                            </span>
                                        </div>
                                        <div class=" campaign_details">
                                            <h6>Status   : </h6>
                                            <span style="cursor: pointer;">
                                               @php $status = ( $user->type == 1 ) ? 'active' : 'status' @endphp
                                               @if($completedData->$status == 0 )
                                                    <i data-toggle="tooltip" data-placement="top" title="Inactive"   class="fas fa-circle offline"></i>
                                               @elseif($completedData->$status == 1)
                                                    <i data-toggle="tooltip" data-placement="top" title="Active"  class="fas fa-circle active"></i>
                                               @elseif($completedData->$status == 2)
                                                    <i data-toggle="tooltip" data-placement="top" title="Pending"   class="fas fa-circle pending"></i>
                                               @elseif($completedData->$status == 3)
                                                    <i data-toggle="tooltip" data-placement="top" title="Reject"   class="fas fa-circle reject"></i>
                                               @endif
                                            </span>
                                        </div>

                                        @if($user->type == 1 && isset($completedData->social_type))
                                            <div class="container">
                                                <div id="accordion">
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    <i class="fa" aria-hidden="true"></i>
                                                                    social status
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                            <div class="card-body">
                                                                <article>
                                                                    <h6  style="text-align: center">Social Status : {{social_status($completedData->social_type)}}</h6>
                                                                    @if(!empty($completedData->children))
                                                                    <ol>
                                                                        @foreach($completedData->children as $children)
                                                                        <li class="mb-3">
                                                                            <h6>Children {{$loop->index + 1}} : </h6>
                                                                            <ul class="ml-3">
                                                                                <li><div>Name: {{$children['name']}} </div></li>
                                                                                <li><div>Gender: {{$children['gender']}}</div></li>
                                                                                <li><div>Date Of Birth: {{$children['DOB']}}</div></li>
                                                                            </ul>
                                                                        </li>
                                                                        @endforeach
                                                                    </ol>
                                                                    @endif
                                                                </article>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    @include('admin.dashboard.layouts.includes.general.models.expiration_date_model')
@stop

@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    @if(session()->has('successful_message'))
        <script>swal("Good job!", "{{session()->get('successful_message')}}", "success");</script>
    @elseif(session()->has('error_message'))
        <script>swal("Good job!", "{{session()->get('error_message')}}", "error");</script>
    @endif
    <script>
        $(document).ready(function (event) {
            $('[data-toggle="tooltip"]').tooltip()

            // accept row
            $(document).on('click','.acceptRow',function (){
                $('#expre_date_err').hide();
                $('#expre_date_err').text('')
                let id = $(this).data('id');
                $('#add_expiration_date').modal('show')
                $(document).on('click','#active_user',function (){
                    swalAccept(id);
                });
            });

            function swalAccept(id){
                let accetp_swal = swal({
                    title: "Are you sure to active this user?",
                    text: "You will not be able to retrieve this record",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: "No, cancel it!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },function(isConfirm){
                    if (isConfirm){
                        let expire_date = ($('#expire_date_input').val() != '' && $('#expire_date_input').val() != null) ? $('#expire_date_input').val() : -1;
                        $.ajax({
                            url:`/dashboard/users-accept/${id}/${expire_date}`,
                            type:'post',
                            data:{id},
                            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                            success:(data)=>{
                                if(data.status){
                                    $('.acceptRow').attr("disabled", 'disabled');
                                    $('.fa-circle').addClass('active')
                                    $('.fa-circle').attr('title', 'Active')
                                    $('.fa-circle').attr('data-original-title', 'Active')
                                    $('#add_expiration_date').modal('hide')
                                    $('#expire_date_input').val('')
                                    swal("accepted!",data.message, "success");
                                }else{
                                    swal.close();
                                    let err = data.message.expirations_date[0];
                                    $('#expre_date_err').show();
                                    $('#expre_date_err').text(err)
                                }
                            },
                            error:(data)=>{
                                // console.log(data);
                            }
                        })
                    } else {
                        $('#add_expiration_date').modal('hide')
                        $('#expire_date_input').val('')
                        swal("Cancelled", "canceled successfully!", "error");
                    }
                })
            }
            $(document).on('click','.forceRejectRow',function (){
                let id = $(this).data('id');
                swal_reject(id);
            });
            function swal_reject(id){
                swal({
                    title: "Are you sure to Reject this user?",
                    text: "You will not be able to retrieve this record",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: "No, cancel it!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },function(isConfirm){
                    if (isConfirm){
                        let reqUrl = `/dashboard/users-forcereject/${id}`;
                        $.ajax({
                            url:reqUrl,
                            type:'put',
                            data:{id},
                            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                            success:()=>{
                                window.location.href = "{{route('dashboard.index')}}"
                                swal("Done!", "Done Successfully!", "success");
                            },
                            error:()=>{
                                swal("error", "something went wrong please reload page", "error");
                            }
                        })
                    } else {
                        swal("Cancelled", "Canceled Successfully!", "error");
                    }
                })
            }

        })
    </script>
@endsection

