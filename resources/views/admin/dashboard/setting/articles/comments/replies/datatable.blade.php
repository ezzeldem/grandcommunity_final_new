<script>
    $('#repliesTable input[name="select_all"]').click(function () {
        $('#repliesTable td input.box1:checkbox').prop('checked', this.checked);
    });

    function swalStatus(id, tabel ){
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: '/dashboard/replies-status',
                    type:'post',
                    method:'post',
                    data: {id},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:()=>{
                        Swal.fire("Updated!", "Status Updated Successfully!", "success");
                        tabel.ajax.reload();
                        $("#select_all").prop("checked", false);
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong please reload page", "error");
                    }
                })
            } else {
                Swal.fire("Cancelled", "canceled successfully!", "error");
            }
        })
    }

    function swalDel(id, tabel ){
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed){
                let reqUrl = ``;
                if(typeof id == "string")
                    reqUrl = `/dashboard/replies/${id}`;
                else if(typeof id == "object")
                    reqUrl = `/dashboard/replies-delete`;
                $.ajax({
                    url: reqUrl,
                    type:'delete',
                    method:'delete',
                    data: {id},
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:()=>{
                        Swal.fire("Deleted!", "Deleted Successfully!", "success");
                        tabel.ajax.reload();
                        $("#select_all").prop("checked", false);
                    },
                    error:()=>{
                        Swal.fire("error", "something went wrong please reload page", "error");
                    }
                })
            } else {
                Swal.fire("Cancelled", "canceled successfully!", "error");
            }
        })
    }

    $(document).ready( function () {
        const staticPage = ['about','terms'];
        let status_type;
        let repliesTabel = $("#repliesTable").DataTable({
            lengthChange: true,
            processing: true,
            serverSide: true,
            responsive: true,
            searching: true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'colvis',
                    columns: 'th:nth-child(n+2)'
                }
            ],
            'columnDefs': [{ 'orderable': false, 'targets': 0 }],
            'aaSorting': [[1, 'asc']],
            "ajax": {
                url: "{{route('dashboard.replies.datatable',$id)}}",
                data: function (d) {
                }
            },
            "columns": [
                {
                    "data": "id",
                    "sortable": false,
                    render: function (data, type) {
                        return '<input type="checkbox"  value="' + data.id + '" class="box1" >';
                    }
                },
                {"data": "username",
                    render :function (data){
                        return `
                                <span class="_createdAt_table"> ${data} </span>
                            `;
                    }
                },
                {"data": "reply",
                    render :function (data){
                        return `
                                <span class="_createdAt_table"> ${data} </span>
                            `;
                    }
                },
                {
                    "data": "status",
                    "className" : 'switch_parent',
                    render :function (data,type){
                        if(data.status == 1){
                            return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}">
                                        <label class="switch" for="'switch-'${data.id}" title="active" ></label>`
                        }else{
                            return  `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle"  data-id="${data.id}">
                                            <label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                        }
                    }
                },
                {"data": "created_at",
                    render :function (data){
                        return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `;
                    }
                },
                {
                    "data": "id",
                    render: function (data, type) {
                        return `<td>
                        @can('read comments')
                            <a style="background:transparent !important;width:2px !important;" href="${data.slug}" target="_blank" class="btn mt-2 mb-2 brand_groups">
                               <i class="far fa-eye text-warning" style="font-size: 16px;"></i>

                            </a>
                        @endcan
                        @can('delete comments')
                            ${(!staticPage.includes(data.slug)) ?
                                `<button style="background:transparent !important;width:2px !important;" class="btn mt-2 mb-2 delRow" data-id="${data.id}"
                                        id="del-${data.id}">
                                    <i class="far fa-trash-alt text-danger" style="font-size: 16px;"></i>
                                </button>`:``
                            }
                         @endcan
                        </td>`;
                    }
                }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });
        //Switch
        $('#repliesTable tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            $.ajax({
                url:`/dashboard/replies-toggle-status/${id}`,
                type:'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    repliesTabel.ajax.reload();
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        })

        //Delete
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'), repliesTabel);
        });

        //Bulck Delete
        let selectedIds = [];
        // options dropdown
        $('#btn_status_all, #btn_delete_all').click(function (){
            selectedIds = $("#repliesTable td input.box1:checkbox:checked").map(function(){
                 return $(this).val();
            }).toArray();
        })

        // delete all toggle
        $('#btn_delete_all').click(function (){
            if(selectedIds.length)
                swalDel(selectedIds, repliesTabel)
            else
                Swal.fire("error", "please select Page at least", "error");
        })
        $('#btn_status_all').click(function (){
            console.log(selectedIds)
            if(selectedIds.length)
                swalStatus(selectedIds, repliesTabel)
            else
                Swal.fire("error", "please select Page at least", "error");
        })


    });
</script>
