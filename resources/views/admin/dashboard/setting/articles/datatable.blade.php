<script>
    $('#articlesTable input[name="select_all"]').click(function () {
        $('#articlesTable td input.box1:checkbox').prop('checked', this.checked);
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
                    url: '/dashboard/articles-status',
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
                        Swal.fire("Error", "something went wrong please reload page", "error");
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
                    reqUrl = `/dashboard/articles/${id}`;
                else if(typeof id == "object")
                    reqUrl = `/dashboard/articles-delete`;
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
                        Swal.fire("Error", "something went wrong please reload page", "error");
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
        let articlesTabel = $("#articlesTable").DataTable({
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
                url: "{{route('dashboard.articles.datatable')}}",
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
                {"data": "title_ar",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }
                },
                {"data": "title_en",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }
                },
                {
                    "data": "image",
                    render: function(data, type) {
                        return `<img src="${data}" class="img-thumbnail" height="70" width="70" alt="">`;
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
                    }},
                {"data": "created_by",
                    render :function (data,type){
                        return `
                                <span class="_createdAt_table"> ${data} </span>
                            `;
                    }
                },
                {
                    "data": "id",
                    render: function (data, type) {
                        let route_edit = '/dashboard/articles/' + data.id + '/edit'
                        let route_comment = '/dashboard/comments/' + data.id
                        return `<td>
                        @can('read articles')
                            <a style="background:transparent !important;width:2px !important;" href="/blog/${data.id}" target="_blank" class="btn btn-info mt-2 mb-2 brand_groups">
                               <i class="far fa-eye" style="font-size: 16px;"></i>
                            </a>
                        @endcan
                        @can('update articles')
                        <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2">
                            <i class="far fa-edit" style="font-size: 16px;"></i>
                        </a>
                        @endcan
                        @can('delete articles')
                            ${(!staticPage.includes(data.slug)) ?
                                `<button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" data-id="${data.id}"
                                        id="del-${data.id}">
                                    <i class="far fa-trash-alt" style="font-size: 16px;"></i>
                                </button>`:``
                            }
                        @endcan
                        @if(user_can_any('comments'))
                            <a style="background: #1e1e1e;" href="${route_comment}" class="btn ml-2 hvr-sweep-to-right">
                                Comments <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        @endif
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
        //Switch
        $('#articlesTable tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            $.ajax({
                url:`/dashboard/articles-toggle-status/${id}`,
                type:'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    articlesTabel.ajax.reload();
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        })

        //Delete
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'), articlesTabel);
        });

        //Bulck Delete
        let selectedIds = [];
        // options dropdown
        $('#btn_status_all, #btn_delete_all').click(function (){
            selectedIds = $("#articlesTable td input.box1:checkbox:checked").map(function(){
                 return $(this).val();
            }).toArray();
        })

        // delete all toggle
        $('#btn_delete_all').click(function (){
            if(selectedIds.length)
                swalDel(selectedIds, articlesTabel)
            else
                Swal.fire("error", "Please select an article first", "error");
        })
        $('#btn_status_all').click(function (){
            console.log(selectedIds)
            if(selectedIds.length)
                swalStatus(selectedIds, articlesTabel)
            else
                Swal.fire("error", "Please select an article first", "error");
        })


    });
</script>
