@extends('admin.dashboard.layouts.app')

@section('title','Jobs')


@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
        .lang{
            cursor: pointer;
        }
        .summernote  {
            min-height: 217px !important;
        }
    </style>

@endsection


@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title') Table</h4>
                    </div>
                </div>

                <div class="card-header pb-0">
                    <button onclick="toggle_form()" class="btn pd-x-20 mg-t-10">
                        <i class="icon-plus-circle"></i> Create Job
                    </button>
                </div>
                <div class="card-header pb-0 create_faq" style="display:none">
                    {!! Form::open(['route' => ['dashboard.jobs.store'],'method'=>'post','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page','files'=>true]) !!}
                    @include('admin.dashboard.jobs.form')
                    {!! Form::close() !!}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="zoom-container zoom-abs">
                            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <table id="jobsTable" class="table custom-table resizable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Status</th>
                                    @if(user_can_control('jobs'))
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
    @include('admin.dashboard.jobs.datatable')

    @if(session()->has('successful_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('successful_message')}}", "success");
        </script>
    @elseif(session()->has('error_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('error_message')}}", "error");
        </script>
    @endif

    @if ($errors->any())
        <script>
          $('.create_faq').toggle();
        </script>
    @endif

    <script>

        $(document).ready(function() {
            
            $('#sub_brand_form').on('submit', function(){
                console.log(10235);
                $('.button_submit').prop('disabled', true);
            });


            $('.arabic_field').on('input',function(e){
                test($(this).val())
            })

            var test = function (val_ar) {
                var isArabic = /^([\u0600-\u06ff]|[\u0750-\u077f]|[\ufb50-\ufbc1]|[\ufbd3-\ufd3f]|[\ufd50-\ufd8f]|[\ufd92-\ufdc7]|[\ufe70-\ufefc]|[\ufdf0-\ufdfd]|[0-9]|[ ])*$/g;
                if (isArabic.test(val_ar)) {
                } else {
                    $('.arabic_field').val('')
                }
            }
        });
    function toggle_form(){
        $('.create_faq').toggle();
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

            tableWidth = document.getElementById('jobsTable').offsetWidth;
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
                document.getElementById('jobsTable').style.width = tableWidth + diffX + "px"
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

