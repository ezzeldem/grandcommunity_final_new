@extends('admin.dashboard.layouts.app')

@section('title','Sponsors')


@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')


    <style>
        .btn-group, .btn-group-vertical{
            display: flex !important;
            margin-bottom: 10px !important;
            width: fit-content !important;
        }
        .dropdown-menu span{
            cursor: pointer;
        }
        #exampleTbl .actions a i,#exampleTbl .actions button i{
            font-size: 14px;
        }
        #exampleTbl .actions a,#exampleTbl .actions button{
            padding: 4px 12px !important;
        }
        .col_change{
            /*display: table-header-group;*/
            /*align-items: center;*/
            /*justify-content: space-between;*/
            padding: 0;
            /*gap: 10px;*/
        }
    </style>
@endsection

@section('page-header')
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Sponsors'])
@stop
@section('content')
    <div class="row row-sm create_form">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                        <div class="create_import">
                            @can('create our_sponsors')
                                <button type="button" class=" btn  pd-x-20 mg-t-10" data-toggle="modal" data-target="#createModal">
                                    <i class="icon-plus-circle"></i> Create
                                </button>
                            @endcan
                        </div>
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(\App\Models\OurSponsors::count())
                        <section class="btn_sec">
                            @can('delete our_sponsors')
                                <button type="button" class="delete_all btn mt-3 hvr-sweep-to-right" id="btn_delete_all">
                                    <i class="icon-edit-3"></i> Delete
                                </button>
                            @endcan

                            @can('update our_sponsors')
                                <button type="button" class="btn mt-3 hvr-sweep-to-right" id="btn_edit_all">
                                    <i class="fas fa-edit"></i> Edit Selected
                                </button>
                            @endcan

                        </section>
                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="zoom-container">
                            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <table id="exampleTbl" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th> <input type="checkbox" id="select_all"   name="select_all" /></th>
                                <th class="border-bottom-0">Title</th>
{{--                                <th class="border-bottom-0">Logo</th>--}}
                                <th class="border-bottom-0">Active</th>
                                <th class="border-bottom-0">Category</th>
                                <th class="border-bottom-0">Priority</th>
                                @if(user_can_control('our_sponsors'))
                                    <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create  Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"  style="background: transparent !important;">
                <div class="modal-header align-items-center" >
                    <h5 class="modal-title" id="exampleModalLabel">Create A Sponser</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: var(--body-bg-color) !important;">
                    <form enctype="multipart/form-data">
                    <div class="" style="flex-direction:column">
                        <div class="form-group" style="width: 100%">
                            <label class="form-label">Title: <span class="tx-danger">*</span></label>
                            <input type="text"  id="title" name="title" class="form-control" placeholder="Enter Title">
                            <small id="title_error" class="text-danger"></small><br>
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label class="form-label">Category: <span class="tx-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                <option disabled selected>Select</option>
                                @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <small id="category_error" class="text-danger"></small><br>
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label class="form-label">Priority: <span class="tx-danger">*</span></label>
                            <select class="form-control" id="priority" name="priority" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                <option disabled selected>Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <small id="priority_error" class="text-danger"></small><br>
                        </div>
                        <div class="form-group" style="width: 100%">
                            <label class="form-label">Status: <span class="tx-danger">*</span></label>
                            <select class="form-control" id="status" name="status" data-parsley-class-handler="#slWrapper2"  data-placeholder="Select">
                                <option selected disabled>Select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <small id="status_error" class="text-danger"></small><br>
                        </div>
                    </div>
                    <div class="">
                        <label class="form-label">Logo: <span class="tx-danger">*</span></label>
                        <div class="col-sm-12 col-md-12" style="width: 478px;height: 182px">
                            <input type="file"  name="logo" class="dropify" id="logo">
                            <small id="logo_error" class="text-danger"></small>
                        </div>
                    </div>
                    </form>

                </div>
                <div class="modal-footer" style="    background: var(--body-bg-color) !important;">
                    <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                    <button type="button" class="btn Active hvr-sweep-to-rightn" id="create_our_sponsors">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}

    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Delete Sponsor
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are You Sure You Want To Delete?
                    <input class="text" type="hidden" id="delete_sponsor" name="delete_sponsor" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_delete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sponser</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <input type="hidden" name="id" id="edit_sponsor_id" value="">
                        <div class="col_change">

                            <div class="form-group form_change">
                                <label class="form-label">Title: <span class="tx-danger">*</span></label>
                                <input type="text"  id="title_edit" value="" name="title" class="form-control" placeholder="Enter Title">
                                <small id="title_error" class="text-danger"></small>
                            </div>

                            <div class="form-group form_change">
                                <label class="form-label">Category: <span class="tx-danger">*</span></label>
                                <select class="form-control " id="category_id_edit"  name="category_id_edit" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->title}}</option>
                                    @endforeach
                                </select>
                                <small id="category_error" class="text-danger"></small><br>
                            </div>

                            <div class="form-group" style="width: 100%">
                                <label class="form-label">Priority: <span class="tx-danger">*</span></label>
                                <select class="form-control" id="priority_edit" name="priority_edit" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <small id="priority_error" class="text-danger"></small><br>
                            </div>

                            <div class="form-group form_change">
                                <label class="form-label">Status: <span class="tx-danger">*</span></label>
                                <select class="form-control " id="status_edit"  name="status" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <small id="status_error" class="text-danger"></small>
                            </div>

                        </div>
                        <div class="col_change">
                            <div class="row mb-4">
                                <label class="form-label">Logo: <span class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-12" style="width: 478px;height: 182px">
                                    <input type="file"  name="logo" class="dropify" id="logo_edit">
                                    <small id="logo_error" class="text-danger"></small>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn" id="edit_our_sponsors">Edit</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit all  --}}
    <div class="modal fade" id="edit_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Edit Sponsers
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="text" type="hidden" id="influe_all_id" name="influe_all_id" value=''>

                    <div class="col_change">
                        <div class="form-group form_change">
                            <label class="form-label">Status: <span class="tx-danger">*</span></label>
                            <select class="form-control select2 " id="bulk_active"  name="bulk_active" data-show-subtext="true" data-live-search='true'  placeholder="Choose one">
                                <option value="1">Active</option>
                                <option value="-1">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn Delete hvr-sweep-to-right"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_edit_all" class="btn Active hvr-sweep-to-right">Edit</button>
                </div>
            </div>
        </div>
    </div>

    {{--  Delete all Modal   --}}
    <div class="ss modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Delete Brands
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 style="color:#fff">Are You Sure ?</h6>
                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn Delete hvr-sweep-to-right"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_delete_all" class="btn Active hvr-sweep-to-right">Delete</button>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')

    <script>
        $(document).ready(function (){

            /////////////////check  all/////////////////////////////
            function CheckAll(className, elem) {
                var elements = document.getElementsByClassName(className);
                var l = elements.length;
                if (elem.checked) {
                    for (var i = 0; i < l; i++) {
                        elements[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < l; i++) {
                        elements[i].checked = false;
                    }
                }
            }
            $(document).on('click','#select_all',function (){
                CheckAll('box1',this);
            });

            ///////////////////////////////////////////// edit bulk ///////////////////
            $(document).on('click','#btn_edit_all',function (){
                var selected = new Array();
                $("#exampleTbl input[type=checkbox]:checked").each(function() {
                    if(this.value!='on'){
                        selected.push(this.value);
                    }
                });
                if (selected.length > 0) {
                    $('#edit_all').modal('show')
                    $('input[id="influe_all_id"]').val(selected);
                }else{
                    Swal.fire("Cancelled", "Please select a sponser first", "error");
                }
            });

            $(document).on('click','#submit_edit_all',function (){
                let selected_ids =  $('input[id="influe_all_id"]').val();
                let bulk_active =  $('#bulk_active').val();
                let bulk_country_id =  $('#bulk_country_id').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.our_sponsors.edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_country_id:bulk_country_id},
                    dataType: 'json',
                    success: function (data) {
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_country_id").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            OurSponsors.clear();
                            OurSponsors.ajax.reload();
                            OurSponsors.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            ///////////////////////////////////////////////delete group////////////////////////////////////////
            $(document).on('click','#btn_delete_all',function (){
                var selected = new Array();
                $("#exampleTbl input[type=checkbox]:checked").each(function() {
                    if(this.value!='on'){
                        selected.push(this.value);
                    }
                });
                if (selected.length > 0) {
                    $('#delete_all').modal('show')
                    $('input[id="delete_all_id"]').val(selected);
                }else{
                    Swal.fire("Cancelled", "Please select a sponser first", "warning");
                }
            });

            $(document).on('click','#submit_delete_all',function (){
                let selected_ids =  $('input[id="delete_all_id"]').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.sponsors.delete_all')}}',
                    data: {selected_ids:selected_ids},
                    dataType: 'json',
                    success: function (data) {
                        if(data.status){
                            $('#delete_all').modal('hide')
                            Swal.fire("Deleted!", "Deleted Successfully!", "success");
                            OurSponsors.clear();
                            OurSponsors.ajax.reload();
                            OurSponsors.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $(document).on('click','#edit_sponsor',function (){
                $('#edit_modal').modal('show');
                $('#edit_sponsor_id').val($(this).attr('data-id'));
                var sponsor_id=$('#edit_sponsor_id').val();
                $.ajax({
                    type: 'get',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url:`/dashboard/our-sponsors/${sponsor_id}/edit`,
                    success: function (data) {
                        console.log(data)
                        if(data.status){
                            $(".dropify-render").empty();
                           $('#logo_edit').attr("data-default-file",data.data.image);
                           $(".dropify-render").append(`<img src="${data.data.image}">`)
                           $(".dropify-preview").show();
                            $('.dropify').dropify();
                         //$('#logo_edit').val(data.data.image)
                         $('#title_edit').val(data.data.title)
                         $('#status_edit').val(data.data.status);
                         $('#priority_edit').val(data.data.priority);
                         $('#category_id_edit').val(data.data.category_id);

                        }
                    }
                });
            });

            var logo_edit='';
            $(document).on('change','#logo_edit',function (e){
                logo_edit = e.target.files[0];
            })
            $(document).on('click','#edit_our_sponsors',function (){

                var sponsor_id=$('#edit_sponsor_id').val();
                var title_edit=$('#title_edit').val();
                var status_edit=$('#status_edit').val();
                var category_id_edit=$('#category_id_edit').val();
                var priority_edit=$('#priority_edit').val();

                var formData = new FormData();
                formData.set('id',sponsor_id);
                formData.set('_method','PATCH');
                formData.set('image',logo_edit);
                formData.set('status',status_edit);
                formData.set('title',title_edit);
                formData.set('category_id',category_id_edit);
                formData.set('priority',priority_edit);
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: ` /dashboard/our-sponsors/${sponsor_id}`,
                    data:formData ,
                    dataType:'json',
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function (data) {
                        if(data.status){
                            $('#edit_modal').modal('hide')
                            Swal.fire("update!", "Updated Successfully!", "success");
                            OurSponsors.clear();
                            OurSponsors.ajax.reload();
                            OurSponsors.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('click','#delete_modal_show',function (){
                $('#delete_modal').modal('show');
                $('#delete_sponsor').val($(this).attr('data-id'));
            });

            $(document).on('click','#submit_delete',function (){
                 var sponsor_id = $('#delete_sponsor').val();
                $.ajax({
                    type: 'delete',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url:`/dashboard/our-sponsors/${sponsor_id}`,
                    success: function (data) {
                        if(data.status){
                            $('#delete_modal').modal('hide')
                            Swal.fire("delete!", "deleted Successfully!", "success");
                            OurSponsors.clear();
                            OurSponsors.ajax.reload();
                            OurSponsors.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            })

            var logo='';
            $(document).on('change','#logo',function (e){
                logo = e.target.files[0];
            })
            $(document).on('click','#create_our_sponsors',function (){
                $(this).prop('disabled', true);
                var title=$('#title').val();
                var status=$('#status').val();
                var category=$('#category_id').val();
                var priority=$('#priority').val();
                var formData = new FormData();
                formData.set('image',logo);
                formData.set('status',status);
                formData.set('title',title);
                formData.set('priority',priority);
                formData.set('category_id',category);
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.our-sponsors.store')}}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function (data) {
                        if(data.status){
                            $('#createModal').modal('hide')
                            Swal.fire("created!", "created Successfully!", "success");
                            $('#title').val('')
                            $('#logo').val('')
                            $('#category_id').val('')
                            $('#priority').val('')
                            $('#status').val(1)
                            $('#title_error').text('')
                            $('#priority_error').text('')
                            $('#category_error').text('')
                            $('#status_error').text('')
                            $('#logo_error').text('')
                            $(".dropify-render").empty();
                            OurSponsors.clear();
                            OurSponsors.ajax.reload();
                            OurSponsors.draw();
                        }
                    },
                    error: function (data) {
                        $('#create_our_sponsors').prop('disabled', false);
                        $('#title_error').text('')
                        $('#status_error').text('')
                        $('#logo_error').text('')
                        $('#category_error').text('')
                        $('#priority_error').text('')
                        if(data.responseJSON.errors.title){
                            $('#title_error').text(data.responseJSON.errors.title[0])
                        }
                        if(data.responseJSON.errors.priority){
                            $('#priority_error').text(data.responseJSON.errors.priority[0])
                        }
                        if(data.responseJSON.errors.category_id){
                            $('#category_error').text(data.responseJSON.errors.category_id[0])
                        }
                        if(data.responseJSON.errors.status){
                            $('#status_error').text(data.responseJSON.errors.status[0])
                        }
                        if(data.responseJSON.errors.image){
                            $('#logo_error').text(data.responseJSON.errors.image[0])
                        }
                    }
                });
            });
            let selectedIds = [];
            // datatable render
            let OurSponsors = $('#exampleTbl').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'colvis',
                        columns: 'th:nth-child(n+2)'
                    }
                ],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                'aaSorting': [[1, 'asc']],
                ajax: {
                    url :'/dashboard/get-our-sponsors',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        "data": "id",
                        render:function (data,type){
                            return `<input type="checkbox" class="select_all box1"  name="ids[]" value='${data}' />`;
                        }
                    },
                    {
                        data: 'title',
                        render :function (data,type,full){
                            return `
                                <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="image">
                                <span class="_username_influncer">${data}</span>`;
                        }
                    },
                    {
                        "data": 'active_data',
                        "className" : 'switch_parent',
                        render :function (data,type){
                            if(data.status == 1){
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}">
                                        <label class="switch" for="'switch-'${data.id}" title="active" ></label>`
                            }else{
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle"  data-id="${data.id}">
                                            <label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                            }
                        }
                    },
                    {data: 'category_id',
                        render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},
                    {
                        data: 'priority',
                        render: function(data, type) {
                            if(data == 1)
                                return ` <span class="_username_influncer">High</span> `;
                            else
                                return ` <span class="_username_influncer">Normal</span> `;
                        }
                    },
                    {
                        "data": "id",
                        'className': "actions",
                        render:function (data,type){
                            let route_edit = 'our-sponsors/'+data+'/edit'
                            return `<td>
                                @can('update our_sponsors')
                            <button style="background:transparent !important;width:2px !important;" class="btn mt-2 mb-2" id="edit_sponsor" data-id="${data}">
                                    <i class="far fa-edit text-success" style="font-size:16px;"></i>
                                </button>
                                @endcan
                            @can('delete our_sponsors')
                            <button style="background:transparent !important;width:2px !important;" class="btn mt-2 mb-2" id="delete_modal_show"  data-id="${data}" >
                                    <i class="far fa-trash-alt text-danger" style="font-size:16px;"></i>
                                 </button>
                                 @endcan

                            </td>`;
                        }
                    },

                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            });
            $(document).on('click','#Total_Sponsors',function(){

                $('#status').val(null);
                OurSponsors.ajax.reload();
            });

       $(document).on('click','#Active_Sponsors',function(){
        $('#status').val(1);
           OurSponsors.ajax.reload();

       });
       $(document).on('click','#Inactive_Sponsors',function(){
           $('#status').val(0);
           OurSponsors.ajax.reload();
       });



        });


        //Switch
        $('#exampleTbl tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            activeToggle(id);
        })
        //active toggle request
        function activeToggle(id){
            $.ajax({
                url:`/dashboard/our-sponsors-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    OurSponsors.clear();
                    OurSponsors.ajax.reload();
                    OurSponsors.draw();
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        }





    </script>
    @if(session()->has('successful_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('successful_message')}}", "success");
        </script>
    @elseif(session()->has('error_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('error_message')}}", "error");
        </script>
    @endif
@endsection

