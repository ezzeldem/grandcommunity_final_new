@extends('admin.dashboard.layouts.app')

@section('title','Statistics')


@section('style')


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
        .lang{
            cursor: pointer;
        }
        .summernote  {
            min-height: 217px !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @include('admin.dashboard.layouts.includes.general.styles.index')

@endsection

@section('page-header')
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Statistics'])
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                @include('admin.dashboard.setting.tabs')
                    <div class="d-flex justify-content-between">
                        @can('delete statistics')
{{--                        <div class="create_import">--}}
{{--                            <a href="{{route('dashboard.pages.create')}}" class="btn create_influ mt-2 mb-2 pb-2">--}}
{{--                                <i class="fas fa-plus"></i> Add Page--}}
{{--                            </a>--}}
{{--                        </div>--}}
                        @endcan
                    </div>

                </div>
                <div class="card-header pb-0 form-statisc">
                    {!! Form::open(['route' => ['dashboard.statistics.store'],'method'=>'post','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page','files'=>true]) !!}
                    @include('admin.dashboard.setting.statistics.form')
                    {!! Form::close() !!}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="statisticsTable" class="table custom-table resizable">
                            <thead>
                            <tr>
{{--                                <th> <input type="checkbox" id="select_all"   name="select_all" /></th>--}}
                                <th>#</th>
                                <th class="border-bottom-0">Title</th>
{{--                                <th class="border-bottom-0">image</th>--}}
                                {{--                                <th class="border-bottom-0">body</th>--}}
                                <th class="border-bottom-0">Count</th>
                                <th class="border-bottom-0">Status</th>
                                @if(user_can_control('statistics'))
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
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    @include('admin.dashboard.setting.statistics.datatable')

    @if(session()->has('successful_message'))
        <script>
            swal("Good job!", "{{session()->get('successful_message')}}", "success");
        </script>
    @elseif(session()->has('error_message'))
        <script>
            swal("Good job!", "{{session()->get('error_message')}}", "error");
        </script>
    @endif
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('.summernote').summernote({--}}
{{--                height:150,--}}
{{--                toolbar: [--}}
{{--                    [ 'style', [ 'style' ] ],--}}
{{--                    [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],--}}
{{--                    [ 'fontname', [ 'fontname' ] ],--}}
{{--                    [ 'fontsize', [ 'fontsize' ] ],--}}
{{--                    [ 'color', [ 'color' ] ],--}}
{{--                    [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],--}}
{{--                ]--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}


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

      tableWidth = document.getElementById('statisticsTable').offsetWidth;
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
        document.getElementById('statisticsTable').style.width = tableWidth + diffX + "px"
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

