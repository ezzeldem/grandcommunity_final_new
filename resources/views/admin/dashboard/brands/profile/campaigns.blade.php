<!-- Row start -->
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <!-- Row start -->
                <div class="row gutters">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label class="label">Country</label>
                            <div class="custom-date-input">
                                {!! Form::select("country_id_search_camps[]",getBrandCountries($brand,true),null,['class' =>'country_id_search_camps form-control select2 ',
                                'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'country_id_search_camps', 'multiple'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label class="label">Status</label>
                            <select class="form-control select2" name="campaign_status_search" id="campaign_status_search">
                                <option value="" > Select  </option>
                                @foreach($camp_status as $camp_status)
                                    <option value="{{$camp_status->value}}">{{$camp_status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label class="label">Campaign</label>
                            <select class="form-control select2" name="campaign_type_search" id="campaign_type_search">
                                <option value="" > Select Campaign Types  </option>
                                @foreach($camp_types as $type)
                                    <option value="{{$loop->index}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label class="label">Date</label>
                            <div id="newdatapick" class="form-control">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                                <input type="hidden"  id="startDateSearch" name="startDateSearch">
                                <input  type="hidden" id="endDateSearch" name="endDateSearch">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <button type="button" class="btn text-white  mt-3 mr-1" id="reset_campaign" style="background-color:#292828">
                            <i class="fab fa-searchengin mr-1"></i>Reset
                        </button>
                        <button class="btn mt-3 mr-1 text-white" id="go_search_camp" style="background-color:#292828"><i class="fab fa-searchengin mr-1" ></i> Search</button>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="search_reset_btns" style="text-align: center;">
                            <a href="{{route('dashboard.campaigns.create')}}" class="btn create_influ mt-3 text-white" style="background-color:#292828 !important">
                                <i class="fas fa-plus"></i> Create
                            </a>
                            <button type="button" class="btn delete_all mt-3 text-white" id="btn_delete_all_camp" style="background-color:#292828">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Row end -->
             </div>
        </div>
    </div>
</div>
<div class="table-container">
    <div class="table-responsive">
        <!-- <div class="zoom-container show_brands">
            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                <i class="fas fa-expand"></i>
            </button>
        </div> -->
        <table id="brand_campaigns_table" class="table table-loader custom-table">
            <thead>
                <tr>
                    <th class="border-bottom-0">
                        <input name="select_all_camp" id="select_all_camp" type="checkbox" />
                    </th>
                    <th class="border-bottom-0">Campaign Name</th>
                    <th class="border-bottom-0">Brand Name</th>
                    <th class="border-bottom-0">Start Date</th>
                    <th class="border-bottom-0">End Date</th>
                    <th class="border-bottom-0">Countries</th>
                    <th class="border-bottom-0">Type</th>
                    <th class="border-bottom-0">Status</th>
                    <th class="border-bottom-0">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@push('js')
    <script>
        var start = '';
        var end = '';
        function cb(start, end) {
            $('#newdatapick span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
            $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
            $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
        }
        $('#newdatapick').daterangepicker({
            autoUpdateInput: false,
            "minYear": 2000,
            "maxYear": 2030,
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            ranges: {
                'All': ['', ''],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment()],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
            }
        }, cb);
        cb(start, end);
        $("#newdatapick").on('click', function (){
            start = moment().subtract(29, 'days');
            end = moment();
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
            $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
        })

        let reload_camp = true;

        $('#pills-camps-tab').on('click',function (){
            //BRAND CAMPAIGNS DATATABLE RENDER
			loadCampaignDatatable();
        })


		let loadCampaignDatatable =function(){
			$('#brand_campaigns_table').dataTable().fnClearTable();
            $('#brand_campaigns_table').dataTable().fnDestroy();
			let brand_status = true;
            let subbrand_status = true;
            brand_status = '{{isset($brand)}}';
            subbrand_status = '{{$subbrand->id??0}}';
            route = "/dashboard/get-brand-campaigns/{{$brand->id ?? 0}}";

            if(reload_camp == true){
                reload_camp = false

				$('#brand_campaigns_table').on('processing.dt', function (e, settings, processing) {
					    $('#processingIndicator').css('display', 'none');
						if (processing) {$("#brand_campaigns_table").addClass('table-loader').show();}
						else {$("#brand_campaigns_table").removeClass('table-loader').show();}
				})
                brand_campaigns_table =  $('#brand_campaigns_table').DataTable({
                    lengthChange: true,
                    "processing": true,
                    "serverSide": true,
                    responsive: true,
                    searching: true,
                    dom: 'Blfrtip',
                    "buttons": [
                        'colvis',
                    ],
                    'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                    'aaSorting': [[1, 'asc']],
                    "ajax": {
                        url :route,
                        data: function (d) {
                            d.status_val = $('#campaign_status_search').val();
                            d.country_val = $('#country_id_search_camps').val();
                            d.campaign_type_val = $('#campaign_type_search').val();
                            d.start_date = $('#startDateSearch').val();
                            d.end_date = $('#endDateSearch').val();
                            d.searchTerm = $('#customSearch').val();
							d.subrandId = $("#route_sub_brand_id").val();
                        }
                    },
                    "columns": [
                        {
                            "data": "id",
                            "sortable": false,
                            "orderable" : false,
                            render: function (data, type){
                                return '<input type="checkbox"  value="'+data+'" class="box1_camps" >';
                            }
                        },
                        { "data": "name",
                            render: function(data){
                                return `
                                    <span class="_username_influncer">${data}</span>
                                `
                            }
                        },
                        {"data": "brand",
                            render: function(data){
                                return `
                                    <span class="_username_influncer">${data}</span>
                                `
                            }
                        },
                        {
                            "data": "start_date",
                            render:function (data, type, row){
                                let visitDateLabel = ""
                                let deliveryDateLabel = ""
                                if(["Mix", "Visit", "Delivery"].includes(row.type)){
                                    visitDateLabel = "Visit: "
                                    deliveryDateLabel = "Delivery: "
                                }

                                if( jQuery.type(data) == 'object'){
                                    let html = `<div class="row">`
                                    if(data['visit']){
                                        html+=`<div class="col-md-12"> ${visitDateLabel}  : ${ data['visit'] }</div>`
                                    }
                                    if(data['delivery']){
                                        html+=`<div class="col-md-12"> ${ deliveryDateLabel } : ${ data['delivery'] }</div>`
                                    }
                                    html += `</div>`
                                    return `
                                        <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${html} </span>
                                    `
                                }else{
                                    return  ` <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span> `
                                }
                            }
                        },
                        {
                            "data": "end_date",
                            render:function (data, type, row){
                                let visitDateLabel = ""
                                let deliveryDateLabel = ""
                                if(["Mix", "Visit", "Delivery"].includes(row.type)){
                                    visitDateLabel = "Visit: "
                                    deliveryDateLabel = "Delivery: "
                                }

                                if( jQuery.type(data) == 'object'){
                                    let html = `<div class="row">`
                                    if(data['visit']){
                                        html+=`<div class="col-md-12"> ${visitDateLabel} : ${ data['visit'] }</div>`
                                    }
                                    if(data['delivery']){
                                        html+=`<div class="col-md-12"> ${ deliveryDateLabel } : ${ data['delivery'] }</div>`
                                    }
                                    html += `</div>`
                                    return `
                                        <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${html} </span>
                                    `
                                }else{
                                    return  ` <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span> `
                                }
                            }
                        },
                        {
                            "data": "countries",
                            render:function (data, type){
                                let dataMap = data.map((e)=>{
                                    let el = `<span class="_country_table">${e.code.toUpperCase()}</span>`
                                    return el;
                                })
                                let temp = `<span class="">
                                    ${dataMap}
                                    </span>`
                                return temp;
                            }
                        },
                        {
                            "data": "type",
                            render: function(data, type){
                                return campaignTypes(data)
                            }
                        },
                        {"data": "status",
                            render: function(data, type){
                                return campaignStatus(data);
                            }
                        },
                        {
                            "data": "id",
                            'className':'style_td_action',
                            render: function (data, type) {
                                let route_edit = '/dashboard/campaigns/' + data + '/edit'
                                let route_show = '/dashboard/campaigns/' + data
                                return `<td>
                            @can('update brands')
                            <div style="display: flex; gap: 10px;">
                            <a href="${route_show}" style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Show" class="btn  mt-2 mb-2 pb-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endcan

                            @can('delete brands')
                            <a href="${route_edit}" style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Edit"  class="btn  mt-2 mb-2 pb-2">
                                <i class="far fa-edit"></i>
                            </a>
                            @endcan
                            <button  data-toggle="tooltip" style="background:transparent !important;width:2px !important;" data-placement="top" title="Delete" class="campaigns btn  mt-2 mb-2 delRow_camp" data-id="${data}" id="del-${data}">
                                 <i class="far fa-trash-alt"></i>
                            </button>
                        </div>

                        </td>`;
                            }
                        }
                    ],
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    language: {
                        searchPlaceholder: 'Search',
                        sSearch: '',
                    }
                });
            }
		}
        $(document).ready(function(){

            $('.country_id_search_camps').select2({
                width: '100%',
                height: '30px',
                placeholder: "Select",
                allowClear: true,
            });
        })

        $(document).on('click','#go_search_camp',function (e){
            e.preventDefault();
            brand_campaigns_table.ajax.reload();
        })
        $(document).on('input', '#customSearch', function() {
            brand_campaigns_table.ajax.reload();
        })

            $('#reset_campaign').on('click',function(){
                    if ($('#filter-form').find("select".length > 0)) {
                           $('#country_id_search_camps').val('').trigger('change');
                            $('#campaign_status_search').val('').trigger('change');
                            $('#campaign_type_search').val('').trigger('change');
                            $('#endDateSearch').val('');
                            $('#status_id_search').val('');
                            $('#newdatapick span').empty();
                            brand_campaigns_table.ajax.reload();
                }
        });


    </script>
@endpush
