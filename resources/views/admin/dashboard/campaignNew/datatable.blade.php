
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

    $(document).ready( function () {

        let status_type;
        let campaignTabel = $("#exampleTbl").DataTable({
            lengthChange: true,
            processing: true,
            serverSide: true,
            responsive: true,
            searching: true,
            dom: 'Blfrtip',
            "buttons": [
                'colvis',
            ],
            'columnDefs': [{ 'orderable': false, 'targets': 0 }],
            'aaSorting': [[1, 'asc']],
            "ajax": {
                url: "{{route('dashboard.campaigns.datatable')}}",
                data: function (d) {
                    d.status_val = $('#campaign_status_search').val();
                    d.country_val = $('#country_id_search').val();
                    d.campaign_type_val = $('#campaign_type_search').val();
                    d.start_date = $('#startDateSearch').val();
                    d.end_date = $('#endDateSearch').val();
                    d.status_type = status_type;
                }
            },
            "columns": [
                {
                    "data": "id",
                    "sortable": false,
                    render: function (data, type) {
                        return '<input type="checkbox"  value="' + data + '" class="box1" >';
                    }
                },
                {"data": "name"},
                {"data": "brand"},
                {"data": "type"},
                {"data": "status",
                    render: function(data, type){
                        return  data.name;
                    }
                },

                {
                    "data": "countries",
                     render:function (data, type){
                         let dataMap = data.map((e)=>{
                             let el =  `
                             <span style="color:white">${e.code.toUpperCase() }</span>
                                `;
                             return el;
                         })
                         let temp = `<span class="flag-container">
                                       ${dataMap}
                                    </span>`
                         return temp;
                     }
                },
                {
                    "data": "influencer_count",
                },
                {
                    "data": "influencer_per_day",
                },
                {
                    "data": "attendees",
                },
                {
                     "data": "start_date",
                     render:function (data, type){
                         if( jQuery.type(data) == 'object'){
                             let html = `<div class="row">`
                             html+=`<div class="col-md-12"> Visit : ${ data }</div>`
                             html+=`<div class="col-md-12"> Delivery : ${ data }</div>`
                             html += `</div>`
                             return html
                         }else{
                             return data
                         }
                     }
                },
                {
                    "data": "end_date",
                    render:function (data, type){

                        if( jQuery.type(data) == 'object'){
                            let html = `<div class="row">`
                            html+=`<div class="col-md-12"> Visit : ${ data['visit'] }</div>`
                            html+=`<div class="col-md-12"> Delivery : ${ data['delivery'] }</div>`
                            html += `</div>`
                            return html
                        }else{
                            return data
                        }
                    }
                },





                {
                    "data": "secrets",
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
                {"data": "created_at",},
                {
                    "data": "camp_id",
                    render: function (data, type) {
                        let route_edit = '/dashboard/campaigns/' + data.id + '/edit'
                        let route_show = '/dashboard/campaigns/' + data.id
                        $t = `<td>
                                <div class="actions">
                                @can('read campaigns')
                                    <a style="background:transparent !important;width:2px !important;" href="${route_show}" class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Show Campaign">
                                        <i class="icon-eye text-warning" style="font-size:16px;"></i>
                                    </a>
                                 @endcan

                                @can('update campaigns')
                                     <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-primary"  data-placement="top" title="Edit Campaign" >
                                        <i class="icon-edit-3 text-success" style="font-size:16px;"></i>
                                    </a>
                                @endcan
                                @can('delete campaigns')
                                 <button style="background:transparent !important;width:2px !important;" class="campaigns btn btn-danger delRow" data-id="${data.id}" id="del-${data.id}" data-toggle="tooltip" data-placement="top" title="Delete Campaign" >
                                        <i class="icon-trash-2 text-danger" style="font-size:16px;"></i>
                                 </button>
                               @endcan
                            </div>
                            </td>`;
                            if(data.status.value == 1){
                                console.log(data);
                                $t +=
                                `@can('update campaigns')
                                    <button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Active Campaign" class="btn btn-success mt-2 mb-2 acceptRow active_campaign" id="accept-${data.id}" data-id="${data.id}" >
                                                <i class="icon-check-circle" style="font-size: 16px;"></i>
                                    </button>
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
            console.log(3)
            e.preventDefault();

            campaignTabel.ajax.reload();
        })
        //Delete
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'), campaignTabel);
        });

        //Toggle Status
        $('#exampleTbl tbody').on( 'click','.active_campaign', function (event) {
            let id = $(this).data('id');
            console.log('id cam',id);
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
                console.log(selectedIds);
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
