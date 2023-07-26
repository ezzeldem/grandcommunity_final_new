@extends('admin.dashboard.layouts.app')

@section('title','Offices')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
@endsection

{{--@section('page-header')--}}
{{--    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'offices'])--}}
{{--@stop--}}

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="t-header">@yield('title') Table</h4>
                        <div class="create_import">
                            @can('create offices')
                                <button type="button" class="btn OfficeToggleModal" data-type="POST" id="AddOffice" data-toggle="modal" data-target="#OfficeModal">
                                    <i class="fa fa-plus"></i> Add Office
                                </button>
                                {{--  <button type="button" class="btn" id="imports"  data-toggle="modal" data-target="#import_excels">
                                    <i class="icon-share-alternitive"></i> import
                                </button>  --}}
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
                    @include('admin.dashboard.offices.filter-form')
                </div>
                <div class="card-body">
                <div class="table-container">
                        <div class="zoom-container">
                            <button onclick="$('.table-container').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    <div class="table-responsive">
                        <table id="officesTable" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th> <input type="checkbox" id="select_all"  name="select_all" /></th>
                                <th class="border-bottom-0">name</th>
                                <th class="border-bottom-0">Country</th>
                                <th class="border-bottom-0">status</th>
                                <th class="border-bottom-0">Total Offices</th>
                                @if(user_can_control('offices'))
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
    @include('admin.dashboard.admins.bulk_edit_modal')
    @include('admin.dashboard.offices.models.office_data')
@endsection

@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script>
        let officesTable = null;
        $(document).ready(function (){

            $('a.export').on('click', function(e) {
                e.preventDefault();

                // get selected rows from table
                let selected = [];
                $("#officesTable > tbody input[name='ids[]']:checked").each(function() {
                selected.push($(this).val());
            });

            // put selectedids in url
            let url = $(this).attr('href');
            url += '?selectedids=' + selected.join(',');

            window.location.href = url;
        });


            let selectedIds = [];
            let authId = "{{auth()->id()}}";
            // datatable render
            officesTable = $('#officesTable').DataTable({
                 fixedHeader: {
                     header: true,
                 },
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
                // 'aaSorting': [[1, 'asc']],
                ajax: {
                    url :'/dashboard/get-offices',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.status_val = $('#status_id_search').val();
                        d.start_date = $('#startDateSearch').val();
                        d.end_date = $('#endDateSearch').val();
                    }
                },
                columns: [
                    {
                        "data": "id",
                        sortable:false,
                        render:function (data){
                            return `<input type="checkbox" class="box1"  name="ids[]" value='${data}' />`;
                        }
                    },
                    {data: 'name',
                            render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {
                        data: 'country',
                        sortable:false,
                        render :function (data,type){
                            return `<span class="_country_table">${data.name}</span>`;
                        }
                    },
                    {
                        "data": 'status',
                        "className" : 'switch_parent',
                        sortable:false,
                        render :function (data,type){
                            if(data.status == 1){
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="active"></label>`
                            }else{
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle"  data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                            }
                        }
                    },
                    {
                        "data": 'offices_count',
                        render :function (data,type){
                            return `<span class="_country_table">${data}</span>`;
                        }
                    },
                    {
                        "data": "id",
                        sortable:false,
                        render:function (data){
                            let route_edit = 'offices/'+data+'/edit'
                            let delBtn = (authId != data)?`<button style="background:transparent !important;width:2px !important;" class="btn mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                  <i class="icon-trash-2" style="font-size: 16px;color:#fff !important"></i>
                                 </button>`:``;
                            return `<td>
                                        <div class="btn_action">
                                            @can('update offices')
                                                <button type="button" class="btn mt-2 mb-2 pb-2 OfficeToggleModal" id="UpdateOffice" data-type="PUT" data-toggle="modal" data-target="#OfficeModal" data-id="${data}">
                                                    <i class="icon-edit-3" style="font-size: 16px;color:#fff !important"></i>
                                                </button>
                                            @endcan
                                            @can('delete offices')
                                                ${delBtn}
                                            @endcan
                                        </div>
                                    </td>`;
                        }
                    },

                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })

            $(document).on('click', '.OfficeToggleModal', function(){
                var type = $(this).data('type');
                if(type == 'POST'){
                    $('#TaskForm').attr('action',"{{ route('dashboard.offices.store') }}");
                    $('#TaskForm').attr('method',type);
                }else if(type == 'PUT'){
                    var id = $(this).data('id');
                    $('#TaskForm').attr('action',"{{ url('dashboard/offices') }}"+"/"+id);
                    $('#TaskForm').attr('method',type);
                    $.ajax({
                        url:"{{ url('dashboard/getOffice') }}"+"/"+id,
                        type:"get",
                        data:{"id":id},
                        success:function(res){
                            $('#TaskForm input[name=name]').val(res['name']);
                            $('#office_country').select2().val(res['country']).trigger("change");
                            $('#office_status').select2().val(res['status']).trigger("change");
                        }
                    });
                }
                $('#OfficeModal').modal('show');
            });
            // delete row
            $(document).on('click','.delRow',function (){
                swalDel($(this).data('id'));
            });
            // select all
            $('#officesTable input[name="select_all"]').click(function () {
                $('#officesTable td input[class="box1"]').prop('checked', this.checked);
            });
            // filter form toggle
            $('#filter').click(function (){
                if($('#filter-form').css('display') == 'flex'){
                    $('#filter-form').css({'display':'none', 'height':0})
                }else{
                    $('#filter-form').css({'display':'flex', 'height':'auto'})
                }
            })
            // import form
            $(document).on('click','#import_excel_btn',function (e){
                let import_excel = $('#import_excel').val();
                if(import_excel == '' || import_excel == null){
                    e.preventDefault();
                    Swal.fire("Error", "Please select an Excel File", "error");
                }else{
                    $('#submit_import_form').submit();
                }
            });
            // delete all toggle
            $('#del-All').click(function (){
                selectedIds = $("#officesTable td input.box1:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedIds.length)
                    swalDel(selectedIds)
                else
                    Swal.fire("error", "please select an account first", "error");
            })

            ///////////////////////////////////////////// edit bulk ///////////////////
            $(document).on('click','#btn_edit_all',function (){
               var selected = new Array();
               $("#officesTable input[type=checkbox]:checked").each(function() {
                   if(this.value!='on'){
                       selected.push(this.value);
                   }
               });
               if (selected.length > 0) {
                   $('#edit_all').modal('show')
                   $('input[id="influe_all_id"]').val(selected);
               }else{
                   Swal.fire("Error", "Please select an account first", "error");
               }
            });

            $(document).on('click','#submit_edit_all',function (){
               let selected_ids =  $('input[id="influe_all_id"]').val();
               let bulk_active =  $('#bulk_active').val();
               let bulk_role_id =  $('#bulk_role_id').val();
               $.ajax({
                   type: 'POST',
                   headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                   url: `{{route('dashboard.offices.edit_all')}}`,
                   data: {
                    selected_ids:selected_ids,
                    bulk_active:bulk_active,
                    bulk_role_id:bulk_role_id
                },
                   dataType: 'json',
                   success: function (data) {
                       if(data.data){
                           $('#edit_all').modal('hide')
                           $("#bulk_active").val("").trigger("change")
                           $("#bulk_role_id").val("").trigger("change")
                           Swal.fire("Updated!", "Update Successfully!", "success");
                           officesTable.clear();
                           officesTable.ajax.reload();
                           officesTable.draw();
                       }
                   },
                   error: function (data) {
                       console.log(data);
                   }
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
                ranges: {
                    'All': ['', ''],
                    'Today': [moment(), moment().add(1, 'years')],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
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
            // search
            $(document).on('click','#go_search',function (e){
                console.log(3)
                e.preventDefault();
                officesTable.clear();
                officesTable.ajax.reload();
                officesTable.draw();
            })

            //select2
            $('#status_id_search,#bulk_active,#bulk_role_id').select2({
                placeholder: "Select",
                allowClear: true,
            });
            $('#bulk_active,#bulk_role_id').val("").trigger("change");
            // reset search form
            $(document).on('click','#rest',function (){
                $('#status_id_search').val(null).trigger('change');
                $('#reportrange span').empty();
                $('#startDateSearch').val('');
                $('#endDateSearch').val('');
                officesTable.clear();
                officesTable.ajax.reload();
                officesTable.draw();
            })
        })
        //Switch
        $('#officesTable tbody').on('change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            activeToggle(id);
        })
        //active toggle request
        function activeToggle(id){
            $.ajax({
                url:`/dashboard/offices-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    officesTable.clear();
                    officesTable.ajax.reload();
                    officesTable.draw();
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
               }).then(function (result){
                   if (result.isConfirmed){
                       let reqUrl = ``;
                       if(typeof id == "number")
                           reqUrl = `/dashboard/offices/${id}`;
                       else if(typeof id == "object")
                           reqUrl = `/dashboard/del-all/offices`;
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

      tableWidth = document.getElementById('officesTable').offsetWidth;
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
        document.getElementById('officesTable').style.width = tableWidth + diffX + "px"
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
