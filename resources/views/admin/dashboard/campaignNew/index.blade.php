@extends('admin.dashboard.layouts.app')
@section('title','Campaigns')

@section('style')
@include('admin.dashboard.layouts.includes.general.styles.index')
<style>
    .actions {
        display: flex;
        gap: 5px;
    }

  
</style>
{{-- <link href="{{asset('css/campaign.css')}}" rel="stylesheet">--}}
@endsection

@section('page-header')
<!-- breadcrumb -->
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Campaigns'])
<!-- /breadcrumb -->
@stop

@section('content')
@include('admin.dashboard.campaign.filter')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                    <div class="create_import">
                        @can('create campaigns')
                        <a href="{{route('dashboard.create-campaign.create')}}" class="btn ">
                            <i class="icon-plus-circle"></i> Create
                        </a>
{{--                        <button type="button" class="btn  " id="imports" data-toggle="modal" data-target="#import_excels">--}}
{{--                            <i class="icon-share-alternitive"></i> import--}}
{{--                        </button>--}}
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
                                    <th><input name="select_all" id="select_all" type="checkbox" /></th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Brand Name</th>
                                    <th class="border-bottom-0">Type</th>                              
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Country</th>
                                    <th class="border-bottom-0">Total</th>
                                    <th class="border-bottom-0">Daily</th>
                                    <th class="border-bottom-0">Attendees</th>
                                    <th class="border-bottom-0">Start Date</th>
                                    <th class="border-bottom-0">End Date</th>
                                    <th class="border-bottom-0">Secret Keys</th>
                                    <th class="border-bottom-0">Created At</th>
                                    @if(user_can_control('campaigns'))
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
<script src="{{asset('js/campaign/index.js')}}"></script>
@include('admin.dashboard.campaign.datatable')
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


<script>
    $('.status_type').click(function() {
        $(this).toggleClass('active');
    })

    $(document).ready(function() {
        $(".status_type").click(function() {
            $(".status_type").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>



<script>
    $(window).on('load', function() {
        $('.modal.fade').appendTo('body');
    })
</script>
@endsection
