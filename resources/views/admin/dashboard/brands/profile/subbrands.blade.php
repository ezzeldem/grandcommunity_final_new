<section class="filter-form">
 <div class="row filters" style="align-items:end">
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2" >
        <select id="status_sub_id_search" class="select2 form-control" style="width: 100%; background: #1a233a;color: #bcd0f7;border-color: #bcd0f761;border-radius: 2px;padding: 4px;outline: none;"placeholder="select">
        <option value="" disabled selected>Select Status</option>
        <option value="1">Active</option>
            <option value="0">InActive</option>
        </select>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2" >
        {!! Form::select('country_sub_id_search',getBrandCountries($brand,true),null,['class' =>'country_id_search select2','data-show-subtext'=>'true','style'=>'width: 100%;background: #1a233a;color: #bcd0f7;border-color: #bcd0f761;border-radius: 2px;padding: 4px;outline: none;',
    'data-live-search'=>'true','id' => 'country_sub_id_search','placeholder'=>'Select Country'])!!}
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2" >
        <label><b>Date</b></label>
        <div id="reportrange" class="form-control">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
            <input type="hidden" value="startDateSearch" id="startDateSearch" name="startDateSearch">
            <input type="hidden" value="endDateSearch" id="endDateSearch" name="endDateSearch">
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
        <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="go_search_sub_brands" >
            <i class="fab fa-searchengin mr-1"></i>Search
        </button>
        <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="go_reset_subbrand_filters" >
            <i class="fab fa-searchengin mr-1"></i>Reset
        </button>
    </div>
</div>

</section>

<div class="filters text-center mb-3">
    <div class="search_reset_btns">
        <button type="button"  class="btn mt-3 mr-1 add_sub_brand hvr-sweep-to-right" id="open_modal_add" data-id="{{ $brand->id }}" data-toggle="modal" data-target="#sub_brand_modal">
            Add New Brand
        </button>
        @can('delete sub-brands')
            <button type="button" class="btn mt-3 btn hvr-sweep-to-right" id="btn_delete_subbrand_all"><i class="fas fa-trash-alt"></i> Delete</button>
        @endcan
        <a  onclick="exportSubBrandExcel(event)" class="btn export ml-2 mt-3 hvr-sweep-to-right">
            <i class="fas fa-file-download"></i> Export
        </a>
    </div>
</div>


<div class="table-responsive">
    <!-- <div class="zoom-container show_brands">
        <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
            <i class="fas fa-expand"></i>
        </button>
    </div> -->
    <table id="exampleTbl_subbrand" class="table table-loader custom-table">
        <input type="hidden" id="brand_me_id" value="{{$brand->id}}">
        <thead>
        <tr>
            <th> <input type="checkbox" id="select_all"  name="select_all" /></th>
            <th data-head="name" class="border-bottom-0">Name</th>
            <th data-head="phone" class="border-bottom-0">Phone</th>
            <th data-head="whats_app" class="border-bottom-0">Whats App</th>
            <th data-head="status" class="border-bottom-0">Status</th>
            <th data-head="branches" class="border-bottom-0">Branches</th>
            <th data-head="countries" class="border-bottom-0">Countries</th>
            <th data-head="created_at" >created_at</th>
            @if(user_can_control('sub-brands'))
            <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@include('admin.dashboard.brands.models.sub_brand_modal')
@include('admin.dashboard.brands.models.modal_to_brand_details')
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        $(function (){
            function format(item, state) {
                if (!item.id) {
                    return item.text;
                }
                var flag= item.element.attributes[1];
                var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
                var url = state ? stateUrl : countryUrl;
                var img = $("<img>", {
                    class: "img-flag-all",
                    width: 18,
                    src: url + flag.value.toLowerCase() + ".svg"
                });
                var span = $("<span>", {
                    text: " " + item.text
                });
                span.prepend(img);
                return span;
            }
            function formatState (state) {
                if (!state.id) {
                    return state.text;
                }
                var flag= state.element.attributes[1].value;
                var baseUrl = "https://hatscripts.github.io/circle-flags/flags/";
                var $state = $(
                    '<span><img class="img-flag" width="22"/> <span></span></span>'
                );
                $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase() + ".svg");
                return $state;
            };

            function selectCountry(){
                $('.country_code').select2({
                    placeholder: "🌍 Global",
                    allowClear: true,
                    templateResult: function(item) {
                        return format(item, false);
                    },
                    templateSelection:function(state) {
                        return formatState(state, false);
                    },
                });
            }

            selectCountry();
        });

$(document).on('click', '#show_brand_modal', function() {
            var brand_id = $(this).attr("data-id");
            $('#show_to_brand_modal').show();
            $.ajax({
                url: '{{url("dashboard/brand/brand_all_details")}}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'brand_id': brand_id
                },
                success: function(res) {
                    // let route_details = 'social-scrape/'+brand_id
                    if (res != null) {

                        $('.name').html('');
                        $('.phone').html('');
                        $('.insta').html('');
                        $('.whatsapp').html('');
                        $('.gender').html('');
                        $('.imageuserdetail').html('');
                        $('.tiktok').html('');
                        $('.snapchat').html('');
                        $('.divshow').html('');
                        $('.show_icon').html('');
                        $('.countries').html('');



                        $('.name').html(res.brand_details.name);
                        $('.phone').html(res.brand_details.phone);
                        $('.gender').html(res.brand_details.preferred_gender);
                        $('.whatsapp').html(res.brand_details.whats_number);
                        $('.tiktok').html(res.brand_details.link_tiktok);
                        $('.groups_count').html(res.total);
                        $('.active_groups').html(res.active);
                        $('.inactive_groups').html(res.inactive);
                        for(let i = 0 ; i< res.countries.length ; i++){
                            $('.countries').append(res.countries[i].code.toUpperCase());
                        if(i < res.countries.length -1){ $('.countries').append( ',')}
                        }
                        $('.insta').append(` <a target="_blank" href="https://www.instagram.com/${res.brand_details.link_insta}" style="color: #bcd0f7" class="mb-0">${res.brand_details.link_insta}</a> `);
                        $('.whatsapp').html(res.brand_details ? res.brand_details.whats_number : '-');
                        $('.imageuserdetail').append(`<img class="imagePic img-fluid" src="${res.brand_details.image}" style="width: 50%;height: 50%;object-fit: cover;transform: scale(1);" alt="..">`);
                        $('.tiktok').html(res.brand_details.link_tiktok ?? '------');
                        (res.brand_details.link_snapchat != null ? $('.snapchat').append(` <a style="color: #bcd0f7" href="https://www.snapchat.com/${res.brand_details.link_snapchat}" target="_blank" class="mb-0">${res.brand_details.link_snapchat}</a>`):'----');
                         $('.divshow').append(` <button type="button" class="btn " data-dismiss="modal">Close</button>`)

                     }
                }
            });
});


        // add branch saveBranch (script) in modal branch
        let code_phone_val = 0;
        let subbrand_phone_val = 0;
       $('#open_modal_add').on('click',function (){
            code_phone_val = 0;
            subbrand_phone_val =0;
       })
        $('.getSubbrandData').on('click',function (){
             code_phone_val = 1;
             subbrand_phone_val = 1;
        })



        $('#code_phone').on('change',function (){
            if($(this).val()){
                code_phone_val = 1;
            }else{
                code_phone_val = 0;
            }
            checkToggleWhatsapp();
        })
        $('#subbrand_phone').on('input',function (){
            if($(this).val()){
                subbrand_phone_val = 1;
            }else{
                subbrand_phone_val = 0;
            }
            checkToggleWhatsapp();
        })

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

    $("body").on("change", "#inputFile", function() {
        readURL(this);
    });


        function checkToggleWhatsapp(){
            if(code_phone_val == 1 && subbrand_phone_val == 1){
                $('.togBtn').attr('disabled',false)
            }else{
                // $(".togBtn").removeProp('checked')
                $('.togBtn').attr('disabled',true)
            }

        }
        //// **hint script bulk delete in modal bulk //////
        //$('')
			$('#open_modal_add').on('click',function (){
				$('#name').val('');
				$('#subbrand_image').val('');
				$('#preferred_gender').val('').trigger('change');
				$('#branch_ids').val('').trigger('change');
			$('#subbrand_branch_ids').html('');
				$('.country_code').val('').trigger('change');
				$('#status').val('').trigger('change');
				$('#subbrand_phone').val('');
				$('#subbrand_whats_number').val('');
				$('#subbrand_link_insta').val('');
				$('#subbrand_link_facebook').val('');
				$('#subbrand_link_tiktok').val('');
				$('#subbrand_link_snapchat').val('');
				$('#subbrand_link_twitter').val('');
				$('#subbrand_link_website').val('');
				$('.togBtn').attr('disabled',true)
				$('.togBtn').prop('checked',false)
				// $('.select2-selection__rendered').each(function (index,element){
				//     if(index != 0){
				//         $(element).parent().parent().remove();
				//     }
				// })
				$('#whatsappSection').show()
			})
			let reload_subbrand = true;
			let country_flag = 0;

            //getSubbrandData
            $(document).on('click','.getSubbrandData',function (){
                $('.togBtn').attr('disabled',false)
                var id = $(this).data('id')
                $('#save_sub_brand').text('Edit')
                $('#save_sub_brand').attr('route','edit')
                $('#subBrandModalLabel').text('Edit Group Of Sub Brand')
                $('#save_sub_brand').removeClass('btn-primary').addClass('btn-warning')
                $.ajax({
                    url:'/dashboard/sub-brands/'+id+'/edit',
                    type:'get',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:(data)=>{
                        if(data.status){
                            let basic_data = data.data
                            $('#name').val(basic_data.name);
                            country_flag = 1;
                            $('#preferred_gender').val(basic_data.preferred_gender).trigger('change');
                            $('#uploadedImage').attr("src", basic_data.image);
                            $('#subbrand_country_id').val(basic_data.country_id).trigger('change');
                            $('#code_whats').val(basic_data.code_whats).trigger('change');
                            $('#code_phone').val(basic_data.code_phone).trigger('change');
                            $('#status').val(basic_data.status).trigger('change');
                            $('#subbrand_phone').val(basic_data.phone);
                            $('#sub_brand').val(basic_data.id);
                            $('#subbrand_whats_number').val(basic_data.whats_number);
                            $('#subbrand_link_insta').val(basic_data.link_insta);
                            $('#subbrand_link_facebook').val(basic_data.link_facebook);
                            $('#subbrand_link_tiktok').val(basic_data.link_tiktok);
                            $('#subbrand_link_snapchat').val(basic_data.link_snapchat);
                            $('#subbrand_link_twitter').val(basic_data.link_twitter);
                            $('#subbrand_link_website').val(basic_data.link_website);
                            $("#subbrand_branch_ids").html('')
                            $("#subbrand_branch_ids").parent().parent().hide()

                            if(data.branches && data.branches.length >0){

                                $("#subbrand_branch_ids").parent().parent().show()
                                let branches = ''


                                $.each(data.branches,function(key,value){
                                    let select_status = basic_data.branch_id.find(x=>x.id==value.id)?true:false;
                                    branches += `<option value="${value.id}"  ${(select_status == true) ? 'selected' : ''}>${value.name}</option>`;

                                });
                                $('#subbrand_branch_ids').html(branches);
                            }
                            if((basic_data.whats_number==basic_data.phone) && (basic_data.code_phone==basic_data.code_whats) ){

                                $('.togBtn').prop('checked',true);
                                $('.togBtn').attr('disabled',false);

                                $('#whatsappSection').hide();
                            }else{

                                $('.togBtn').prop('checked',false);
                                $('.togBtn').attr('disabled',false);

                                $('#whatsappSection').show();
                            }
                          // $("#sub_brand_modal").modal('hide')

                        }else{
                            Swal.fire("Error Happened!", "Error!", "warning");

                        }
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong, check if you have permission to do this action.", "error");
                    }
                })
				});

			// $(document).on('change','#subbrand_country_id',function (e){
			// 	e.preventDefault();
			// 	if(country_flag==1){country_flag = 0;return false;}
			// 	var id = $('#brand_me_id').val()
			// 	var country_id = $(this).val()
			// 	$('#subbrand_branch_ids').html('');
            //
			// 	$.ajax({
			// 		url:`/dashboard/brand-not-assignd-branches-to-subbrand/${id}/${country_id}`,
			// 		type:'get',
			// 		contentType: "application/json",
			// 		headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
			// 		success:(data)=>{
			// 			if(data.status){
			// 				if(data.data.length >0){
			// 					$("#subbrand_branch_ids").parent().parent().show()
			// 					let branches = ''
			// 					$.each(data.data,function(key,value){
			// 						branches += "<option value='" + value.id + "'>" + value.name + "</option>";
			// 					});
			// 					$('#subbrand_branch_ids').html(branches);
			// 				}
			// 				//$("#sub_brand_modal").modal('show')
			// 				country_flag = 0;
			// 			}
			// 		}
			// 	})
			// });
            $(document).on('click','.add_sub_brand',function (){
                //$('#subbrand_country_id').val('').trigger('change');
                $('#save_sub_brand').text('Save')
                $('#save_sub_brand').attr('route','add')
                $('#subBrandModalLabel').text('Add Brand')
                $('#save_sub_brand').removeClass('btn').addClass('btn')
            })

            {{--//Sub BRAND  DATATABLE RENDER--}}
            if(reload_subbrand==true){
                reload_subbrand=false
                let selectedIds = [];
                // datatable render
                    $('#exampleTbl_subbrand').on('processing.dt', function (e, settings, processing) {
                        $('#processingIndicator').css('display', 'none');
                            if (processing) {$("#exampleTbl_subbrand").addClass('table-loader').show();}
                            else {$("#exampleTbl_subbrand").removeClass('table-loader').show();}
                    })
                subBrandTbl = $('#exampleTbl_subbrand').DataTable({
                    lengthChange: true,
                    fixedHeader: true,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    dom: 'Blfrtip',
                    "buttons": [
                        'colvis',
                    ],
                    'columnDefs': [{ 'orderable': true, 'targets': 0 }],
                    'aaSorting': [[8, 'desc']],
                    ajax: {
                        url :'/dashboard/sub-brand',
                        headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                        data: function (d) {
                            d.status_val = $('#status_sub_id_search').val();
                            d.country_val = $('#country_sub_id_search').val();
                            d.start_date = $('#startDateSearch').val();
                            d.end_date = $('#endDateSearch').val();
                            // d.brands_status = $('#brands_status').val();
                            d.brand_id = $('#brand_me_id').val();
                        }
                    },
                    columns: [
                        {
                            "data": "id",
                            sortable:false,
                            render:function (data,type){
                                return `<input type="checkbox" class="select_all_subbrand"  name="ids[]" value='${data}' />`;
                            }
                        },
                        {
                            data: 'name',
                            render :function (data,type,full){
                                return `
                                    <img src="${full['image']}" class="img-thumbnail" style="width: 39px;height: 39px;" alt="image">
                                    <a class="show_brand" href="{{ url('dashboard/sub-brands')}}${'/'+full['id']}?brand_id={{$brand->id}}"><span class="_username_influncer">${data}</span></a>`;
                            }
                        },
                        {data: 'phone',
                            render: function(data){
                                return `
                                <span class="_phone_table"> <i class="fa-solid fa-phone"></i> - ${data}</span>
                                `
                            }
                        },
                        {data: 'whats_number',
                            render: function(data){
                                return `
                                <span class="_phone_table"> <i class="fa-brands fa-whatsapp"></i> - ${data}</span>
                                `
                            }
                        },
                        {
                            "data": 'active_data',
                            "className" : 'switch_parent',
                            render :function (data,type){
                                if(data.active == 1){

                                    return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="active" ></label>`
                                }else{
                                    return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle _username_influncer"  data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                                }
                            }
                        },
                        {
                            data: 'branches',
                            render :function (data,type){
                                let brancesh_all = '';
                                $.each(data, function(branchId, branchName) {
                                         brancesh_all += (branchName + ' , ')
                                    });
                                    brancesh_all = brancesh_all.slice(0,brancesh_all.length-2)
                                    return ` <span class="_username_influncer"> ${brancesh_all} </span> `

                            }
                        },
                        {
                            data: 'country_id',
                            render: function(data, type) {
                                let dataMap = data.map((e)=>{
                                    let el =  `
                                    <span class="flag-container _country_table" style="">
                                       ${e.code.toUpperCase()}
                                    </span>`;
                                    return el;
                                })
                                let temp = `<span class="flag-container" style="">
                                       ${dataMap}
                                    </span>`
                                return temp;
                            }
                        },
                        {data: 'created_at',
                            render: function(data){
                                return `
                                    <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                                `
                            }
                        },
                        {
                            "data": "id",
                            'className': "actions",
                            render:function (data,type){
                                return `<td>
                                    @can('update sub-brands')
                                    <button style="background:transparent !important;width:2px !important;" data-id="${data}" class="btn btn-primary mt-2 mb-2 pb-2 getSubbrandData" data-toggle="modal" data-target="#sub_brand_modal">
                                        <i class="far fa-edit text-success" font-szie:16px;></i>
                                    </button>
                                    @endcan
                                    @can('delete sub-brands')
                                     <button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" id="del-${data}" data-id="${data}" >
                                        <i class="far fa-trash-alt text-danger" font-szie:16px;></i>
                                     </button>
                                     @endcan



                                     <a href="{{ url('dashboard/sub-brands')}}${'/'+data}?brand_id={{$brand->id}}" class="m-auto">
                                        <i class="fas fa-eye"></i>
                                     </a>
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

            }
            ////////////// start filter by status ///////////////////
            $('#go_search_sub_brands').on('click',function (){
                subBrandTbl.ajax.reload();
            })



            $('#go_reset_subbrand_filters').on('click',function (){
                // $("#status_id_search").select2('val', 'All');
                $('#status_sub_id_search').val(null).trigger('change');
                $('#country_sub_id_search').val(null).trigger('change');
                $('#startDateSearch').val('');
                $('#endDateSearch').val('');
                // $('#reportrange > span').html('');
                $('#reportrange span').empty();

                subBrandTbl.ajax.reload();
            })

            // delete row
            $(document).on('click','.delRow',function (){
                swalDelsub($(this).data('id'));
            });

            $('#btn_delete_subbrand_all').click(function (){
                selectedIds = $("#exampleTbl_subbrand td input.select_all_subbrand:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedIds.length)
                    swalDelsub(selectedIds)
                else
                    Swal.fire("error", "please select brands first", "error");
            })

            //Switch
            $('#exampleTbl_subbrand tbody').on( 'change', '.switch_toggle', function (event) {
                let id = $(this).data('id');
                activeToggle(id);
            })

            //active toggle request
            function activeToggle(id){
                $.ajax({
                    url:`/dashboard/sub-brands-toggle-status/${id}`,
                    type:'post',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:(response)=>{
                        Swal.fire("Updated!", "Status changed Successfully!", "success");
                        subBrandTbl.ajax.reload();

                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong, check if you have permission to do this action.", "error");
                    }
                })
            }


        function swalDelsub(id){
            Swal.fire({
                title: "Are you sure you want to delete?",
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
                    let reqUrl = ``;
                    if(typeof id == "number")
                        reqUrl = `/dashboard/sub-brands/${id}`;
                    else if(typeof id == "object")
                        reqUrl = `/dashboard/subbrands/dels`;
                 let brand_id=$('#brand_me_id').val();
                    $.ajax({
                        url:reqUrl,
                        type:'delete',
                        data:{id,brand_id},
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:(data)=>{
                            if(data.status){
                                subBrandTbl.ajax.reload()
                                for (let statictic in data.stat){
                                    let elId = data.stat[statictic].id;
                                    $(`#${elId}`).find('.counters').text(data.stat[statictic].count)
                                }
                                let list = data.message.map((msg)=>`<li>${msg}</li>`).toString();

                                Swal.fire("warning!",`<ul>${list}</ul>`, "warning");
                            }
                        },
                        error:()=>{
                            Swal.fire("error", "something went wrong, check if you have permission to do this action.", "error");
                        }
                    })
                } else {
                    Swal.fire("Canceled", "Canceled Successfully!", "error");
                }
            })
        }
        //export


        function exportSubBrandExcel(event){
            var brand_me_id=$('#brand_me_id').val()
            event.preventDefault()
            let visibleColumns = []
            let selected_ids = [];

            $("#exampleTbl_subbrand input[type=checkbox]:checked").each(function() {
                if(this.value!='on')
                    selected_ids.push(this.value);
            });
            subBrandTbl.columns().every( function () {
                var visible = this.visible();


                if (visible){
                    if((this.header().innerHTML != 'Actions')){
                        var header = this.header().innerHTML.trim();
                        if((header != '<input type="checkbox" id="select_all" name="select_all">' )){
                            let text = this.header().getAttribute('data-head')
                            visibleColumns.push(text)

                        }
                    }

                }
            });
            window.open(`/dashboard/sub-brand/export?visibleColumns=${visibleColumns}&selected_ids=${selected_ids}&brand_id=${brand_me_id}`);
        }
    </script>
@endpush

