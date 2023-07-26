@extends('admin.dashboard.layouts.app')

@section('title','Brands')


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
        #exampleTbl i{
            font-size: 23px;
        }
        #exampleTbl .actions a i,#exampleTbl .actions button i{
            font-size: 14px;
        }
        #exampleTbl .actions a,#exampleTbl .actions button{
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

    </style>
@endsection

@section('page-header')
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Brands'])
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                        <div class="create_import">
                            @can('create sub-brands')
                            <a href="{{route('dashboard.sub-brands.create')}}" class="btn  create_influ pb-2">
                                <i class="fas fa-plus"></i> Create
                            </a>
                            <button type="button" class="btn " id="imports"  data-toggle="modal" data-target="#import_excels">
                                    <i class="fas fa-file"></i> import
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
                    @include('admin.dashboard.sub-brands.filter-form')
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <div class="zoom-container">
                            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <div class="grand-brand-table">
                            <table id="exampleTbl" class="table custom-table resizable">
                                <thead>
                                <tr>
                                    <th> <input type="checkbox" id="select_all"  name="select_all" /></th>
                                    <th data-tablehead="name" class="border-bottom-0">Name</th>
                                    <th data-tablehead="brand_name"   class="border-bottom-0">Company Name</th>
                                    <th data-tablehead="phone"   class="border-bottom-0">Phone</th>
                                    <th data-tablehead="whats_app"   class="border-bottom-0">Whats App</th>
                                    <th data-tablehead="status"   class="border-bottom-0">Status</th>
                                    <th data-tablehead="countries"   class="border-bottom-0">Countries</th>
                                    <th data-tablehead="created_at"   class="border-bottom-0">Created At</th>
                                    @if(user_can_control('sub-brands'))
                                        <th class="border-bottom-0 actions">Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        @include('admin.dashboard.sub-brands.index-modal')
                    </div>
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
                        Edit Brand
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="text" type="hidden" id="influe_all_id" name="influe_all_id" value=''>

                    <div class="col_change">
                        <div class="form-group form_change">
                            <label class="form-label">Active: <span class="tx-danger">*</span></label>
                            <select class="form-control " id="bulk_active"  name="bulk_active" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                <option value="1">Active</option>
                                <option value="-1">InActive</option>
                            </select>

                        </div>
                        <div class="form-group form_change">
                            <label class="form-label">Expiration Date: <span class="tx-danger">*</span></label>
                            <input class="form-control" name="bulk_expirations_date" id="bulk_expirations_date" placeholder="Enter Date" type="date">

                        </div>
                    </div>
                    <div class="col_change">
                        <div class="form-group form_change">
                            <select class="form-control select2 @if($errors->has('gender'))  parsley-error @endif" id="bulk_gender"  name="bulk_gender" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="both">Both</option>
                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_edit_all" class="btn">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    <script>
        $('#startDateSearch').val('');
        $('#endDateSearch').val('');
        let subBrandTbl=null;
        $(document).ready(function (){
            let selectedIds = [];

            let subbrand_status_filter = null;
            $('.status_influencer_statistic').on('click', function(event) {
                subbrand_status_filter = $(this).attr('value');
                $('#status_id_search').val(subbrand_status_filter).trigger('change')
                $('html, body').animate({
                    scrollTop: ($("#exampleTbl_wrapper").offset().top)
                }, 1000);
                $('#exampleTbl').DataTable().ajax.reload();
            });

            // datatable render
             subBrandTbl = $('#exampleTbl').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                "drawCallback": function( settings ) {
                     recheckedInputsStoredInDatatableSession()
                 },
                dom: 'Blfrtip',
                "buttons": [
                    'colvis',
                ],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                'order': [[7, 'desc']],
                ajax: {
                    url :'/dashboard/sub-brand',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.status_val = $('#status_id_search').val();
                        d.country_val = $('#country_id_search').val();
                        d.start_date = $('#startDateSearch').val();
                        d.end_date = $('#endDateSearch').val();
                        d.brands_status = $('#brands_status').val();
                        addCheckedItemsInDataTableToSession();
                        recheckedInputsStoredInDatatableSession();
                    }
                },
                columns: [
                    {
                        "data": "id",
                        sortable:false,
                        orderable: false,
                        render:function (data,type){
                            return `<input type="checkbox" class="select_all check-item-in-dt"  name="ids[]" value='${data}' />`;
                        }
                    },
                    {
                        data: 'name',
                        render :function (data,type,full){
                            return `
							<a href="{{ url('dashboard/sub-brands')}}${'/'+full['id']}">
							        <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="image">
                                <span class="_username_influncer">${data}</span>
                                </a>
                               `;
                        }
                    },
                    {
                        data: 'brand_name',
						name:'brands.name',
                            render :function (data,type,full){
                            if(data !== "not found"){
                                return `<a href="/dashboard/brands/${full['brand_id']}" class="_username_influncer">${data}</a>`;
                            }else{
                                return data;
                            }

                            }
                    },
                    {data: 'phone',
                        sortable:false,
                        render: function(data){
                            return `
                                <span class="_phone_table"> <i class="fa-solid fa-phone"></i> - ${data}</span>
                            `
                        }
                    },
                    {data: 'whats_number',
                        sortable:false,
                        render: function(data){
                            return `
                                <span class="_phone_table"> <i class="fa-brands fa-whatsapp"></i> - ${data}</span>
                            `
                        }
                    },
                    {
                        "data": 'active_data',
						'name':"status",
                        "className" : 'switch_parent',
                        sortable:false,
                        render :function (data,type){
                            if(data.active == 1){
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}">
                                        <label class="switch" for="'switch-'${data.id}" title="active" ></label>`
                            }else{
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle"  data-id="${data.id}">
                                            <label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                            }
                        }
                    },
                    {
                        data: 'country_id',
                        sortable:false,
                        render :function (data,type){
                            if(data !=null){
                                let dataMap = data.map((e)=>{

                                    let el =  `
                                        <span style="color:white" class="_username_influncer">${e.code.toUpperCase() }</span>
                                   `;
                                    return el;
                                })
                                let temp = `<span>
                                       ${dataMap}
                                    </span>`
                                return temp;
                            }
                            return '..'

                        }
                    },
                    {data: 'created_at',
                        render: function(data){
                            return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `
                        }
                    }
					@if(user_can_control('sub-brands')),
                    {
                        "data": "id",
                        'className': "actions",
                        sortable:false,
                        render:function (data,type){
                            let route_edit = 'sub-brands/'+data+'/edit';
                            return `<td>
                                @can('update sub-brands')
                                    <a href="${route_edit}" class="btn btn-primary-gradient mt-2 mb-2 pb-2 grand-table-button ">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete sub-brands')
                                    <button class="btn btn-danger-gradient mt-2 mb-2 delRow grand-table-button " id="del-${data}" data-id="${data}" >
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                @endcan
                                <a href="{{ url('dashboard/sub-brands')}}${'/'+data}" class="grand-table-button ">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>`;
                        }
                    },@endif
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })
            // delete row
            $(document).on('click','.delRow',function (){
                swalDel($(this).data('id'));
            });
            // select all
            $('#exampleTbl input[name="select_all"]').click(function () {
                $('#exampleTbl td input[class="select_all"]').prop('checked', this.checked);
            });
            // modal
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var data = button.data('whatever') // Extract info from data-* attributes
                var title = button.data('title') // Extract info from data-* attributes
                let temp = '';
                var modal = $(this)
                modal.find('.modal-title').text(title)
                if(title == 'countries'){
                    data.forEach((e)=> {temp += `<li>${e.name}</li>`});
                    modal.find('.modal-body').html(`<ul>${temp}</ul>`)
                }
                else if(title == 'social links'){
                    for(let item in data){
                        temp += `<li><a href='${data[item]}'>${item}</a></li>`
                    }
                    modal.find('.modal-body').html(`<ul>${temp}</ul>`)
                }
            })
            // delete all toggle
            $('#btn_delete_all').click(function (){
                selectedIds = $("#exampleTbl td input.select_all:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedIds.length)
                    swalDel(selectedIds)
                else
                    Swal.fire("Error", "Please select one gropu at least!", "error");
            })
            $('#country_id_search,#brands_status,#bulk_active,#bulk_gender,#status_id_search').select2({
                placeholder: "Select",
                allowClear: true,
            });
            $('#bulk_gender,#bulk_active').val("").trigger('change')



            $(document).on('click','#import_excel_btn',function (e){
                let import_excel = $('#import_excel').val();
                if(import_excel == '' || import_excel == null){
                    e.preventDefault();
                    Swal.fire("Cancelled", "Please choose excel file!", "warning");
                }else{
                    $('#submit_import_form').submit();
                }
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
                    Swal.fire("Cancelled", "Please select one influencer at least!", "warning");
                }
            });

            $(document).on('click','#submit_edit_all',function (){
                let selected_ids =  $('input[id="influe_all_id"]').val();
                let bulk_active =  $('#bulk_active').val();
                let bulk_expirations_date =  $('#bulk_expirations_date').val();
                let bulk_gender =  $('#bulk_gender').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.sub-brand.edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_expirations_date:bulk_expirations_date,bulk_gender:bulk_gender},
                    dataType: 'json',
                    success: function (data) {
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_expirations_date").val("").trigger("change")
                            $("#bulk_gender").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            subBrandTbl.ajax.reload();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $(function(){

           $('#reset_sub_brand').on('click', function() {
            $('#country_id_search').val(null).trigger('change');
            $('#status_id_search').val(null).trigger('change');
            $('#campaign_type_search').val(null).trigger('change');
            $('#reportrange span').empty();
            $('#startDateSearch').val('');
            $('#endDateSearch').val('');
            $('#brands_status').val(null).trigger('change');
            subBrandTbl.ajax.reload();
            });

        });
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
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD'
                },
                ranges: {
                    // 'All': ['', ''],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment()],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
                }
            }, cb);
            cb(start, end);
            $("#reportrange").on('click', function (){
                start = moment().subtract(29, 'days');
                end = moment();
                console.log(start)
                console.log(end)
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
                $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
            })
            $(document).on('click','#filter',function (e){
                e.preventDefault();
                subBrandTbl.ajax.reload();
            })
            $(document).on('click','#rest',function (){
                $('#country_id_search').val(null).trigger('change');
                $('#campaign_status').val(null).trigger('change');
                $('#status_id_search').val(null).trigger('change');
                $('#reportrange span').empty();
                $('#startDateSearch').val('');
                $('#endDateSearch').val('');
                subBrandTbl.ajax.reload();
            });
   $(document).on('click','#totalSubBrands',function(){
     console.log(321);
     $('#status_id_search').val(null);
        subBrandTbl.ajax.reload();
    });

     $(document).on('click','#activeSubBrands',function(){
         console.log(321);
        $('#status_id_search').val(1);
        subBrandTbl.ajax.reload();
    });

    $(document).on('click','#inactiveSubBrands',function(){
     console.log(321);
     $('#status_id_search').val(2);
        subBrandTbl.ajax.reload();
    });

        })

        //Switch
        $('#exampleTbl tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            activeToggle(id);
        })
        //active toggle request
        function activeToggle(id){
            $.ajax({
                url:`/dashboard/sub-brands-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    subBrandTbl.clear();
                    subBrandTbl.ajax.reload();
                    subBrandTbl.draw();
                },
                error:()=>{
                    Swal.fire("Error", "Something went wrong please reload page", "error");
                }
            })
        }
    </script>
    <script>
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
        }).then((result) => {
                if (result.isConfirmed){
                    let reqUrl = ``;
                    if(typeof id == "number")
                        reqUrl = `/dashboard/sub-brands/${id}`;
                    else if(typeof id == "object")
                        reqUrl = `/dashboard/sub-brands/del`;

                    $.ajax({
                        url:reqUrl,
                        type:'delete',
                        method:'delete',
                        data:{id},
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:()=>{
                            if(typeof id == "number"){
                                let row = $(`#del-${id}`).parents('tr');
                                let child = row.next('.child');
                                row.remove();
                                child.remove();
                            } else if(typeof id == "object"){
                                for (let i of id){
                                    let row = $(`#del-${i}`).parents('tr');
                                    let child = row.next('.child');
                                    row.remove();
                                    child.remove();
                                }
                            }
                            subBrandTbl.ajax.reload()
                            Swal.fire("Deleted!", "Deleted Successfully!", "success");
                        },
                        error:(data)=>{
                            console.log(data,'error');
                            Swal.fire("error", "something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "Canceled successfully!", "error");
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

    <script>
        var tables = document.getElementsByClassName('resizable');
for (var i = 0; i < tables.length; i++) {
  resizableGrid(tables[i]);
}

function resizableGrid(table) {
  var row = table.getElementsByTagName('tr')[0],
    cols = row ? row.children : undefined;
  if (!cols) return;

  table.style.overflow = 'hidden';

  var tableHeight = table.offsetHeight;

  for (var i = 0; i < cols.length; i++) {
    var div = createDiv(tableHeight);
    cols[i].appendChild(div);
    cols[i].style.position = 'relative';
    setListeners(div);
  }

  function setListeners(div) {
    var pageX, curCol, nxtCol, curColWidth, nxtColWidth, tableWidth;

    div.addEventListener('mousedown', function(e) {

      tableWidth = document.getElementById('exampleTbl').offsetWidth;
      curCol = e.target.parentElement;
      nxtCol = curCol.nextElementSibling;
      pageX = e.pageX;

      var padding = paddingDiff(curCol);

      curColWidth = curCol.offsetWidth - padding;
      //  if (nxtCol)
      //nxtColWidth = nxtCol.offsetWidth - padding;
    });

    div.addEventListener('mouseover', function(e) {
      e.target.style.borderRight = '2px solid #0000ff';
    })

    div.addEventListener('mouseout', function(e) {
      e.target.style.borderRight = '';
    })

    document.addEventListener('mousemove', function(e) {
      if (curCol) {
        var diffX = e.pageX - pageX;

        // if (nxtCol)
        //nxtCol.style.width = (nxtColWidth - (diffX)) + 'px';

        curCol.style.width = (curColWidth + diffX) + 'px';
        console.log(curCol.style.width)
        console.log(tableWidth)
        document.getElementById('exampleTbl').style.width = tableWidth + diffX + "px"
      }
    });

    document.addEventListener('mouseup', function(e) {
      curCol = undefined;
      nxtCol = undefined;
      pageX = undefined;
      nxtColWidth = undefined;
      curColWidth = undefined
    });
  }

  function createDiv(height) {
    var div = document.createElement('div');
    div.style.top = 0;
    div.style.right = 0;
    div.style.width = '5px';
    div.style.position = 'absolute';
    div.style.cursor = 'col-resize';
    div.style.userSelect = 'none';
    div.style.height = height + 'px';
    return div;
  }

  function paddingDiff(col) {

    if (getStyleVal(col, 'box-sizing') == 'border-box') {
      return 0;
    }

    var padLeft = getStyleVal(col, 'padding-left');
    var padRight = getStyleVal(col, 'padding-right');
    return (parseInt(padLeft) + parseInt(padRight));

  }

  function getStyleVal(elm, css) {
    return (window.getComputedStyle(elm, null).getPropertyValue(css))
  }
};
    </script>



@endsection

