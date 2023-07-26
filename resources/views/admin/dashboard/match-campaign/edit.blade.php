@extends('admin.dashboard.layouts.app')
@section('title','Edit Match-Campaign')
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
            ['route'=>route('dashboard.match-campaign.index'),'name'=>'match-campaign']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::model($matchCampaign,['route' => ['dashboard.match-campaign.update', $matchCampaign->id],'method'=>'put','data-parsley-validate'=>'','id'=>'match-campaign_form','class'=>'create_page','files'=>true]) !!}
                    @include('admin.dashboard.match-campaign.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>


    <script  type="text/javascript" >
        $(document).ready(function() {
            // $('.summernote').summernote({
            //     height:150,
            //     toolbar: [
            //         [ 'style', [ 'style' ] ],
            //         [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            //         [ 'fontname', [ 'fontname' ] ],
            //         [ 'fontsize', [ 'fontsize' ] ],
            //         [ 'color', [ 'color' ] ],
            //         [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            //     ]
            // });
        });
    </script>
    <script>
        $(document).ready(function (){
            let lang = $('.lang.active').data('value');
            $('.nav-link').click(function (){
                $(this).closest('.nav-pills').find('.nav-link.active').removeClass('active');
                $(this).addClass('active');
                lang = $(this).data('value');
                displayInputs(lang)
            })
            displayInputs(lang)

        })
        function displayInputs(lang){
            $('input[name="lang"]').val(lang);
            if(lang == 'ar'){
                $('.ar-inputs').disabled=false;
                $('.ar-inputs').closest('.ar').css('display','block');

                $('.en-inputs').disabled=true;
                $('.en-inputs').closest('.en').css('display','none');
            }else{
                $('.en-inputs').disabled=false;
                $('.en-inputs').closest('.en').css('display','block');

                $('.ar-inputs').disabled=true;
                $('.ar-inputs').closest('.ar').css('display','none');
            }
        }
        $('.dropify').dropify();

    </script>
@stop

