@extends('admin.dashboard.layouts.app')

@section('title','branches')


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
    </style>
@endsection

@section('page-header')
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Branches'])
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
{{--                        <div class="create_import">--}}
{{--                            @can('create branches')--}}
{{--                            <a href="{{route('dashboard.branches.create')}}" class="btn create_influ  pb-2">--}}
{{--                                <i class="fas fa-plus"></i> Create--}}
{{--                            </a>--}}
{{--                            <button type="button" class="btn btn-warning" id="imports"  data-toggle="modal" data-target="#import_excels">--}}
{{--                                <i class="fas fa-file"></i> import--}}
{{--                            </button>--}}
{{--                            @endcan--}}
{{--                       </div>--}}
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
                    @include('admin.dashboard.branches.filter-form')
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
                                <th class="border-bottom-0">name</th>
                                <th class="border-bottom-0">brand name</th>
                                <th class="border-bottom-0">Group Of Brand</th>
                                <th class="border-bottom-0">country</th>
                                <th class="border-bottom-0">state</th>
                                <th class="border-bottom-0">city</th>
                                <th class="border-bottom-0">status</th>
                                <th class="border-bottom-0">Created At</th>

                                {{--                                @if(user_can_control('branches'))--}}
{{--                                <th>Actions</th>--}}
{{--                                @endif--}}
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

    {{-- Edit all  --}}
    <div class="modal fade" id="edit_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Edit Influencer
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
                            <select class="form-control select2 " id="bulk_active"  name="bulk_active" data-show-subtext="true" data-live-search='true'  placeholder="Choose one">
                                <option value="1">Active</option>
                                <option value="-1">InActive</option>
                            </select>

                        </div>
                        <div class="form-group form_change">
                            <label class="form-label">Country: <span class="tx-danger">*</span></label>
                            <select class="form-control " id="bulk_country_id" name="bulk_country_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" >
                                @foreach($all_countries_data as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
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

    <script>
        let subBrandTbl=null;
        $(document).ready(function (){
            let selectedIds = [];
            // datatable render
             subBrandTbl = $('#exampleTbl').DataTable({
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
                'aaSorting': [[8, 'desc']],
                ajax: {
                    url :'/dashboard/get-branches',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.status_val = $('#status_id_search').val();
                        d.country_val = $('#country_id_search').val();
                        d.brand_val = $('#brand_id_search').val();
                        d.subbrand_val = $('#subbrand_id_search').val();
                        d.city_val = $('#city_search').val();
                        d.start_date = $('#startDateSearch').val();
                        d.end_date = $('#endDateSearch').val();
                    }
                },
                columns: [
                    {
                        "data": "id",
                        render:function (data,type){
                            return `<input type="checkbox" class="select_all"  name="ids[]" value='${data}' />`;
                        }
                    },
                    {data: 'name'},
                    {
                        data: 'brand_name',
                        render :function (data,type,full){
                            if(data !== ".."){
                                return `<a href="/dashboard/brands/${full['brand_id']}">${data}</a>`;
                            }else{
                                return data;
                            }

                        }
                    },
                    {data: 'sub_brand_name'},
                    {data: 'country'},
                    {data: 'state'},
                    {data: 'city'},
                    {
                        "data": 'active_data',
                        "className" : 'switch_parent',
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
                    {data: 'created_at'},
                    {{--{--}}
                    {{--    "data": "id",--}}
                    {{--    'className': "actions",--}}
                    {{--    render:function (data,type){--}}
                    {{--        let route_edit = 'branches/'+data+'/edit'--}}
                    {{--        return `<td>--}}
                    {{--            @can('update branches')--}}
                    {{--            <a href="${route_edit}" class="btn -gradient mt-2 mb-2 pb-2">--}}
                    {{--                <i class="far fa-edit"></i>--}}
                    {{--            </a>--}}
                    {{--            @endcan--}}
                    {{--            @can('delete branches')--}}
                    {{--             <button class="btn btn-danger-gradient mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >--}}
                    {{--                <i class="far fa-trash-alt"></i>--}}
                    {{--             </button>--}}
                    {{--             @endcan--}}

                    {{--        </td>`;--}}
                    {{--    }--}}
                    {{--},--}}

                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })
            // delete row
            $(document).on('click','#totalBranches',function (){
            $('#status_id_search').val(null);
            subBrandTbl.ajax.reload();
        });

        $(document).on('click','#activeBranches',function (){
            $('#status_id_search').val(1);
            subBrandTbl.ajax.reload();
        });

        $(document).on('click','#inactiveBranches',function (){
            $('#status_id_search').val(2);
            subBrandTbl.ajax.reload();
        });





            $(document).on('click','.delRow',function (){
                console.log($(this).data('id'));
                swalDel($(this).data('id'));
            });
            // select all
            $('#exampleTbl input[name="select_all"]').click(function () {
                $('#exampleTbl td input[class="select_all"]').prop('checked', this.checked);
            });

            // filter form toggle
            $('#filter').click(function (){
                if($('#filter-form').css('display') == 'flex'){
                    $('#filter-form').css({'display':'none', 'height':0})
                }else{
                    $('#filter-form').css({'display':'flex', 'height':'auto'})
                }
            })

            $(document).on('click','#import_excel_btn',function (e){
                let import_excel = $('#import_excel').val();
                if(import_excel == '' || import_excel == null){
                    e.preventDefault();
                    Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
                }else{
                    $('#submit_import_form').submit();
                }
            });
            // delete all toggle
            $('#btn_delete_all').click(function (){
                selectedIds = $("#exampleTbl td input.select_all:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedIds.length)
                    swalDel(selectedIds)
                else
                    Swal.fire("error", "please select ids", "error");
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
                    Swal.fire("Cancelled", "Please select Influencer!", "warning");
                }
            });

            $(document).on('click','#submit_edit_all',function (){
                let selected_ids =  $('input[id="influe_all_id"]').val();
                let bulk_active =  $('#bulk_active').val();
                let bulk_country_id =  $('#bulk_country_id').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.branches.edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_country_id:bulk_country_id},
                    dataType: 'json',
                    success: function (data) {
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_country_id").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            subBrandTbl.ajax.reload();

                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            $('#country_id_search,#brand_id_search,#subbrand_id_search,#bulk_active,#bulk_country_id').select2({
                placeholder: "Select",
            });
            $('#bulk_active,#bulk_country_id').val("").trigger('change')
            ;

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
                ranges: {
                    'All': ['', ''],
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
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
                $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
            })
            $(document).on('click','#go_search',function (e){
                console.log(3)
                console.log($('#country_id_search').val());
                e.preventDefault();
                subBrandTbl.ajax.reload();
            })
            $(document).on('click','#rest',function (){
                console.log(3);
                $('#country_id_search').val(null).trigger('change');
                $('#status_id_search').val(null).trigger('change');
                $('#brand_id_search').val(null).trigger('change');
                $('#subbrand_id_search').val(null).trigger('change');
                $('#reportrange span').empty();
                $('#reportrange').val('');
                $('#startDateSearch').val('');
                $('#endDateSearch').val('');
                $('#city_search').val('');
                subBrandTbl.ajax.reload();
            })
        });


        $(function(){
                $('#reset_branches').on('click', function() {
                    if ($('#filter-form').find("select".length > 0)) {
                        $('#filter-form').find("select").each(function() {
                        $(this).val(null).trigger("change");
                            $('#reportrange span').empty();
                            $('#startDateSearch').val('');
                            $('#endDateSearch').val('');
                            subBrandTbl.ajax.reload();

                    });
                   }
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
                url:`/dashboard/branches-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    subBrandTbl.clear();
                    subBrandTbl.ajax.reload();
                    subBrandTbl.draw();
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        }
        $(document).ready(function (){
            $('#country_id_search,#brand_id_search,#subbrand_id_search,#status_id_search').select2({
                placeholder: "Select",
                allowClear: true
            });
        })
    </script>
    <script>
        function swalDel(id){
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
            },function(isConfirm){
                if (isConfirm){
                    let reqUrl = ``;
                    if(typeof id == "number")
                        reqUrl = `/dashboard/branches/${id}`;
                    else if(typeof id == "object")
                        reqUrl = `/dashboard/del-all/branches`;
                    $.ajax({
                        url:reqUrl,
                        type:'delete',
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

                            Swal.fire("Deleted!", "Deleted Successfully!", "success");
                        },
                        error:()=>{
                            Swal.fire("error", "something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "canceled successfully!", "error");
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

