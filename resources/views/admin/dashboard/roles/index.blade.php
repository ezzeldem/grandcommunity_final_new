@extends('admin.dashboard.layouts.app')

@section('title','Roles')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
@endsection

{{--@section('page-header')--}}
{{--    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'roles'])--}}
{{--@stop--}}

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center create_import">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                        @can('create roles')
                        <a href="{{route('dashboard.roles.create')}}" class="btn  pd-x-20 mg-t-10 mr-2">
                            <i class="icon-plus-circle"></i> Create
                        </a>
                        @endcan
                    </div>

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
                                    <th class="border-bottom-0">name</th>
                                    <th class="border-bottom-0">Created By</th>
                                    <th class="border-bottom-0">type</th>
                                    <th class="border-bottom-0">Parent Role</th>
                                    <th class="border-bottom-0">Created At</th>
                                    @if(user_can_control('roles'))
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

    <script>
        let salesTbl;
        $(document).ready(function (){
            let selectedIds = [];
            let roleId = "{{auth()->user()->role_id}}";

            // datatable render
             salesTbl = $('#exampleTbl').DataTable({
                fixedHeader: {
                    header: true,
                },
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                dom: 'Blfrtip',
                "buttons": [
                    'colvis'
                ],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                order: [[4, 'desc']],
                ajax: {
                    url :'/dashboard/get-roles',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {

                      console.log(d);
                        d.status_val = $('#status_id_search').val();
                        d.start_date = $('#startDateSearch').val();
                        d.end_date = $('#endDateSearch').val();
                    }
                },
                columns: [
                    {
                        data: 'name',
                        render :function(data){
                            return `
                                <span class="_username_influncer"> ${data} </span>
                            `
                        }
                    },

                    {
                        data : 'user_name',
                        sortable:false,
                        render :function (data){
                            if(data){
                                return `
                                <span class="_username_influncer"> ${data} </span>
                            `;

                            }else{
                                return '--';

                            }

                        }
                    },

                    {
                        data: 'type',
                        sortable:false,
                        render :function(data){
                            return `
                                <span class="_username_influncer"> ${data} </span>
                            `
                        }
                    },
                    {
                        data: 'parent_roles',
                        sortable:false,
                        render :function(data){
                            return `
                                <span class="_username_influncer"> ${data} </span>
                            `
                        }
                    },
                    {
                        data: 'created_at',
                        render :function(data){
                            return `
                                <span class="_username_influncer"> ${data} </span>
                            `
                        }
                    },
                    {
                        "data": "id",
                        sortable:false,
                        render:function (data){
                            let route_edit = 'roles/'+data+'/edit'
                            let delBtn = (roleId != data || data != 1)?`<button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                    <i class="icon-trash-2 text-danger" style="font-size: 16px;"></i>
                                 </button>`:``;
                            let updateBtn = (roleId != data || data != 1)? `<a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2 pb-2">
                                    <i class="icon-edit-3 text-success" style="font-size: 16px;"></i>
                                </a>`:``;
                            return `<td>
                            <div class="btn_action">
                                @can('update roles')
                               ${updateBtn}
                                @endcan
                                @can('delete roles')
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
                swalDel($(this).data('id'), salesTbl)
            });
        })
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
               }).then(function(result){
                   if (result.isConfirmed){
                       $.ajax({
                           url:`/dashboard/roles/${id}`,
                           type:'delete',
                           headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                           success:(data)=>{
                               let row = $(`#del-${id}`).parents('tr');
                               let child = row.next('.child');
                               if(data.status){
                                   row.remove();
                                   child.remove();
                                   Swal.fire("Deleted!", "Deleted Successfully!", "success");
                                   salesTbl.ajax.reload();
                               }
                               else
                                   Swal.fire("Warning!", data.message, "warning");

                           },
                           error:()=>{
                               Swal.fire("error", "something went wrong please reload page", "error");
                           }
                       })
                   } else {
                       Swal.fire("", "Canceled Successfully!", "error");
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




