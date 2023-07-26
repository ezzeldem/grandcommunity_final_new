
<script>

    function swalDel(id, tabel ){
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
        }).then((res)=>{
            if (res.isConfirmed){
                let reqUrl = ``;
                if(typeof id == "string")
                    reqUrl = `/dashboard/campaigns/${id}`;
                else if(typeof id == "object")
                    reqUrl = `/dashboard/campaigns/bulk/delete`;
                $.ajax({
                    url: reqUrl,
                    type:'delete',
                    data: {id},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:()=>{
                        Swal.fire("Deleted!", "Deleted Successfully!", "success");
                        tabel.ajax.reload();
                    },
                    error:()=>{
                        Swal.fire("Error", "Something went wrong please reload page", "error");
                    }
                })
            } else {
                Swal.fire("Cancelled", "Canceled successfully!", "error");
            }
        })
    }

    function swalApproveCancel(id, tabel ){
        Swal.fire({
            title: "Are you sure you want cancel campaign?",
            text: "You won't be able to undo this action",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Cancel Campaign',
            cancelButtonText: "Close",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((res)=>{
            if (res.isConfirmed){
                let reqUrl = ``;
                reqUrl = `/dashboard/campaign/approveCancel/${id}`;
                $.ajax({
                    url: reqUrl,
                    type:'put',
                    data: {id},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:()=>{
                        Swal.fire("Canceled!", "Campaign Canceled Successfully!", "success");
                        tabel.ajax.reload();
                    },
                    error:()=>{
                        Swal.fire("Error", "Something went wrong please reload page", "error");
                    }
                })
            } else {
                swal.close();
            }
        })
    }

    function swalRejectCancel(id, tabel){
        Swal.fire({
            title: "Are you sure you want reject cancel campaign?",
            text: "You won't be able to undo this action",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Reject Cancel Campaign',
            cancelButtonText: "Close",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((res)=>{
            if (res.isConfirmed){
                let reqUrl = ``;
                reqUrl = `/dashboard/campaign/rejectCancel/${id}`;
                $.ajax({
                    url: reqUrl,
                    type:'put',
                    data: {id},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:()=>{
                        Swal.fire("Rejected!", "Cancel Campaign Rejected Successfully!", "success");
                        tabel.ajax.reload();
                    },
                    error:()=>{
                        Swal.fire("Error", "Something went wrong please reload page", "error");
                    }
                })
            } else {
                swal.close();
            }
        })
    }


    let camp_status_filter = null;
    $('.status_influencer_statistic').on('click', function(event) {
        camp_status_filter = $(this).attr('value');
        $("#exampleTbl").DataTable().ajax.reload();
        $('html, body').animate({
            scrollTop: ($("#exampleTbl").offset().top)
        }, 1000);
    });
    $(document).ready( function () {
        let status_type;
        let campaignTabel = $("#exampleTbl").DataTable({
            lengthChange: true,
            "drawCallback": function( settings ) {
                recheckedInputsStoredInDatatableSession()
            },
            processing: true,
            serverSide: true,
            responsive: true,
            searching: true,
            clearable: true,
            dom: 'Blfrtip',
            "buttons": [
                'colvis',
            ],
            'columnDefs': [{ 'orderable': false, 'targets': 0 }],
            'aaSorting': [[11, 'desc']],
            "ajax": {
                url: "{{route('dashboard.campaigns.datatable')}}",
                data: function (d) {
                    d.status_val = $('#campaign_status_search').val()?$('#campaign_status_search').val():"{{request('status')}}";
                    d.country_val = $('#country_id_search').val();
                    d.campaign_type_val = camp_status_filter?camp_status_filter:$('#campaign_type_search').val();
                    d.start_date = $('#startDateSearch').val();
                    d.end_date = $('#endDateSearch').val();
                    d.status_type = status_type;
                    addCheckedItemsInDataTableToSession();
                    recheckedInputsStoredInDatatableSession();
                }
            },
            "columns": [
                // {
                //     "data": "id",
                //     "sortable": false,
                //     render: function (data, type) {
                //         return '<input type="checkbox"  value="' + data + '" class="box1 check-item-in-dt" >';
                //     }
                // },
                {"data": "name",
                    render: function(data, type, row){
                        let route_show = '/dashboard/campaigns/' + row.id
                        return ` <a href="${route_show}" class="_username_influncer">${row.name}</a>`;
                    }
                },
                {
                    "data": "brand",
                    render: function(data){
                        return `
                            <span class="_username_influncer">${data}</span>
                        `
                    }
                },
                {
                    "data": "type",
                    "sortable": false,
                    render: function(data){
                        return `
                            <span class="_type_chip">${data} <i class="fa-solid fa-circle-check"></i></span>
                        `
                    }
                },
                {
                    "data": "status",
                    "sortable": false,
                    render: function(data, type){
                        let statusName = 'Pending'
                        if (data.value === 1) statusName = 'Active'
                        if (data.value === 2) statusName = 'Finished'
                        if (data.value === 3) statusName = 'Canceled'
                        if (data.value === 4) statusName = 'Upcoming'
                        if (data.value === 5) statusName = 'Drafted'
                        return `
                            <span class="_username_influncer grand-state-box ${statusName}"> ${statusName} </span>
                        `
                    }
                },

                {
                    "data": "countries",
                    "sortable": false,
                     render:function (data, type){
                         let dataMap = data.map((e)=>{
                             let el =  `
                             <span style="color:white" class="_username_influncer">${e.code.toUpperCase() }</span>
                             `;
                             return el;
                            })
                            if(dataMap.length > 0)
                                return `<span class="flag-container">${dataMap}</span>`
                            else
                                return `<p class="text-center">--</p>`
                     }
                },
                {
                    "data": "influencer_per_day",
                    render: function(data){
                        return `
                            <span class="_username_influncer"> ${data} </span>
                        `
                    }
                },
                // {
                //     "data": "attendees",
                //     render: function(data){
                //         return `
                //             <span class="_username_influncer"> ${data} </span>
                //         `
                //     }
                // },
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
                             if(data['visit']) {
                                 html += `<div class="col-md-12 _username_influncer"> <i class="fa-solid fa-calendar"></i> &nbsp; ${visitDateLabel} ${data['visit']}</div>`
                             }
                             if(data['delivery']){
                                 html+=`<div class="col-md-12 _username_influncer"> <i class="fa-solid fa-calendar"></i> &nbsp; ${ deliveryDateLabel }  ${ data['delivery'] }</div>`
                             }
                             html += `</div>`
                             return html
                         }else{
                            return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `
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
                            if(data['visit']) {
                                html += `<div class="col-md-12 _username_influncer"> <i class="fa-solid fa-calendar"></i> &nbsp; ${visitDateLabel} ${data['visit']}</div>`
                            }
                            if(data['delivery']){
                                html+=`<div class="col-md-12 _username_influncer"> <i class="fa-solid fa-calendar"></i> &nbsp; ${ deliveryDateLabel }  ${ data['delivery'] }</div>`
                            }
                            html += `</div>`
                            return html
                        }else{
                            return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `
                        }
                    }
                },
                {
                    "data": "secrets",
                    "sortable": false,
                    render: function (data, type) {
                        let secrets = ''
                      if(data.length > 0 && data !== 'no secrets'){
                          data.forEach((element, index) => {
                              secrets += element.secret
                              if(index < data.length-1 )
                                  secrets += ' | '
                          });
                          return secrets;
                      }else{
                          return 'No Secrets'
                      }
                    }
                },
                {"data": "created_at",
                    render :function(data){
                        return `
                            <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> - ${data} </span>
                        `
                    }
                },
                {"data":"reason",
                    "sortable": false,
                    render: function(data){
                        if(data)
                            return `
                                <span class="_username_influncer"> ${data} </span>
                            `
                        else
                            return `
                                <span class="_username_influncer"> -- </span>
                            `
                    }
                },
                {
                    "data": "camp_id",
                    "sortable": false,
                    render: function (data, type, row) {
                        let route_edit = '/dashboard/campaigns/' + data.id + '/edit'
                        let route_show = '/dashboard/campaigns/' + data.id
                        $t = `<td>
                                <div class="actions">
                                @can('read campaigns')
                                    <a  href="${route_show}" class="grand-table-button "  data-toggle="tooltip" data-placement="top" title="Show Campaign">
                                        <i class="icon-eye text-warning" style="font-size:16px;"></i>
                                    </a>
                                 @endcan

                                @can('update campaigns')
                                     <a  href="${route_edit}" class="grand-table-button"  data-placement="top" title="Edit Campaign" >
                                        <i class="icon-edit-3 text-success" style="font-size:16px;"></i>
                                    </a>
                                @endcan
                                @can('delete campaigns')
                                 <button  class="campaigns grand-table-button delRow" data-id="${data.id}" id="del-${data.id}" data-toggle="tooltip" data-placement="top" title="Delete Campaign" >
                                        <i class="icon-trash-2 text-danger" style="font-size:16px;"></i>
                                 </button>
                               @endcan
                            </div>
                            </td>`;

                            if(data.status.value === 0){
                                $t +=
                                `@can('update campaigns')
                                    <button  data-toggle="tooltip" data-placement="top" title="Approve Campaign" class="grand-table-button mt-2 mb-2 acceptRow active_campaign" id="accept-${data.id}" data-id="${data.id}" >
                                            <i class="icon-check-circle" style="font-size: 16px;"></i>
                                    </button>
                                @endcan`
                            }
                            if(row.reason && row.request_to_cancle === 0 ){
                                $t +=
                                `@can('update campaigns')
                                <div class="dropdown mr-1 cancel_camp">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item approveRow" href="#" id="approveCamp-${data.id}" data-id="${data.id}"> <i class="fas fa-check"></i> Approve Cancellation</a>
                                    <a class="dropdown-item rejectRow" href="#" id="rejectCamp-${data.id}" data-id="${data.id}"><i class="fas fa-times"></i> Reject Cancellation</a>
                                    </div>
                                </div>
                                @endcan`
                            }
                            return $t;
                    }
                }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedHeader: {
                header: true,
            },
            language: {
                searchPlaceholder: 'Search',
                sSearch: '',
            }
        });

        $(document).on('click','.status_type',function (){
            $('#campaign_status_search').val($(this).attr('data-value'))//active
            campaignTabel.ajax.reload();
        });

        @if(isset(request()->status_type))
            status_type = '{{ request()->status_type}}';
            $('#campaign_status_search').val(status_type)//active
            $('#campaign_status_search').val(status_type).trigger('change');
            $('button.active').removeClass("active");
            $('button[data-value='+status_type+']').addClass('active');
            campaignTabel.ajax.reload();
        @endif

        $(document).on('click','#rest',function (){
            $('#country_id_search').val(null).trigger('change');
            $('#campaign_status_search').val(null).trigger('change');
            $('#campaign_type_search').val(null).trigger('change');
            $('#reportrange span').empty();
            $('#startDateSearch').val('');
            $('#endDateSearch').val('');
            campaignTabel.ajax.reload();
        })

        $(document).on('click','#go_search',function (e){
            e.preventDefault();

            campaignTabel.ajax.reload();
        })
        //Delete
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'), campaignTabel);
        });

        //Approve Cancel Campaign
        $(document).on('click','.approveRow',function (){
            swalApproveCancel($(this).attr('data-id'), campaignTabel);
        });

        //Reject Cancel Campaign
        $(document).on('click','.rejectRow',function (){
            swalRejectCancel($(this).attr('data-id'), campaignTabel);
        });

        //Toggle StatuscampaignTabel
        $('#exampleTbl tbody').on( 'click','.active_campaign', function (event) {
            let id = $(this).data('id');
            $.ajax({
                url:`/dashboard/campaign-toggle-status/${id}`,
                type:'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    campaignTabel.ajax.reload();
                },
                error:()=>{
                    Swal.fire("Error", "Something went wrong please reload page", "error");
                }
            })
        })

        //Bulck Delete
        let selectedIds = [];
        // options dropdown
        // trigger(
        //     'click'
        // )

        $('#options, #btn_delete_all').click(function (){
            selectedIds = $("#exampleTbl td input:checkbox:checked").map(function(){
                return $(this).val();
            }).toArray();
            if(selectedIds.length){
                $('#del-All').attr('hidden',false);
            }else{
                $('#del-All').attr('hidden',true);
            }
        })

        // delete all toggle
        $('#del-All, #btn_delete_all').click(function (){


            if(selectedIds.length)
                 swalDel(selectedIds, campaignTabel)
            else
                Swal.fire("error", "please select Campaigns", "error");
        })


        $(document).on('click','#submit_delete_all',function (){
            let selected_ids =  $('input[id="delete_all_id"]').val();
            $.ajax({
                type: 'DELETE',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route('dashboard.campaigns.delete_all')}}',
                data: {selected_ids:selected_ids},
                dataType: 'json',
                success: function (data) {
                    if(data.status){
                        $('#delete_all').modal('hide')
                        Swal.fire("Deleted!", "Deleted Successfully!", "success");
                        campaignTabel.ajax.reload();
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        //campaignTabel.buttons('.buttons-collection').nodes().css("display", "none");

        $(document).on('click','.status_type',function (){
            status_type = $(this).data('value');
            campaignTabel.ajax.reload();
        })




        $('#visit_Camp').on('click',function(){
            $('#campaign_type_search').val(0)
            campaignTabel.ajax.reload();
        });
        $('#delivery_Camp').on('click',function(){
            $('#campaign_type_search').val(1)
            campaignTabel.ajax.reload();
        });
        $('#mix_Camp').on('click',function(){
            $('#campaign_type_search').val(2)
            campaignTabel.ajax.reload();
        });
        $('#all_Camp').on('click',function(){
            $('#campaign_type_search').val(null)
            campaignTabel.ajax.reload();
        });
    });
</script>
