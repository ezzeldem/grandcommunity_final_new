@extends('admin.dashboard.layouts.app')
@section('title','Edit caseStudies')
@section('style')
    <!--- Internal Sweet-Alert css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <style>
        .panel-heading.note-toolbar{
            display: flex;
        }
        .note-btn.dropdown-toggle {
            background-color: #ecf0fa!important;
            color: #0b1426;
        }
    </style>
@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.caseStudies.index'),'name'=>'caseStudies']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')

@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
@endif
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">

                {!! Form::model($case,['route' => ['dashboard.caseStudies.update', $case->id],'method'=>'put','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page', 'enctype'=>'multipart/form-data']) !!}

                    @include('admin.dashboard.case-studies.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @stop

    @section('js')

    @if(session()->has('successful_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('successful_message')}}", "success");
        </script>
    @elseif(session()->has('error_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('error_message')}}", "error");
        </script>
    @endif

    @include('admin.dashboard.case-studies.scripts')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>


    <script  type="text/javascript" >
        $(document).ready(function() {
            $('#category').select2({
                placeholder: "Select Country...",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function (){
            var edit = $('#checkIfEdit').val();
            var flag = false
            if(edit == 1){
                $('#campaign_type').trigger('change')
                changeCampaignType($('#campaign_type').val())
            }
            function changeCampaignType(type){
                var campId = $('#campaign_id').val();
                $('#campaign_name').empty()
                // $('#campaign_name').parent().parent().hide();
                if(flag){
                    $('.profile_link').val('')
                }
                flag = true
                $.ajax({
                    type: 'GET',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.get-campaigns')}}',
                    data: {type:type},
                    success: function (data) {
                        if(data.data.length > 0){
                            let newData = data.data
                            // $('#campaign_name').parent().parent().show();
                            $('#campaign_name').append(`<option disabled selected>Select Campaign</option>`)
                            newData.map((item) => {
                                $('#campaign_name').append(`<option value="${item.id}" ${item.id == campId ? 'selected' : ''}>${item.name}</option>`)
                            })

                        }else{
                            $('#campaign_name').empty();
                            // $('#campaign_name').parent().parent().hide();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
            $(document).on('change','#campaign_type',function (){
                let type = $(this).val();
                changeCampaignType(type)
            })

            $(document).on('change','.campName',function (){
                let campaign = $(this).val();
                $('.profile_link').val('')
                $.ajax({
                    type: 'GET',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.get-campaign-brand')}}',
                    data: {campaign:campaign},
                    success: function (data) {
                        if(data.data){
                            let newData = data.data
                            $('.profile_link').val(`https://www.instagram.com/${newData}/`)
                        }else{
                            $('.profile_link').val('')
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            })


            /////////////////////
            img_urls = []
            $(document).on('change','#image',function (e){
                choseImgFile(e);
            })
            function choseImgFile(e) {
                $('.imagesShow').empty()
                const files = e.target.files;
                if (files) {
                    console.log(" ==> files ==", files);
                    for (const key in files) {
                        if (key !== "length" && key !== "item") {
                            let customFile = files[key];
                            console.log("=====> custom file =====", customFile);
                            const reader = new FileReader();
                            reader.onload = () => {
                                const result = reader.result;
                                if(files[key]['type'].includes('image')){
                                    $('.imagesShow').append(`<img id="element${key}" src="${result}" style="width:130px;height:130px;"/> `)
                                }else{
                                    $('.imagesShow').append(` <video style="width:130px;height:130px;" width="400" controls>
                                <source src="${result}" type="video/mp4">
                                    Your browser does not support HTML video.
                            </video>`)
                                }
                                img_urls.push(result);
                            };
                            reader.readAsDataURL(customFile);
                        }
                    }
                } else {
                    console.log("not working");
                }
            }

            // let lang = $('.lang.active').data('value');
            // $('.nav-link').click(function (){
            //     $(this).closest('.nav-pills').find('.nav-link.active').removeClass('active');
            //     $(this).addClass('active');
            //     lang = $(this).data('value');
            //     displayInputs(lang)
            // })
            // displayInputs(lang)

        })
        // function displayInputs(lang){
        //     $('input[name="lang"]').val(lang);
        //     if(lang == 'ar'){
        //         $('.ar-inputs').disabled=false;
        //         $('.ar-inputs').closest('.ar').css('display','block');
        //
        //         $('.en-inputs').disabled=true;
        //         $('.en-inputs').closest('.en').css('display','none');
        //     }else{
        //         $('.en-inputs').disabled=false;
        //         $('.en-inputs').closest('.en').css('display','block');
        //
        //         $('.ar-inputs').disabled=true;
        //         $('.ar-inputs').closest('.ar').css('display','none');
        //     }
        // }
        // $('.dropify').dropify();

    </script>
@stop

