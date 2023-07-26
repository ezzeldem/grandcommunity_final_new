@extends('admin.dashboard.layouts.app')
@section('title','Companies')
@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <style>
        .show_brand{
            color: #bcd0f7;
        }
        .dataTables_filter {
            display: none;
        }

        #custom{
            border-radius: 2px;
            font-size: .825rem;
            background: #1A233A;
            color: #bcd0f7;
            border: none;
            padding:5px;
            /*float:right;*/
        }
        .btn-group, .btn-group-vertical{
            display: flex !important;
            margin-bottom: 10px !important;
            width: fit-content !important;
        }
        .dropdown-menu span{
            cursor: pointer;
            text-transform: capitalize;
            font-weight: bold;
        }
        #brand_table i{
            font-size: 23px;
        }
        #brand_table .actions a i,#brand_table .actions button i{
            font-size: 14px;
        }
        #brand_table .actions a,#brand_table .actions button{
            padding: 4px 12px !important;
        }
        .col_change{
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0;
            gap: 10px;
        }
        .form_change{
            max-width: 220px;
            min-width: 200px;
        }
        .select2-container {
            min-width: 160px !important;
        }
        .btn_action {
            display : inline-flex ;
            align-items:center ;
            gap: 2px;
        }
        .btn_action a , .btn_action button {
            padding :0 ;
            padding-right :3px;
        }
        #brand_table_length{
            display: contents;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }

        .dt-button.buttons-columnVisibility {
            opacity: 0.6;
        }

        .dt-button.buttons-columnVisibility.active {
            opacity: 1;
        }

        .dt-buttons {
            top: -10px !important;
            margin: 0 !important;
        }
    </style>

@endsection

@section('page-header')
    <!-- breadcrumb -->
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Companies'])
    <!-- /breadcrumb -->
@stop

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mg-b-0">Companies Table </h4>
                        <div class="create_import">
                            @can('create brands')
                            <a href="{{route('dashboard.brands.create')}}" class="btn ">
                                <i class="icon-plus-circle"></i> Add Company
                            </a>
                             <button type="button" class="btn " id="imports"  data-toggle="modal" data-target="#import_excels">
                                 <i class="icon-share-alternitive"></i> Import
                             </button>
                             </div>
                            @endcan
                        </div>

                    @if(session()->has('alert-message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session('alert-message')}}
                    </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @php
                                    $arr_err=[]
                                @endphp
                                @foreach ($errors->all() as $value)
                                    @if($value[strlen($value)-1] == 1)
                                        @php array_push($arr_err,'The data must be unique') @endphp
                                    @elseif($value[strlen($value)-1] == 2)
                                        @php array_push($arr_err,'The data is required')@endphp
                                    @elseif($value[strlen($value)-1] == 3)
                                        @php array_push($arr_err,'The gender must be (Male or Female)')@endphp
                                    @endif
                                @endforeach
                                @foreach (array_unique($arr_err,SORT_REGULAR)  as $value_)
                                    <li>{{$value_}}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                  @include('admin.dashboard.brands.filter-form')
                </div>
                <div class="card-body">
                    <div class="table-container brand-table">
                        <div class="zoom-container">
                            <button onclick="$('.table-container').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <div class="table-responsive">
                        <table id="brand_table" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">
                                    <input  name="select_all" id="select_all" type="checkbox" />
                                </th>
                                <th data-name="user_name" class="border-bottom-0">Username</th>
								<th data-name="image" class="border-bottom-0">Email</th>
                                <th data-name="status" class="border-bottom-0">Status</th>
								<th data-name="completed" class="border-bottom-0">Profile Is Completed</th>
								<th data-name="country_id" class="border-bottom-0">Countries</th>
                                <th data-name="group_of_brands" class="border-bottom-0">Brands</th>
                                <th data-name="campaigns_count" class="border-bottom-0">Campaigns</th>
                                <th data-name="expirations_date" class="border-bottom-0">Expiration Date</th>
								<th data-name="created_at" class="border-bottom-0">created_at</th>
                                @if(user_can_control('brands'))
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
    </div>

{{--  statrt modal delete all   --}}
    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Delete Companies
                    </h5>
                    <button type="button" class="close" id="mod_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <h6 style="color:#fff"> Are You Sure ?  </h6>
                        <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn Delete hvr-sweep-to-right" id="mod_close" data-dismiss="modal">Close</button>
                        <button type="button" id="submit_delete_all" class="btn Active hvr-sweep-to-right">Delete</button>
                    </div>
            </div>
        </div>
    </div>
    {{--  end modal delete all   --}}




    {{-- Edit all  --}}
    @include('admin.dashboard.brands.models.bulk_edit_brand')
    {{-- Import  --}}
    @include('admin.dashboard.influencers.models.import_excel')



@endsection

@section('js')

@include('admin.dashboard.brands.models.brand_details')




@include('admin.dashboard.layouts.includes.general.scripts.handlebuttons')

    @include('admin.dashboard.layouts.includes.general.scripts.index')

    <script>
        function updateFilterFormQueryString(){
            var search = location.search.substring(1);
            let filterData = search?JSON.parse('{"' + decodeURI(search).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}'):null;
            if(filterData){
                $.each(filterData, function (key, val) {
                    if(key !== "sorted_by" || key !== "sorted_type" ){
                        if(val && val.includes("%2C") || val.includes(",")){
                            val = val.replace("%2C", ",");
                            val = val.split(",").map(Number)
                        }
                        $("#"+key).val(val).trigger("change");
                    }
                });

                brand_tabels.clear();
                brand_tabels.ajax.reload();
                // brand_tabels.draw();
            }
        }
        $(function() {

            window.addEventListener( "pageshow", function ( event ) {
                var historyTraversal = event.persisted ||
                    ( typeof window.performance != "undefined" &&
                        window.performance.navigation.type === 2 );
                if ( historyTraversal ) {
                    updateFilterFormQueryString()
                }
            });
        });

        let brand_tabels = null;

        $(document).ready( function () {

           // click on a link with prevent default

            $(document).on('click','#import_excel_btn',function (e){
                let import_excel = $('#import_excel').val();
                if(import_excel == '' || import_excel == null){
                    e.preventDefault();
                    Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
                }else{
                    $('#submit_import_form').submit();
                }
            });

            //FUNCTION CHECK ALL
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

            //TO SELECT ALL
            $(document).on('click','#select_all',function (){
                CheckAll('box1',this);
            });

            //CLOSE BUTTON
            $(document).on('click','#mod_close',function(){
                $('#delete_all').modal('hide')
            })


            //RESET TO BASIC DATA
            $(document).on('click','#rest',function (){
                $('#campaign_id_search').val(null).trigger('change');
                $('#all_country_id_search').val(null).trigger('change');
                // $('#office_id_search').val(null).trigger('change');
                $('#completed_profile_search').val(null).trigger('change');
                $('#pending_search').val(null).trigger('change');
                $('#lastest_collaboration_search').val(null).trigger('change');
                $('#last_collaboration_search').val(null).trigger('change');
                $('#status_id_search').val(null).trigger('change');
                $('#reportrange span').empty();
                $('#startDateSearch').val('');
                $('#endDateSearch').val('');
                brand_tabels.clear();
                brand_tabels.ajax.reload();
                brand_tabels.draw();
            })

            //DELETE ALL (GET IDS OF SELECTED BRANDS)
            $(document).on('click','#btn_delete_all',function (){
                // var selected = new Array();
                // $("#brand_table input[type=checkbox]:checked").each(function() {
                //     if(this.value != 'on'){
                //         selected.push(this.value);
                //     }
                // });
                let selected = getCheckedItemsInDataTableFromSession();
                if (selected.length > 0) {
                    $('#delete_all').modal('show')
                    $('input[id="delete_all_id"]').val(selected);
                }else{
                    Swal.fire("Error", "Please select a company first", "warning");
                }
            });

            ///////////////////////////////////////////// edit bulk ///////////////////
            $(document).on('click','#btn_edit_all',function (){
                let statusObj = {};
                $("#brand_table input[type=checkbox]:checked").each(function() {

                    let checkedElementStatus = $(this.parentElement.parentElement).find('.switch_parent').text().trim().toLowerCase();
                    if ( checkedElementStatus !== "status") {
                        statusObj = checkAndGetStatus(checkedElementStatus, statusObj);
                    }
                });

                let selected = getCheckedItemsInDataTableFromSession();

                $("#bulk_active").html(`<option label="Select" disabled selected></option> ${Object.values(statusObj).join('')}`);

                if (selected.length > 0) {
                    $('#edit_all').modal('show')
                    $('input[id="influe_all_id"]').val(selected);
                }else{
                    Swal.fire("Error", "Please select a company first", "warning");
                }
            });


            //SUBMIT DELETE ALL TO SELECTED BRANDS
            $(document).on('click','#submit_delete_all',function (){
                let selected_ids =  $('input[id="delete_all_id"]').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.delete_all')}}',
                    data: {selected_ids:selected_ids},
                    dataType: 'json',
                    success: function (data) {
                        if(data.recordsTotal%10 > 1) {
                            $('#brand_table_next').hide();
                        }
                        else {
                            $('#brand_table_next').show();
                        }
                        if(data.status){
                            $('#delete_all').modal('hide')
                            Swal.fire("Deleted", "Deleted Successfully!", "success");
                            brand_tabels.ajax.reload();

                        }else{
                            Swal.fire("Error", "Can not delete the brand because it has active campaigns", "warning");
                            $('#delete_all').modal('hide')
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            //DATE RANGE PICKER FUNCTION
            function isValidDate(d) {
                return !isNaN(Date.parse(d));
            }
            var start = '';
            var end = '';
            function cb(start, end) {
                $('#reportrange span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
                $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
                $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
            }
            $('#reportrange').daterangepicker({
                autoUpdateInput: false,
                "minYear": 2000,
                "maxYear": 2030,
                startDate: moment(),
                endDate: moment(),
                ranges: {
                    'All': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment()],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
                }
            }, cb);
            cb(start, end);
            // $("#reportrange").on('click', function (){
            //     start = moment().subtract(29, 'days');
            //     end = moment();
            //     $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //     $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
            //     $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
            // })

            //START SELECT2 SCRIPT
            $('.select2').select2({
                placeholder: "Select",
                allowClear: true
            });



                $("#all_country_id_search").val("").trigger("change");
                $("#campaign_id_search").val("").trigger("change");
                $('#status_id_search').val('{{$filterBrandStatus ?? ""}}').trigger('change');
                $("#bulk_active").val("").trigger("change");


            //END SELECT2 SCRIPT
            //FILTER SUBMIT
            $(document).on('click','#filter',function (e){
                e.preventDefault();
                pushFilterDataToUrl();
                brand_tabels.ajax.reload();
            })

            $(document).on('input','#custom',function (){
                pushFilterDataToUrl();
                brand_tabels.ajax.reload();
            })

            function pushFilterDataToUrl(){
                let newFilterData = {custom: $('#custom').val(), endDateSearch: $('#endDateSearch').val(), startDateSearch: $('#startDateSearch').val(), campaign_id_search: $('#campaign_id_search').val(), all_country_id_search: $('#all_country_id_search').val().toString(), status_id_search: $('#status_id_search').val(), completed_profile_search: $('#completed_profile_search').val()};
                window.history.pushState("", "", null);
                let requestData = new URLSearchParams(newFilterData).toString()
                window.history.pushState("", "", "{{request()->url()}}?"+requestData);
            }

            let brand_status_filter = "";
            $('.status_influencer_statistic').on('click', function(event) {
                brand_status_filter = $(this).attr('value');
                brand_tabels.ajax.reload();
                $('html, body').animate({
                    scrollTop: ($("#brand_table").offset().top)
                }, 1000);
            });

           //BRANDS DATATABLE RENDER
            brand_tabels =  $('#brand_table').DataTable({
                fixedHeader: {
                    header: true,
                    footer : false,
                },
                "drawCallback": function( settings ) {
                    recheckedInputsStoredInDatatableSession()
                },
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                clearable: true,
                // "order": [[ 9, "desc" ]],
                dom: 'Blfrtip',
                "buttons": [
                    'colvis',
                ],
               'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                "ajax": {
                    url :"/dashboard/get-brands",

                    data: function (d) {
                        let dtSettings = $('#brand_table').dataTable().fnSettings();
                        // d.office_val = $('#office_id_search').val();
                        // d.lastest_collaboration_search = $('#lastest_collaboration_search').val();
                        // d.pending_search = $('#pending_search').val();
                        d.status_val = brand_status_filter;
                        d.custom = $('#custom').val();
                        d.end_date = $('#endDateSearch').val();
                        d.start_date = $('#startDateSearch').val();
                        d.camp_val = $('#campaign_id_search').val();
                        d.country_val = $('#all_country_id_search').val();
                        d.status_id_search = $('#status_id_search').val()?$('#status_id_search').val():"";
                        d.profile_completed_val = $('#completed_profile_search').val();
                        d.sorted_by = $(dtSettings.aoColumns[dtSettings.aaSorting[0][0]]).attr('name');
                        d.sorted_by = d.sorted_by?d.sorted_by:"";
                        d.sorted_type = dtSettings.aaSorting[0][1];
                        addCheckedItemsInDataTableToSession();
                        recheckedInputsStoredInDatatableSession();
                    },

                },
                "columns": [
                    {
                        "data": "id",
                        "sortable": false,
                        "orderable" : false,
                        render: function (data, type){
                            return '<input type="checkbox"  value="'+data+'" class="box1 check-item-in-dt" >';
                        }
                    },
                    { "data": "user_name",
                        render:function (data, type, row){
                            return '<a href="/dashboard/brands/'+row.id+'" class="_createdAt_table">'+data+'</a>';
                        }
                    },{ "data": "email" ,
                    "sortable": false,
                        render: function(data){
                            return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-envelope"></i> - ${data} </span>
                            `
                        }
                    },
                    {
                        "data": 'status',
                        "sortable": false,
                        "className" : 'switch_parent',
                        render :function (data,type){
                            if(data){
                                if(data == 1){
                                    return  `<span class="badge badge-pill badge-success status_toggle status-active"  title="active" >active</span>`
                                }else if(data == 0){
                                    return  `<span class="badge badge-pill badge-primary status_toggle status-pending"  title="pending" >pending</span> `
                                }else if(data == 3){
                                    return  `<span class="badge badge-pill badge-danger status_toggle status-reject" title="reject" >rejected</span>`
                                }else if (data == 2){
                                    return  `<span class="badge badge-pill status_toggle status-inActive"  title="inactive" style="background-color:#e57c8f !important">inactive</span>`
                                }
                            }else{
                                return  `<span class="badge badge-pill badge-primary status_toggle status-pending"  title="pending" >pending</span> `
                            }
                        }
                    }, {
                        data: 'complete',
                        "sortable": false,
                        render :function (data){
                            let icon = '';
                            if(data == '1'){
                                icon = '<i style="color: #22c03c;font-size: 22px;" class="icon-beenhere"></i>';
                            }else{
                                icon = '<i style="color: #ee335e;font-size: 22px;" class="icon-circle-with-cross"></i>';
                            }
                            return icon;
                        }
                    },
                    {
                        "data": "country_id",
                        "sortable": false,
                        render :function (data,type){
                            if(data.length > 0){
                                // console.log(data);
                                // return data.code.split(",").map();

                                let dataMap = data.map((e)=>{

                                    let el =  `
                                        <span style="color:white" class="_createdAt_table">${e.code.toUpperCase() }</span>
                                   `;
                                    return el;
                                })
                                let temp = `<span class="flag-container">
                                       ${dataMap}
                                    </span>`
                                return temp;
                            }
                            return '..'

                        }
                    },
                    {
                        "data":"group_of_brands",
                        render :function (data){
                            return `<span class="_createdAt_table">${data}</span>`;
                        }
                    }, {
                        data:"campaigns_count",
                        render :function (data){
                            if(data.total != 'undefined' && data.total != undefined){
                                return `<div class="row">
                                            <div class="col-12">
                                                <span class="_createdAt_table">${ data.total}</span>
                                            </div>
                                        </div>`;
                            }else{
                                return '__'
                            }
                        }
                    },
                    {
                        "data":'expirations_date',
                        render: function(data){
                            return `
                            <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `
                        }
                    },
                    {
                        "data":'created_at',
                        render: function(data){
                            return `
                            <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `
                        }
                    } @if(user_can_control('brands')),
                    {
                        "data":"id",
                        'className': "actions",
                        "sortable": false,
                        render:function (data,type){
                            let route_edit = 'brands/'+data+'/edit'
                            let route_group = 'groups/'+data
                            let route_details = 'brands/'+data
                           return `<td>
                               <div class="btn_action">
                                @can('update brands')
                                    <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn-success btn-sm mt-2 mb-2" data-toggle="tooltip" data-placement="top" title="Edit Brand">
                                       <i class="icon-edit-3 text-success" style="font-size:16px;"></i>
                                    </a>
                                @endcan

                                @can('read brands')
                                   <a style="background:transparent !important;width:2px !important;" href="${route_details}" class="btn-warning btn-sm mt-2 mb-2 pb-2"  data-toggle="tooltip" data-placement="top" title="Show Brand"">
                                        <i class="icon-eye1 text-warning" style="font-size:16px;"></i>
                                    </a>
                                @endcan

                                @can('delete brands')
                                    <button style="background:transparent !important;width:2px !important;border:none !important;" class="btn-danger btn-sm mt-2 mb-2 delRow" data-id="${data}" id="del-${data}"  data-toggle="tooltip" data-placement="top" title="Delete Brand">
                                        <i class="icon-trash-2 text-danger" style="font-size:16px;"></i>
                                     </button>
                                 @endcan
                                </div>
                           </td>`;

                        }
                    }@endif
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                   loadingRecords: "Please wait - loading...",
                }
            });
            // new $.fn.dataTable.FixedHeader( brand_tabels );

            $('#brand_table_length').append('<input type="text" id="custom" placeholder="Search"/>')

        });



        //Switch
        $('#brand_table tbody').on( 'change', '.switch', function (event) {
            let id = $(this).data('id');
            activeToggle(id);
        })
        //active toggle request
        function activeToggle(id){
            $.ajax({
                url:`/dashboard/brands-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "Status changed Successfully!", "success");
                    brand_tabels.clear();
                    brand_tabels.ajax.reload();
                    brand_tabels.draw();
                },
                error:()=>{
                    Swal.fire("error", "Something went wrong please reload page", "error");
                }
            })
        }
        //FUNCTION SWAL TO DELETE BRAND
        function swalDel(id){
            Swal.fire({
                title: "Are you sure you want delete?",
                text: "You won't be able to restore this data",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function(result){
                if (result.isConfirmed){
                    $.ajax({
                        url:`/dashboard/brands/${id}`,
                        type:'delete',
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:(data)=>{
                            if(data.flag == -1){
                                Swal.fire("Error", "Cannot delete the brand because it has active campaigns", "warning");
                            }else{
                                Swal.fire("Deleted", "Deleted Successfully!", "success");
                                brand_tabels.ajax.reload();
                            }

                        },
                        error:()=>{
                            Swal.fire("Error", "Something went wrong, please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Canceled", "Canceled successfully!", "error");
                }
            })
        }

        //DELETE BRAND
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'));

        });




        function exportBrandExcel(event){
          event.preventDefault()
          let visibleColumns = []
          let selected_ids = getCheckedItemsInDataTableFromSession();

          brand_tabels.columns().every( function () {
              var visible = this.visible();

               if (visible){
                    if((this.header().innerHTML != 'Actions')){
                        var header = this.header().innerHTML.trim();
                        if((header != '<input type="checkbox" id="select_all" name="select_all">')){
                            let text = this.header().getAttribute('date-export')
                            if(text != null){
                            visibleColumns.push(text)
                            }
                        }
                    }

                }


          });

            let dataObj = {
                selected_ids: selected_ids.length > 0 ? selected_ids : null,
                country_val: $("#all_country_id_search").val(),
                status_val: $("#status_id_search").val(),
                camp_val: $("#campaign_id_search").val(),
                startDateSearch: $("#startDateSearch").val(),
                endDateSearch: $("#endDateSearch").val(),
                profile_completed_val: $("#completed_profile_search").val(),
            };

            let query = `{{route('dashboard.brands.export')}}?visibleColumns=${visibleColumns}`;
            for (let key in dataObj) {
                if (dataObj[key]) {
                    query += `&${key}=${dataObj[key]}`;
                }
            }

            window.open(query);
      }

      // $(function (){
      //     const searchParams = new URLSearchParams(window.location.search)
      //     searchParams.forEach((value, key) => {
      //         $("data-filter=['"+key+"']").val(value).trigger("change");
      //     });
      // });

        $(function (){
            updateFilterFormQueryString();
        })



    </script>

    <!-- <script>
        function testResults() {
            if(" $('#brand_table').find('input:checked').length === 0"){
                $('.btn_sec').css("display", "none")
            }
            else{
                $('.btn_sec').css("display", "block")
            }
        }
    </script> -->


@endsection


