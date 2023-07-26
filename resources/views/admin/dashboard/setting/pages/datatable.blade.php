<script>
    $('#pagesTable input[name="select_all"]').click(function () {
        $('#pagesTable td input.box1:checkbox').prop('checked', this.checked);
    });

    function swalStatus(id, tabel ){
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
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: '/dashboard/pages-status',
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
            title: "Are you sure you want delete?",
            text: "You won't be able to restore this data",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Delete',
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed){
                let reqUrl = ``;
                if(typeof id == "string")
                    reqUrl = `/dashboard/pages/${id}`;
                else if(typeof id == "object")
                    reqUrl = `/dashboard/pages-delete`;
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
        let pagesTabel = $("#pagesTable").DataTable({
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

            ajax: {
                    url :'/dashboard/pages-datatable',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.status_val = $('#status_id_search').val();

                    }
                },
            'aaSorting': [[1, 'asc']],
            "columns": [
                {
                    "data": "id",
                    "sortable": false,
                    render: function (data, type) {
                        return '<input type="checkbox"  value="' + data.id + '" class="box1" >';
                    }
                },
                {"data": "title_ar",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},
                {
                    "data": "title_en",
                    render :function (data,type){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }
                },
                {
                    "data": "image",
                    render: function(data, type) {
                        if(data != null){
                            return `<img src="${data}" class="img-thumbnail" height="70" width="70" alt="">`;
                        }else{
                            return `__`;
                        }
                    }
                },
                {"data": "position",
                    render :function (data,type){
                        if(data == 1){
                            return  `<span class="_username_influncer">Footer</span>`
                        }else{
                            return  `<span class="_username_influncer ">Header</span>`
                        }
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
                    render :function (data,type){
                        return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `;
                    }
                },
                {"data": "created_by",
                    render :function (data,type){
                        return `
                                <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                            `;
                    }
                },
                {
                    "data": "id",
                    render: function (data, type) {
                        let route_edit = '/dashboard/pages/' + data.id + '/edit'
                        return `<td>
                        @can('read pages')
                            <a style="background:transparent !important;width:2px !important;" href="/page/${data.slug}" target="_blank" class="btn btn-info mt-2 mb-2 brand_groups">
                               <i class="far fa-eye text-warning" style="font-size: 16px;"></i>

                            </a>
                        @endcan
                         @can('update pages')
                            <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2">
                                <i class="far fa-edit text-success" style="font-size: 16px;"></i>
                            </a>
                         @endcan
                        @can('delete pages')
                            ${(!staticPage.includes(data.slug)) ?
                                `<button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" data-id="${data.id}"
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
                searchPlaceholder: 'Search',
                sSearch: '',
            }
        });

        $('#Total_Pages').on('click',function(){

                    $('#status_id_search').val(null);
                    pagesTabel.ajax.reload();
                });
                $('#Active_Pages').on('click',function(){

                    $('#status_id_search').val(1);
                    pagesTabel.ajax.reload();
                });
                $('#InActive_Pages').on('click',function(){

                    $('#status_id_search').val(0);
                    pagesTabel.ajax.reload();
                });
        //Switch
        $('#pagesTable tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            $.ajax({
                url:`/dashboard/pages-toggle-status/${id}`,
                type:'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "Status Changed Successfully!", "success");
                    pagesTabel.ajax.reload();
                },
                error:()=>{
                    Swal.fire("Error", "Something went wrong please reload page", "error");
                }
            })
        })

        //Delete
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'), pagesTabel);
        });

        //Bulck Delete
        let selectedIds = [];
        // options dropdown
        $('#btn_status_all, #btn_delete_all').click(function (){
            selectedIds = $("#pagesTable td input.box1:checkbox:checked").map(function(){
                 return $(this).val();
            }).toArray();
        })

        // delete all toggle
        $('#btn_delete_all').click(function (){
            if(selectedIds.length)
                swalDel(selectedIds, pagesTabel)
            else
                Swal.fire("Error", "Please select a page first", "error");
        })
        $('#btn_status_all').click(function (){
            console.log(selectedIds)
            if(selectedIds.length)
                swalStatus(selectedIds, pagesTabel)
            else
                Swal.fire("Error", "Please select a page first", "error");
        })

    });
</script>
