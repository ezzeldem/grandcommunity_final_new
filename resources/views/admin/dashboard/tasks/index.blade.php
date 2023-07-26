@extends('admin.dashboard.layouts.app')

@section('title','Tasks')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')

@endsection

{{--@section('page-header')--}}
{{--    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'tasks'])--}}
{{--@stop--}}

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="t-header">@yield('title') Table</h4>
                        <div class="create_import">
                        @if (auth()->user()->roles[0]->type == 'admin'|| auth()->user()->roles[0]->type == 'operations')

                                <a href="{{route('dashboard.tasks.create')}}" class="btn  pd-x-20 mg-t-10">
                                    <i class="icon-plus-circle"></i> Create
                                </a>
                                 <button type="button" class="btn" id="import_excel_btn_task"  data-toggle="modal" data-target="#import_excels_tasks">
                                    <i class="icon-share-alternitive"></i> import
                                </button>
                            @endif

                            <button type="button" class="btn" id="del-All"  data-toggle="modal" data-target="">
                                    <i class="icon-share-alternitive"></i> Delete Selected
                             </button>

                             <button type="button" class="btn" id="edit_All"  data-toggle="modal">
                                    <i class="icon-share-alternitive"></i> Edit Selected
                             </button>

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
                    @include('admin.dashboard.tasks.filter-form')
                </div>
                <div class="card-body">
                <div class="table-container">
                <div class="zoom-container">
                            <button onclick="$('.table-container').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    <div class="table-responsive">
                        <table id="exampleTbl" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th> <input type="checkbox" id="select_all"  name="select_all" /></th>
                                <th class="border-bottom-0">Image</th>
                                <th class="border-bottom-0">Task Description</th>
                                <th class="border-bottom-0">Start Date</th>
                                <th class="border-bottom-0">End Date</th>
                                <th class="border-bottom-0">Priority</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Assigned To</th>
                                @if(user_can_control('tasks'))
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
@endsection

@section('js')

    @include('admin.dashboard.layouts.includes.general.scripts.index')
    @include('admin.dashboard.tasks.modals.Import_excel')
    @include('admin.dashboard.tasks.modals.bulk_edit')
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script>


        let tasksTbl = null;
        $(document).ready(function (){
            let selectedIds = [];
            // datatable render
             tasksTbl = $('#exampleTbl').DataTable({
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
                    url :'/dashboard/get-tasks',
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
                    {
                        data: 'file',
                        render :function (data){
                            return `<a href="${data}" download>
                                        <label class="form-label">Click Here To Download <i class="fa-solid fa-download ml-2"></i></label>
                                    </a>`;
                        }
                    },
                    {
                        data: 'description',
                        render :function (data){
                            return `<span class="_username_influncer">
                                        ${data}
                                    </span>`
                        }
                    },
                    {
                        data: 'start_date',
                        render: function(data){
                        return `
                            <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                        `

                    }
                    },
                    {
                        data: 'end_date',
                        render: function(data){
                        return `
                            <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                        `

                    }
                    },
                    {
                        data: 'priority',
                        render: function(data){
                        return `
                            <span class="_createdAt_table"> ${data} </span>
                        `
                    }
                    },
                    {
                        data: 'status',
                        render: function(data){
                        return `
                            <span class="_createdAt_table"> ${data} </span>
                        `

                    }
                    },
                    {
                         data: "assign_to",

                         render: function(data, type) {
                            let dataMap = data.map((e)=>{
                                let el =  `
                                    <span>${e.name}</span>
                                `;
                                return el;
                            })
                            let temp = `<span class="flag-container" style="">
                                       ${dataMap}
                                    </span>`
                            return temp;
                        }

                    },
                    {
                        "data": "id",
                        render:function (data){
                            let route_edit = 'tasks/'+data+'/edit'
                            let delBtn = `<button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                  <i class="icon-trash-2 text-danger" style="font-size: 16px;"></i>
                                 </button>`;
                            return `<td>
                            <div class="btn_action">
                            @if (auth()->user()->roles[0]->type == 'admin'|| auth()->user()->roles[0]->type == 'operations')
                                <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2 pb-2">
                                   <i class="icon-edit-3 text-success" style="font-size: 16px;"></i>
                                </a>
                                @endif
                                @if (auth()->user()->roles[0]->type == 'admin'|| auth()->user()->roles[0]->type == 'operations')
                                 ${delBtn}
                                 @endif
                                </div>
                            </td>`;
                        }
                    },

                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                },

            });


            // delete row
            $(document).on('click','.delRow',function (){
                swalDel($(this).data('id'));
            });
            // select all
            $('#exampleTbl input[name="select_all"]').click(function () {
                $('#exampleTbl td input[class="box1"]').prop('checked', this.checked);
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
            $(document).on('click','#import_excel_btn_task',function (e){
                let import_excel = $('#import_excel').val();
                if(import_excel == '' || import_excel == null){
                    e.preventDefault();

                }else{
                    $('#submit_import_form').submit();
                }
            });
            // delete all toggle
            $('#del-All').click(function (){
                selectedIds = $("#exampleTbl td input.box1:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedIds.length)
                    swalDel(selectedIds)
                else
                    Swal.fire("error", "please select tasks", "error");
            })

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
                let bulk_role_id =  $('#bulk_role_id').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.operations.edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_role_id:bulk_role_id},
                    dataType: 'json',
                    success: function (data) {
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_role_id").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            tasksTbl.clear();
                            tasksTbl.ajax.reload();
                            tasksTbl.draw();
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
                e.preventDefault();
                tasksTbl.clear();
                tasksTbl.ajax.reload();
                tasksTbl.draw();
            })

            //select2
            $('#status_id_search,#bulk_active,#bulk_role_id').select2({
                placeholder: "Select ....",
                allowClear: true,
            });
            $('#bulk_active,#bulk_role_id').val("").trigger("change");
            // reset search form
            $(document).on('click','#rest',function (){
                $('#status_id_search').val(null).trigger('change');
                $('#reportrange span').empty();
                $('#startDateSearch').val('');
                $('#endDateSearch').val('');
                tasksTbl.clear();
                tasksTbl.ajax.reload();
                tasksTbl.draw();
            })

        })
        //Switch
        $('#exampleTbl tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            activeToggle(id);
        })
        //active toggle request
        function activeToggle(id){
            $.ajax({
                url:`/dashboard/tasks-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    tasksTbl.clear();
                    tasksTbl.ajax.reload();
                    tasksTbl.draw();
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
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
                           reqUrl = `/dashboard/tasks/${id}`;
                       else if(typeof id == "object")
                           reqUrl = `/dashboard/del-all/tasks`;
                       $.ajax({
                           url:reqUrl,
                           type:'post',
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
