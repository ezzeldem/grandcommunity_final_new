@extends('admin.dashboard.layouts.app')

@section('title','CampaignLog')


@section('style')

    <style>
        #campaignName{
            background: #121929;
            padding: 10px;
            border-radius: 3px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 2px;
        }
        #campaignName a{
            color: #fff !important;
        }
        .complainText{
            width: 126px;
            word-break: break-word;
        }
        .replies{
            background: #121929;
            padding: 5px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            margin-left: 2rem;
            border-radius: 3px;
            flex-direction: column;
    position: relative;
    text-transform: capitalize;
    box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
    color: #fff;
        }
        .replies .info{
            display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #1a233a;
    padding: 4px;
        }
        .replies .info .user_name{
           background: #1a233a;
    padding: 6px 10px;
    border-radius: 2px;
    font-weight: 600;
    box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
        }
        .replies .info .replay_date{
          text-transform: lowercase;
    opacity: 0.6;
        }
        .replies .content{
              padding: 10px;
        }
        .replies .content p{
              display: -webkit-box;
    height: 1.6em;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #fff;
    font-size: 15px;
    line-height: 31px;
    letter-spacing: 1px;
    color: #fff;
    text-transform: capitalize;
        }
    </style>
    @include('admin.dashboard.layouts.includes.general.styles.index')
@endsection

@section('page-header')
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Campaign Log'])
@stop
@section('content')
<div class="log-wrapper">
    <div class="">
        <div class="main-log card">
            <ul class="nav nav-pills mb-3 d-flex justify-content-center align-items-center flex-row" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Log</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Complains</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <label for="" class="mb-3" style="font-size: 15px"> campaign Name :  </label>
                    <h4 id="campaignName"><a href="{{route('dashboard.campaigns.show',$campaign->id)}}">{{$campaign->name}}</a></h4>
                    <div class="append_log"></div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <label for="" class="mb-3" style="font-size: 15px"> campaign Name :  </label>
                    <h4 id="campaignName"><a href="{{route('dashboard.campaigns.show',$campaign->id)}}">{{$campaign->name}}</a></h4>
                    <div class="append_complains">
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="campaignIdInputHidden" value="{{$campaign->id}}" />
    </div>
</div>
@endsection
@section('js')

    @include('admin.dashboard.layouts.includes.general.scripts.index')


    <script>
        $(document).ready(function (){
            var count =5;
            var to_paginate = 0
            var total_paginate = 0

            //When scroll get data in log tab
            $(window).on("scroll", function() {
                if( $(window).scrollTop() + window.innerHeight  >= document.body.scrollHeight ) {
                    if(total_paginate !== to_paginate)
                    {
                        count++;
                        getLogCampaign(count);
                    }
                }
            });

            //Function get log campaign data
            function getLogCampaign(limit = 5){
                let url = '/dashboard/logajax/campaign/'+Number($('#campaignIdInputHidden').val());
                $.ajax({
                    url:url,
                    type:'get',
                    data:{'limit':limit},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({data})=>{
                        $('.append_log').empty()
                        if(data.data.length > 0){
                            to_paginate = data.to
                            total_paginate = data.total
                            data.data.forEach((item) => {
                                let influencer_data = ''
                                if(item.influencer){
                                    influencer_data = `<p class="mb-1">Influencer : ${item.influencer.name}</p>`
                                }
                                $('.append_log').append(`
                                 <div class="list-group">
                                   <div href="javascript:void(0)" class="list-group-item list-group-item-action">
                                       <div class="d-flex w-100 justify-content-between">
                                           <h5 class="mb-1">User Name : <a style="color: #fff !important;" href="/dashboard/admins">${item.admin.name}</a></h5>
                                           <span class="_createdAt_table"> <i class="fas fa-calendar-week"></i> - ${item.created_at}</span>
                                       </div>
                                       <p class="mb-1">Action : ${item.action}</p>
                                       ${influencer_data}
                                        <span class="_username_influncer">${item.admin.role}</span>
                                   </div>
                               </div>
                                `);
                            })
                        }else{
                            $('.append_log').append('<h5 style="background: #121929;padding: 10px;border-radius: 3px;">There IS No Log For This Campaign.</h5>');
                        }
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong please reload page", "error");
                    }
                })
            }

            //Function get complain campaign data
            function getComplainsCampaign(){
                let url = '/dashboard/complainsajax/campaign/'+Number($('#campaignIdInputHidden').val());
                $.ajax({
                    url:url,
                    type:'get',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({data})=>{
                        $('.append_complains').empty()
                        data.forEach((item) => {
                            console.log(item)
                            let replies = ''
                            if(item.replies != null){
                                item.replies.forEach((rep) => {
                                   replies += `<div class="replies">
                                <div class="info">
                                <div class="user_name">
                                ${rep.admin.name}
                                </div>
                                <div class="replay_date">
                                ${rep.created_at}
                                </div>
                                </div>
                                <div class="content">
                                <p>
                                ${rep.reply_text}
                                </p>
                                </div>
                            </div>`;
                                })
                            }

                            let complainStatus = ''
                                if(item.status == 0){
                                    complainStatus = `<span class="badge badge-danger">Un-Resolved</span>`
                                }else{
                                     complainStatus = `<span class="badge badge-success">Resolved</span>`
                                }
                            $('.append_complains').append(`
                                <div class="list-group">
                                        <div href="javascript:void(0)" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">${item.influencer.name}</h5>
                                                    <h5 class="mb-1 complainText">${item.complain}</h5>
                                                    <h5 class="mb-1">${item.created_at}</h5>
                                                    <h5 class="mb-1">${complainStatus}</h5>
                                                    <h5 class="mb-1"><button class="btn btn-primary sildeReply" data-id="${item.influencer.id}">Add Reply</button></h5>
                                            </div>
                                            <div class="replyData-${item.influencer.id}">
                                                ${replies}
                                            </div>


                                            <div class="replySection-${item.influencer.id}">
                                               <input type="text" class="form-control" id="reply-${item.influencer.id}">
                                               <button data-id="${item.influencer.id}" class="btn btn-primary addReplyBtn mt-2">Add</button>
                                            </div>
                                        </div>
                                </div>
                            `);
                        })
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong please reload page", "error");
                    }
                })
            }

            //Slide add reply section
             $(document).on('click','.sildeReply',function(){
                 var influencerId = $(this).data('id')
                 $(`.replySection-${influencerId}`).slideToggle()
             })

             //Add new reply
            $(document).on('click','.addReplyBtn',function(){
                var influencerId = $(this).data('id')
                var campaignId = Number($('#campaignIdInputHidden').val());
                var replyMessage = $(`#reply-${influencerId}`).val();
                $.ajax({
                    url:"{{route('dashboard.add-reply')}}",
                    type:'get',
                    data:{'influencer' : influencerId,'campaign' : campaignId,'reply' : replyMessage},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({data})=>{
                        $(`.replyData-${influencerId}`).append(
                            `
                            <div class="replies">
                                <div class="info">
                                <div class="user_name">
                                ${data.admin.name}
                                </div>
                                <div class="replay_date">
                                ${data.created_at}
                                </div>
                                </div>
                                <div class="content">
                                <p>
                                ${data.reply_text}
                                </p>
                                </div>
                            </div>
                            `);
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong please reload page", "error");
                    }
                })
            })
            getLogCampaign()
            getComplainsCampaign()
        })
    </script>

@endsection
