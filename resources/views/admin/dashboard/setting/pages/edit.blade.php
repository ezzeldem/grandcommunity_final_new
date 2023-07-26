@extends('admin.dashboard.layouts.app')
@section('title','Edit Page')
@section('style')
@include('admin.dashboard.layouts.includes.general.styles.index')

    <!--- Internal Sweet-Alert css-->
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css"/>  --}}
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
            ['route'=>route('dashboard.pages.index'),'name'=>'Pages']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    {!! Form::model($page,['route' => ['dashboard.pages.update', $page->id],'method'=>'put','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page', 'enctype'=>'multipart/form-data']) !!}
                    @include('admin.dashboard.setting.pages.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    {{--  <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>  --}}
{{--    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>--}}
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src=" {{URL::asset('assets/vendor/summernote/summernote-bs4.js')}}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    @include('admin.dashboard.layouts.includes.general.scripts.index')



    <script  type="text/javascript" >
        $(document).ready(function() {
            $('.summernote').summernote({
                height:400
            });

            $(`#position,#status`).select2({
                placeholder: "Select",
                allowClear: true,
                maximumSelectionLength: 4,
            });
        });
        $('.dropify').dropify();


        var i = {{ count($page->sections) }};
        function append_section(){
            $('#sections').append(`
                <div id="remove_section_${i}" class="col-lg-12 col-md-12 col-sm-12 mt-3">
                    <div class="row">
                        <div class="-lg-12 col-md-12 col-sm-12 mt-3">
                            <span onclick="remove_section(${i})" class="btn btn-danger pd-x-20 mg-t-10" style="background: #1e1e1e;color: #fff;">
                                <i class="icon-trash"></i>
                                Remove Section
                            </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Title (En): <span class="tx-danger">*</span></label>
                                {!! Form::text('sub_title[${i}][0]',old('sub_title.0.0'),['class' =>'form-control '.($errors->has('sub_title.${i}.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
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
                                {!! Form::text('sub_title[${i}][1]',old('sub_title.0.1'),['class' =>'form-control '.($errors->has('sub_title.${i}.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
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
                                {!! Form::textarea('sub_description[${i}][0]',old('sub_description.${i}.0'),['class' =>'form-control summernote '.($errors->has('sub_description.${i}.0') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
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
                                {!! Form::textarea('sub_description[${i}][1]',old('sub_description.${i}.1'),['class' =>'form-control summernote '.($errors->has('sub_description.${i}.1') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                                @error('sub_description.${i}.1')sub_description
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
            $('#remove_section_'+id).remove();
        }

        function delete_section(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        url: "{{ route('dashboard.pages.sections.delete','') }}"+"/"+id,
                        type:'delete',
                        method:'delete',
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:()=>{
                            Swal.fire("Deleted!", "Deleted Successfully!", "success");
                            $('#section_'+id).remove();
                        },
                        error:()=>{
                            Swal.fire("error", "Something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "Canceled Successfully!", "error");
                }
            })
        }

    </script>
@stop

