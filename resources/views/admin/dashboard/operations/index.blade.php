@extends('admin.dashboard.layouts.app')

@section('title','Operations')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
@endsection

{{--@section('page-header')--}}
{{--    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'operations'])--}}
{{--@stop--}}

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="t-header">@yield('title') Table</h4>
                        <div class="create_import">
                            @can('create operations')
                                <a href="{{route('dashboard.operations.create')}}" class="btn  pd-x-20 mg-t-10">
                                    <i class="icon-plus-circle"></i> Create
                                </a>
                                <button type="button" class="btn" id="imports"  data-toggle="modal" data-target="#import_excels">
                                    <i class="icon-share-alternitive"></i> import
                                </button>
                                <!-- @if(auth()->user()->roles[0]->type == 'admin'|| auth()->user()->roles[0]->name == 'operationManager' || auth()->user()->roles[0]->name == 'superCommunity')
                                <button type="button" class="btn" id="community_tasks"  data-toggle="modal" data-target="#communityTasks">
                                    <i class="icon-share-alternitive"></i> Add New Task
                                </button>
                                @endif -->
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
                    @include('admin.dashboard.operations.filter-form')
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
                                <th class="border-bottom-0">name</th>
{{--                                <th class="border-bottom-0">image</th>--}}
                                <th class="border-bottom-0">username</th>
                                <th class="border-bottom-0">email</th>
                                <th class="border-bottom-0">status</th>
                                @if(user_can_control('operations'))
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
    @include('admin.dashboard.operations.models.add_new_task')
@endsection

@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script>
        let operationTbl = null;
        $(document).ready(function (){
            // click on a link with prevent default
        $('a.export').on('click', function(e) {
            e.preventDefault();

            // get selected rows from table
            let selected = [];
            $("#exampleTbl > tbody input[name='ids[]']:checked").each(function() {
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
             operationTbl = $('#exampleTbl').DataTable({
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
                    url :'/dashboard/get-operations',
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
                        data: 'name',
                        render :function (data,type,full){
                            return `
                                <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="image">
                                <span class="_username_influncer">${data}</span>`;
                        }
                    },
                    // {
                    //     data: 'image',
                    //     render :function (data){
                    //         return `<img src="${data}" class="img-thumbnail" height="30" width="30" alt="">`;
                    //     }
                    // },
                    {
                        data: 'username',
                        render :function (data){
                            return `
                                <span class="_username_influncer">${data}</span>`;
                        }
                    },
                    {
                        data: 'email',
                        sortable:false,
                        render :function (data){
                            return `
                                <span class="_username_influncer">${data}</span>`;
                        }
                    },
                    {
                        "data": 'active_data',
                        "className" : 'switch_parent',
                        sortable:false,
                        render :function (data,type){
                            if(data.active == 1){
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="active" ></label>`
                            }else{
                                return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle"  data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                            }
                        }
                    },
                    {
                        "data": "id",
                        sortable:false,
                        render:function (data){
                            let route_edit = 'operations/'+data+'/edit'
                            let delBtn = (authId != data)?`<button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                  <i class="icon-trash-2 text-danger" style="font-size: 16px;"></i>
                                 </button>`:``;
                            return `<td>
                            <div class="btn_action">
                                @can('update operations')
                                <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2 pb-2">
                                   <i class="icon-edit-3 text-success" style="font-size: 16px;"></i>
                                </a>
                                @endcan
                                @can('delete operations')
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
                selectedIds = $("#exampleTbl td input.box1:checkbox:checked").map(function(){
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
                $("#exampleTbl input[type=checkbox]:checked").each(function() {
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
                    url: '{{route('dashboard.operations.edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_role_id:bulk_role_id},
                    dataType: 'json',
                    success: function (data) {
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_role_id").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            operationTbl.clear();
                            operationTbl.ajax.reload();
                            operationTbl.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $('#AddTaskForm').on('submit', function(e){
                e.preventDefault();
                var form = $(this);
                $(this).ajaxSubmit({
                    url:"{{ route('dashboard.operation.store.task') }}",
                    type:"post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },success:function(res){
                        if(res['status']){
                            Swal.fire("Updated!", `${res['message']}`, "success");
                            $('#OperationTasks').modal('toggle');
                            $('#OperationTasks').find('form').trigger('reset');
                        }else{
                            console.log(res['errors']);
                            crud_handle_validation_errors(res,form);
                        }
                    },error:function(data){
                        crud_handle_server_errors(data,form);
                    }
                })
            });

            window.crud_handle_server_errors = function(data, form = null) {
                var statusCode = data.status;
                switch (statusCode) {
                    case 422: // validation error.
                        crud_handle_validation_errors(data, form);
                    break;
                    case 401: // Authentication error.
                    case 500:
                        alert('server error','danger');
                    break;
                    case 419: // .
                        alert('CSRF Token mismatch','danger');
                    break;
                    case 419: // .
                        alert('CSRF Token mismatch','danger');
                    break;
                    default: // unknown error
                        alert('server error','danger');
                }
            }

            window.crud_handle_validation_errors = function(data, form = null) {
                console.log(data.errors);
                var keys = $.map( data.errors, function( value, key ) {
                    return value;
                });
                var errors = data.errors;
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('.error-validation').remove();
                $('.invalid-error').remove();
                $.each(errors, function(key, value) {
                    // console.log('success',form.find('[id^="list_id_"]'));
                    var input = form != null ? form.find(':input[name="' + key + '"]') : $(':input[name="' + key + '"]');
                    var select = form != null ? form.find('select[name="' + key + '"]') : $('select[name="' + key + '"]');
                    if(input.length > 0){
                        if(input.hasClass('datepicker') || input.attr('type') == 'date'){
                            input.addClass('is-invalid');
                            input.parent('div').parent('div').find("div.error-validation").remove();
                            input.parent('div').after("<div class='col-md-12 text-center error-validation'><span class='text-danger' role='alert'><strong>" + value[0] + "</strong></span></div>");
                        }else if(input.attr('type') == 'number'){
                            input.addClass('is-invalid');
                            input.parent('div').parent('div').find("div.error-validation").remove();
                            input.parent('div').after("<div class='col-md-12 text-center error-validation'><span class='text-danger' role='alert'><strong>" + value[0] + "</strong></span></div>");
                        }else if(input.attr('type') == 'file'){
                            input.addClass('is-invalid');
                            input.parent('div').parent('div').find("div.error-validation").remove();
                            input.parent('div.custom-file').parent('div').after("<div class='col-md-12 text-center error-validation'><span class='text-danger' role='alert'><strong>" + value[0] + "</strong></span></div>");
                            console.log(input.find('div.custom-file'));
                        }else{
                            input.addClass('is-invalid');
                            input.parent('div').parent('div').find("div.error-validation").remove();
                            input.parent('div').after("<div class='col-md-12 text-center error-validation'><span class='text-danger' role='alert'><strong>" + value[0] + "</strong></span></div>");
                        }
                    }

                    //if(select.length > 0){
                    //    $('select[name="' + key + '"]').removeClass('select2-hidden-accessible');
                    //        select.addClass('is-invalid');
                    //        $(select).next("span").remove();
                    //        select.parent('div').after("<div class='col-md-12 text-center error-validation'><span class='text-danger' role='alert'><strong>" + value[0] + "</strong></span></div>");
                    //}
                    window.scroll({top: 0,left: 0,behavior: 'smooth'});
                });
            }

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
                operationTbl.clear();
                operationTbl.ajax.reload();
                operationTbl.draw();
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
                operationTbl.clear();
                operationTbl.ajax.reload();
                operationTbl.draw();
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
                url:`/dashboard/operations-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    operationTbl.clear();
                    operationTbl.ajax.reload();
                    operationTbl.draw();
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
                           reqUrl = `/dashboard/operations/${id}`;
                       else if(typeof id == "object")
                           reqUrl = `/dashboard/del-all/operations`;
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
                               $('#exampleTbl').DataTable().ajax.reload();
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
