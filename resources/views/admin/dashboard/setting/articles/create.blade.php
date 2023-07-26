@extends('admin.dashboard.layouts.app')
@section('title','Create Article')
@section('style')
    <!--- Internal Sweet-Alert css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css"/>
{{--    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">--}}
    <link href="{{URL::asset('assets/vendor/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">


        <style>
        .panel-heading.note-toolbar{
            display: flex;
        }
        .note-btn.dropdown-toggle {
            background-color: #ecf0fa!important;
            color: #0b1426;
        }
        .note-editor .card-header{
            background: #1474f9 !important;
        }
    </style>
@stop

@section('page-header')
@php
        $routes =  [
            ['route'=>route('dashboard.articles.index'),'name'=>'Articles']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb', $routes)
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
                    {!! Form::open(['route' => ['dashboard.articles.store'],'method'=>'post','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page', 'enctype'=>'multipart/form-data']) !!}
                    @include('admin.dashboard.setting.articles.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>--}}
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src=" {{URL::asset('assets/vendor/summernote/summernote-bs4.js')}}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

    @if(!is_null(old('page_type')))
        <script  type="text/javascript">
            page_type = {{old('page_type')}};
            $('input[name=page_type][value='+page_type+']').click();
        </script>
    @endif

    <script  type="text/javascript" >
        $("#insert_tag_en").select2({
            placeholder: 'Select',
            tags: true,
            tokenSeparators: [',', ' ']
        })

        $("#insert_tag_ar").select2({
            placeholder: 'Select',
            tags: true,
            tokenSeparators: [',', ' ']
        })

        $(document).ready(function() {
            $('.summernote').summernote({
                height:400,
                tabsize: 2
            });

            $(`#position,#status`).select2({
                placeholder: "Select",
                allowClear: true,
                maximumSelectionLength: 4,
            });
        });

        $('.dropify').dropify();

        $('input[name=page_type]').click(function(){
            if($(this).val() == 0){
                $('#sections').html(`
                <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                            {!! Form::text('sub_title[0][0]',(isset($articles))?$articles->getTranslation('title','en'):old('sub_title.0.0'),['class' =>'form-control '.($errors->has('sub_title.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                            @error('sub_title.0.0')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required text-danger">
                                        {{$message}}
                                    </li>
                                </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Title (Ar): <span class="tx-danger">*</span></label>
                            {!! Form::text('sub_title[0][1]',(isset($articles))?$articles->getTranslation('title','ar'):old('sub_title.0.1'),['class' =>'form-control '.($errors->has('sub_title.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                            @error('sub_title.0.1')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required text-danger">
                                        {{$message}}
                                    </li>
                                </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                            {!! Form::textarea('sub_description[0][0]',(isset($articles))?$articles->getTranslation('description','en'):old('title.0.0'),['class' =>'form-control summernote '.($errors->has('sub_description.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                            @error('sub_description.0.0')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required text-danger">
                                        {{$message}}
                                    </li>
                                </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                            {!! Form::textarea('sub_description[0][1]',(isset($articles))?$articles->getTranslation('description','ar'):old('title.0.1'),['class' =>'form-control summernote '.($errors->has('sub_description.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                            @error('sub_description.0.1')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required text-danger">
                                        {{$message}}
                                    </li>
                                </ul>
                            @enderror
                        </div>
                    </div>
                    </div>
                    </div>`);
            }else if ($(this).val() == 1){
                $('#sections').html(`
                <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                    <div class="row">
                        <div class="-lg-12 col-md-12 col-sm-12 mt-3">
                            <span id="append_section" onclick="append_section()" class="btn pd-x-20 mg-t-10" style="background: #1e1e1e;color: #fff;">
                                <i class="icon-plus-circle"></i>
                                Add Section
                            </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[0][0]',(isset($articles))?$articles->getTranslation('title','en'):old('sub_title.0.0'),['class' =>'form-control '.($errors->has('sub_title.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                @error('sub_title.0.0')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required text-danger">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (Ar): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[0][1]',(isset($articles))?$articles->getTranslation('title','ar'):old('sub_title.0.1'),['class' =>'form-control '.($errors->has('sub_title.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                @error('sub_title.0.1')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required text-danger">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                                {!! Form::textarea('sub_description[0][0]',(isset($articles))?$articles->getTranslation('description','en'):old('title.0.0'),['class' =>'form-control summernote '.($errors->has('sub_description.0.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.0.0')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required text-danger">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                                {!! Form::textarea('sub_description[0][1]',(isset($articles))?$articles->getTranslation('description','ar'):old('title.1.0'),['class' =>'form-control summernote '.($errors->has('sub_description.0.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.0.1')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required text-danger">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>`);
            }

            $('.summernote').summernote({
                height:400,
                tabsize: 2
            });
        });

        var i = 1;
        function append_section(){
            $('#sections').append(`
                <div id="section_${i}"  class="col-lg-12 col-md-12 col-sm-12 mt-3">
                    <div class="row">
                        <div class="-lg-12 col-md-12 col-sm-12 mt-3">
                            <span onclick="remove_section(${i})" class="btn pd-x-20 mg-t-10" style="background: #1e1e1e;color: #fff;">
                                <i class="icon-trash"></i>
                                Remove Section
                            </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[${i}][0]',(isset($articles))?$articles->getTranslation('title.${i}.0','en'):old('sub_title.${i}.0'),['class' =>'form-control '.($errors->has('sub_title.${i}.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                @error('sub_title.${i}.0')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (Ar): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[${i}][1]',(isset($articles))?$articles->getTranslation('title.${i}.1','ar'):old('sub_title.${i}.1'),['class' =>'form-control '.($errors->has('sub_title.${i}.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                                @error('sub_title.${i}.1')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                                {!! Form::textarea('sub_description[${i}][0]',(isset($articles))?$articles->getTranslation('description.${i}.0','en'):old('sub_description.${i}.0'),['class' =>'form-control summernote '.($errors->has('sub_description.${i}.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.${i}.0')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                                {!! Form::textarea('sub_description[${i}][1]',(isset($articles))?$articles->getTranslation('description.${i}.1','ar'):old('sub_description.${i}.1'),['class' =>'form-control summernote '.($errors->has('sub_description.${i}.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.${i}.1')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                                        <li class="parsley-required">
                                            {{$message}}
                                        </li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>`);

            $('.summernote').summernote({
                height:400,
                tabsize: 2
            });

            i = i + 1;
        }

        function remove_section(id){
            $("#section_"+id).remove();
        }

    </script>
@stop

