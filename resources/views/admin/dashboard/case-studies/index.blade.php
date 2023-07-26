@extends('admin.dashboard.layouts.app')

@section('title','Case Studies')


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
        .repeatanswer{
            width: 100%;
            padding: 10px
        }
        .create_faq .form-group {
            position: relative;
        }
        .create_faq .form-group input
        {
            width: 97%
        }
        .create_faq .form-group button{
            position: absolute;
            top: 50px;
            right: 0;
        }
    </style>

@endsection


@section('content')
{{--@if ($errors->any())--}}
{{--      <div class="alert alert-danger">--}}
{{--        <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--              <li>{{ $error }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--      </div><br />--}}
{{--@endif--}}
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
                        <i class="icon-plus-circle"></i> Create Case Studies
                    </button>
                </div>
                <div class="card-header pb-0 create_faq" style="display:none">
                    {!! Form::open(['route' => ['dashboard.caseStudies.store'],'method'=>'post','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page','files'=>true]) !!}
                    @include('admin.dashboard.case-studies.form')
                    {!! Form::close() !!}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="zoom-container zoom-abs">
                            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                        <table id="CaseStudiesTable" class="table custom-table resizable">
                            <thead>
                                <tr>
{{--                                    <th>#</th>--}}
                                    <th class="border-bottom-0">Total Followers</th>
                                    <th class="border-bottom-0">Total Influencers</th>
                                    <th class="border-bottom-0">Campaign Name</th>
                                    <th class="border-bottom-0">Total Days</th>
                                    <th class="border-bottom-0">Reel</th>
                                    <th class="border-bottom-0">Client profile</th>
                                        <th>Actions</th>

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
    @include('admin.dashboard.case-studies.datatable')
    @include('admin.dashboard.case-studies.scripts')

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
    function toggle_form(){
        $('.create_faq').toggle();
    }
    $('.select2').select2({
        placeholder: "Select",
    });
   

    /////////////////////
    img_urls = []
    $(document).on('change','#image',function (e){
        choseImgFile(e);
    })
    function choseImgFile(e) {
        $('.imagesShow').empty()
        const files = e.target.files;
        if (files) {
            console.log(" ==> files ==", files);
            for (const key in files) {
                if (key !== "length" && key !== "item") {
                    let customFile = files[key];
                    console.log("=====> custom file =====", key);
                    const reader = new FileReader();
                    reader.onload = () => {
                        const result = reader.result;
                        if(files[key]['type'].includes('image')){
                            $('.imagesShow').append(`<img id="element${key}" src="${result}" style="width:130px;height:130px;"/> `)
                        }else{
                            $('.imagesShow').append(` <video style="width:130px;height:130px;" width="400" controls>
                                <source src="${result}" type="video/mp4">
                                    Your browser does not support HTML video.
                            </video>`)
                        }
                        img_urls.push(result);
                    };
                    //<span class="deleteImage" data-key="${key}" data-image="${files[key].name}">X</span>
                    reader.readAsDataURL(customFile);
                }
            }
        } else {
            console.log("not working");
        }
        $(document).off().on('click','.deleteImage',function (){
            var key = $(this).attr('data-key');
            var name = $(this).attr('data-image');
            const fileListArr = [...files]

            fileListArr.filter((item,key_arr) => {
                return key_arr != key
            })
            $('#element'+key).remove();
            console.log(fileListArr);

            console.log(fileListArr.splice(1, 1))
        })
    }


    // $('#campaign_name').parent().parent().hide();
    // $('.profile_link').attr('disabled',true);


    // $(document).on('change','.campName',function (){
    //     let campaign = $(this).val();
    //     // $('.profile_link').val('')
    //     $.ajax({
    //         type: 'GET',
    //         headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
    //         url: '{{route('dashboard.get-campaign-brand')}}',
    //         data: {campaign:campaign},
    //         success: function (data) {
    //             if(data.data){
    //                 let newData = data.data
    //                 $('.profile_link').val(`https://www.instagram.com/${newData}/`)
    //             }else{
    //                 $('.profile_link').val('')
    //             }
    //         },
    //         error: function (data) {
    //             console.log(data);
    //         }
    //     });
    // })


        $(document).on('change','#campaign_type',function (){
            console.log($(this).val());
        $('#campaign_name').empty()
        // $('#campaign_name').parent().parent().hide();
        let type = $(this).val();
            // $('.profile_link').val('')
            $.ajax({
            type: 'GET',
            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            url: '{{route('dashboard.get-campaigns')}}',
            data: {type:type},
            success: function (data) {
                console.log(data);
                if(data.data.length > 0){
                    let newData = data.data
                    // $('#campaign_name').parent().parent().show();
                    $('#campaign_name').append(`<option disabled selected>Select Campaign</option>`)
                    newData.map((item) => {
                        $('#campaign_name').append(`<option value="${item.name}">${item.name}</option>`)
                    })
                }else{
                    $('#campaign_name').empty();
                    // $('#campaign_name').parent().parent().hide();
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    })

    // $(document).on('change','#campaign_type',function () {

    // })

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

      tableWidth = document.getElementById('CaseStudiesTable').offsetWidth;
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
        document.getElementById('CaseStudiesTable').style.width = tableWidth + diffX + "px"
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

