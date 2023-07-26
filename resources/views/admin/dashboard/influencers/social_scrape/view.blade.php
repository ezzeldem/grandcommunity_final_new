<section style="background-color: var(--main-bg-color);">

<div class="">
    <div class="btns mb-3 infl-btns">
        <a data-toggle="tooltip" data-placement="top" title="Edit Influencer" href="{{route('dashboard.influences.edit', $influencer->id)}}" class="btn" style="background: #1e1e1e;color: #fff;"><i class="fa fa-edit"></i> Edit</a>
        @if($influencer->active == 2 || $influencer->active == 3 || $influencer->active == 0 || $influencer->active != 1)
            <button data-toggle="tooltip" data-placement="top" title="Active Influencer" @if(!($influencer->whats_number && $influencer->insta_uname)) disabled @endif data-flag="active" class="btn btn-success mt-2 mb-2 acceptRow" id="accept-{{$influencer->id}}" data-id="{{$influencer->id}}" ><i class="icon-toggle-right"></i> Active </button>
        @else
            <button data-toggle="tooltip" data-placement="top" title="Inactivate Influencer" class="btn mt-2 mb-2 InAcceptRow" data-flag="inactive" id="inactive-{{$influencer->id}}" data-id="{{$influencer->id}}"><i class="icon-toggle-left"></i> Inactivate </button>
        @endif
        <button data-toggle="tooltip" data-placement="top" title="Reject Influencer" class="btn mt-2 mb-2 rejectRow" style="background: #1e1e1e;color: #fff;" @if($influencer->active == 3) disabled @endif data-flag="reject" id="accept-{{$influencer->id}}" data-id="{{$influencer->id}}"><i class="fa fa-times-circle"></i> Reject</button>

    </div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-body text-center overview">
                    <img src="{{@$influencer->image}}" alt="avatar" class="rounded-circle img-fluid">
                    <h5 class="my-3">@ {{@$influencer->insta_uname}}</h5>
                    <p class=" mb-1">{{@$instagramData->bio}}</p>
                    <p class=" mb-4">{{@$influencer->country->name}}</p>
                    <hr>
                    <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="influencer_code_div" >
                                <i class="fas fa-globe fa-lg"></i>Code
                                <p class="mb-0" id="influ_code">{{@$influencer->influ_code}}</p>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center p-3"  id="influencer_qrcode_div" >
                                <i class="fas fa-qrcode fa-lg"></i>Qrcode
                                <a title="ImageName" id="qrcode" download="{{@$influencer->insta_uname}}.png" href="{{ $influencer->qrcode  }}">
                                    <img src="{{ $influencer->qrcode  }}" alt="ImageName">
                                </a>
                            </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <span class="btn" id="regenrate_qrcode"><i class="fas fa-qrcode"></i>Regenerate Qr Code</span>
                            <a href="{{$influencer_profile_url}}" id="digital_influencer_card" target="new" class="btn"><i class="fas fa-eye"></i></a>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mb-4 mb-lg-0">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-3 social-list">
                        @if($influencer->website_uname)
                            <li class="list-group-item p-3">
                                <i class="fas fa-globe fa-lg"></i>
                                <p class="mb-0" style="color: #fff">{{@$influencer->website_uname}}</p>
                            </li>
                        @endif
                        @if($influencer->tiktok_uname)
                            <li class="list-group-item p-3">
                                <i class="fab fa-tiktok fa-lg" ></i>
								<a target="_blank" style="color: #fff" href="{{"https://www.tiktok.com/".@$influencer->tiktok_uname}}" style="color: #fff" class="mb-0">@ {{@$influencer->tiktok_uname}}</a>
                            </li>
                        @endif
                        @if($influencer->twitter_uname)
                            <li class="list-group-item p-3">
                                <i class="fab fa-twitter fa-lg"></i>
                                <p class="mb-0" style="color: #fff" >{{@$influencer->twitter_uname}}</p>
                            </li>
                        @endif
                        @if($influencer->insta_uname)
                            <li class="list-group-item p-3">
                                <i class="fab fa-instagram fa-lg"></i>
                                <a target="_blank" style="color: #fff" href="{{"https://www.instagram.com/".@$influencer->insta_uname}}" style="color: #fff" class="mb-0">@ {{@$influencer->insta_uname}}</a>
                            </li>
                        @endif
                        @if($influencer->facebook_uname)
                            <li class="list-group-item p-3">
                                <i class="fab fa-facebook-f fa-lg"></i>
                                <p class="mb-0" style="color: #fff">{{@$influencer->facebook_uname}}</p>
                            </li>
                        @endif
                        @if($influencer->snapchat_uname)
                            <li class="list-group-item p-3">
                                <i class="fa-brands fa-snapchat fa-lg"></i>
                                <a style="color: #fff" href="{{"https://story.snapchat.com/@".@$influencer->snapchat_uname}}" style="color: #fff" target="_blank" class="mb-0">{{@$influencer->snapchat_uname}}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-body card-details-infl">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Full Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0 last-title">{{@$influencer->name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0 last-title">{{@$influencer->user->email}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm -3">
                            <p class="mb-0 first-title">Phone Number</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0 last-title">({{$influencer->user->code??"--"}}) {{$influencer->user->phone ?? "--"}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">WhatsApp Number</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0 last-title">({{$influencer->code_whats??"--"}}) {{$influencer->whats_number??"--"}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Classifications</p>
                        </div>
                        <div class="col-sm-9">

                            <p class="text-muted mb-0 last-title">
                                @if($influencer->influencer_classification)
                                 {!! implode(',',$influencer->influencer_classification) !!}
                                @else
                                --
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Interests</p>
                        </div>
                        <div class="col-sm-9">

                            <p class="text-muted mb-0 last-title">
                                @forelse(@$influencer->interests->pluck('interest')->toArray() as $intere)
                                 {{$intere}}
                                 {{!$loop->last ? '|' : ''}}
                                @empty
                                --
                                @endforelse
                            </p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">categories</p>
                        </div>
                        <div class="col-sm-9">

                            <p class="text-muted mb-0 last-title">
                                @forelse($influencer->Categories() as $name)
                                 {{$name}}
                                 {{!$loop->last ? ' | ': ''}}
                                @empty
                                --
                                @endforelse
                            </p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Address</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0 last-title">
                                @forelse($influencer->getAddreses() as $address)
                                {{$address}}
                                {{!$loop->last ? ' | ': ''}}
                                @empty
                                --
                                @endforelse
                            </p>

                        </div>
                    </div>
                    <hr>

                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Languages</p>
                        </div>
                        <div class="col-sm-9">
                            <div class="text-muted mb-0 last-title">
                                @if($influencer->lang)
                                    {!! implode(',',getLang($influencer->lang))??'Not Found' !!}
                                @else
                                    --
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Date Of Birth</p>
                        </div>
                        <div class="col-sm-9">
                            <div class=" mb-0 last-title">
                                {{$influencer->date_of_birth?$influencer->date_of_birth->format('Y-m-d'):'--'}}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Government</p>
                        </div>
                        <div class="col-sm-9">
                            <div class=" mb-0 last-title">
                                {{@$influencer->state->name??"--"}}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">City</p>
                        </div>
                        <div class="col-sm-9">
                            <div class=" mb-0 last-title">
                                {{$influencer->city->name??"--"}}
                            </div>
                        </div>
                    </div>
                    <hr>

                    <!-- <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Wears Hijab</p>
                        </div>
                        <div class="col-sm-9">
                            <div class=" mb-0 last-title">
                                @if($influencer->hijab==0) NO @else Yes @endif
                            </div>
                        </div>
                    </div> -->
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Marital Status</p>
                        </div>
                        <div class="col-sm-9">
                            <div class=" mb-0 last-title">
                                @if($influencer->marital_status==1) Single @elseif($influencer->marital_status==2) Married @elseif($influencer->marital_status==3) divocred @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 first-title">Status</p>

                        </div>
                        <div class="col-sm-9">
                            <div class=" mb-0 last-title">
                                @if($influencer->active==0) pending @elseif($influencer->active==1) Active @elseif($influencer->active==2) inactive @elseif($influencer->active==3) reject
								@elseif($influencer->active==4) Block @elseif($influencer->active==5) No Respone  @elseif($influencer->active==7) Out Of Country
								@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('admin.dashboard.layouts.includes.general.models.expiration_date_model')
</section>

@push('js')
    <script>

        $('#regenrate_qrcode').click(function() {
            Swal.fire({
                title: "Are you sure want to regenerate?",
                text: "",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'generate',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function(result) {
                console.log(result);
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{url("dashboard/influencer/generate-codes/") }}' + '/' + {{$influencer -> id}},
                    type: 'get',
                        success: function(res) {
							Swal.fire("Sucess", "generated successfully!");
						$("#digital_influencer_card").attr('href',res['profile_url']);
                         $('#influ_code ').html(res['influencer_code']);
                         $('#qrcode').html(`<img src="${ res['qrcode_url'] }" alt="ImageName" style="width: 66px;">`);
                         $('#qrcode').attr('download', res['qrcode_url']);
                         $('#qrcode').attr('href', `${ res['qrcode_url'] }`);
                    }
                });
                } else {
                    Swal.fire("Cancelled", "canceled successfully!", "error");
                }

            })
        });
    </script>
@endpush
