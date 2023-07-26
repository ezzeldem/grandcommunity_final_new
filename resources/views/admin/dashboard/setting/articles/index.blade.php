@extends('admin.dashboard.layouts.app')

@section('title','Articles')


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
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Articles'])
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                        @can('delete articles')
                        <div class="create_import">
                            <a href="{{route('dashboard.articles.create')}}" class="btn pd-x-20 mg-t-10">
                                <i class="icon-plus-circle"></i> Add Aticle
                            </a>
                        </div>
                        @endcan
                    </div>

                    @if(\App\Models\Article::count() > 0)
                        <section class="btn_sec">
                            @can('delete articles')
                                <button type="button" class="btn" id="btn_delete_all">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            @endcan
                            @can('update articles')
                                <button type="button" class="btn" id="btn_status_all">
                                    <i class="fas fa-edit"></i> Status
                                </button>
                            @endcan
                        </section>
                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive zoom-abs">
                        <div class="zoom-container zoom-abs">
                            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <table id="articlesTable" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th> <input type="checkbox" id="select_all" name="select_all" /></th>
                                <th class="border-bottom-0">Title (En)</th>
                                <th class="border-bottom-0">Title (Ar)</th>
                                <th class="border-bottom-0">Image</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Created At</th>
                                <th class="border-bottom-0">Created By</th>
                                @if(user_can_control('articles'))
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
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    @include('admin.dashboard.setting.articles.datatable')


    @if(session()->has('successful_message'))
        <script>
            swal("Good job!", "{{session()->get('successful_message')}}", "success");
        </script>
    @elseif(session()->has('error_message'))
        <script>
            swal("Good job!", "{{session()->get('error_message')}}", "error");
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

      tableWidth = document.getElementById('articlesTable').offsetWidth;
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
        document.getElementById('articlesTable').style.width = tableWidth + diffX + "px"
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

