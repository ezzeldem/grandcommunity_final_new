@extends('admin.dashboard.layouts.app')

@section('title','Contacts')


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
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0;
            gap: 10px;
        }
    </style>
@endsection

@section('page-header')
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Contacts'])
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                    </div>
                    @if(\App\Models\Contact::count())
                        <section class="btn_sec">
                            @can('delete our_sponsors')
                                <button type="button" class="btn hvr-sweep-to-right mt-2" id="btn_delete_all">
                                    <i class="fas fa-trash-alt"></i> Delete
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
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Phone</th>
                                <th class="border-bottom-0">Type</th>
                                <th class="border-bottom-0">country</th>
                                <th class="border-bottom-0">WhatsApp</th>
                                <th class="border-bottom-0">Message</th>
                                <th class="border-bottom-0">Created At</th>
{{--                                @if(user_can_control('our_sponsors'))--}}
                                    <th>Actions</th>
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
                    <h6 style="color:#fff"> Are You Sure You Want to Delete? </h6>
                    <input class="text" type="hidden" id="delete_contact" name="delete_contact" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn Active hvr-sweep-to-right"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_delete" class="btn Delete hvr-sweep-to-right">Delete</button>
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
                        Delete Brands
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 style="color:#fff"> Are You Sure ? </h6>
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
    {{--  end modal delete all   --}}


    <div class="modal fade effect-newspaper show" id="ShowMore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="show_more" style="word-break: break-all;">
                    </p>
                </div>

            </div>
        </div>
    </div>




@endsection
@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')

    <script>
        $(document).ready(function (){


            $(document).on('click','#show_more',function (){
                  $('.show_more').text($(this).attr('data-more'));
            })



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
                    Swal.fire("Cancelled", "Please select a contact first", "warning");
                }
            });

            $(document).on('click','#submit_delete_all',function (){
                let selected_ids =  $('input[id="delete_all_id"]').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.contacts.delete_all')}}',
                    data: {selected_ids:selected_ids},
                    dataType: 'json',
                    success: function (data) {
                        if(data.status){
                            $('#delete_all').modal('hide')
                            Swal.fire("Deleted!", "Deleted Successfully!", "success");
                            Contacts.clear();
                            Contacts.ajax.reload();
                            Contacts.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });



            $(document).on('click','#delete_modal_show',function (){
                $('#delete_modal').modal('show');
                $('#delete_contact').val($(this).attr('data-id'));
            });

            $(document).on('click','#submit_delete',function (){
                var contact_id = $('#delete_contact').val();
                $.ajax({
                    type: 'delete',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url:`/dashboard/contacts/${contact_id}`,
                    success: function (data) {
                        if(data.status){
                            $('#delete_modal').modal('hide')
                            Swal.fire("delete!", "deleted Successfully!", "success");
                            Contacts.clear();
                            Contacts.ajax.reload();
                            Contacts.draw();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            })


            let selectedIds = [];
            // datatable render
            let Contacts = $('#exampleTbl').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                dom: 'Blfrtip',
                "buttons": [
                    'colvis',
                ],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                'order': [[8, 'desc']],
                ajax: {
                    url :'/dashboard/get-contacts',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.status_val = $('#status_id_search').val();
                    }
                },
                columns: [
                    {
                        "data": "id",
                        "sortable": false,
                        "ordable": false,
                        render:function (data,type){
                            return `<input type="checkbox" class="select_all box1"  name="ids[]" value='${data}' />`;
                        }
                    },
                    {data: 'name',
                        render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {data: 'email',
                    "sortable": false,
                        render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {data: 'phone',
                    "sortable": false,
                        render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {data: 'type',render:function (data,type) {
                            return `<span class="_username_influncer">${data}</span>`
                        }
                        },
                    {data: 'country_id',
                    "sortable": false,
                        render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {data: 'whatsapp',
                    "sortable": false,
                        render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {data: 'message',
                    "sortable": false,
                        render:function (data,type){

                          return  `<a type="button" id="show_more"  data-more="${data}" data-toggle="modal" data-target="#ShowMore" class="_username_influncer">
                                         ${data.slice(0, 30)+'  .....'}
                                   </a>`
                        }
                    },
                    {data: 'created_at',
                        render: function(data){
                            return `
                                <span class="_username_influncer">${data}</span>
                            `
                        }
                    },
                    {
                        "data": "id",
                        'className': "actions",
                        "sortable": false,
                        render:function (data,type){
                            let route_edit = 'contacts/'+data+'/edit'
                            return `<td>
{{--                            @can('delete contacts')--}}
                                <button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2" id="delete_modal_show"  data-id="${data}" >
                                    <i class="far fa-trash-alt text-danger" style="font-size:16px;"></i>
                                 </button>
{{--                                 @endcan--}}

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
        })



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

