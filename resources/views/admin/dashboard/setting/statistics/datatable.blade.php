<script>
    $('#statisticsTable input[name="select_all"]').click(function () {
        $('#statisticsTable td input.box1:checkbox').prop('checked', this.checked);
    });

    function swalStatus(id, tabel ){
        Swal.fire({
            title: "Are you sure you want to change status?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Change',
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },function(isConfirm){
            if (isConfirm){
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
                    reqUrl = `/dashboard/statistics/${id}`;
                else if(typeof id == "object")
                    reqUrl = `/dashboard/statistics-delete`;


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

    function displayInputs(lang,statisticsTabel){
        $('input[name="lang"]').val(lang);
        statisticsTabel.clear();
        statisticsTabel.ajax.reload();
        statisticsTabel.draw();
        if(lang == 'ar'){
            $('.ar-inputs').disabled=false;
            $('.ar-inputs').closest('.ar').css('display','block');

            $('.en-inputs').disabled=true;
            $('.en-inputs').closest('.en').css('display','none');
        }else{
            $('.en-inputs').disabled=false;
            $('.en-inputs').closest('.en').css('display','block');

            $('.ar-inputs').disabled=true;
            $('.ar-inputs').closest('.ar').css('display','none');
        }

    }

    $(document).ready( function () {
        let status_type;
        let statisticsTabel = $("#statisticsTable").DataTable({
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
                url: "{{route('dashboard.statistics.datatable')}}",
                headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                data: function (d) {
                    d.lang = $('.lang.active').data('value');
                }
            },
            "columns": [
                {
                    "data": "id",
                },
                {
                    data: 'title',
                    render :function (data,type,full){
                        return `
                                <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="image">
                                <span class="_username_influncer">${data}</span>`;
                    }
                },
                // {
                //     "data": "image",
                //     render: function(data, type) {
                //         return `<img src="${data}" class="img-thumbnail" height="70" width="70" alt="">`;
                //     }
                // },
                // {
                //     "data": "body",
                // },
                {"data": "count",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
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

                {
                    "data": "id",
                    render: function (data, type) {
                        let route_edit = `/dashboard/statistics/${data}/edit`
                        return `<td>
                         @can('update statistics')
                             <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2">
                                <i class="far fa-edit text-success" style="font-size:16px;"></i>
                            </a>
                         @endcan

                        @can('delete statistics')
                         <button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRow" data-id="${data}" id="del-${data}">
                            <i class="far fa-trash-alt text-danger" style="font-size:16px;"></i>
                         </button>
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
        //Switch
        $('#statisticsTable tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            $(this).disabled=true;
            activeToggle(id,$(this));
        })
        //active toggle request
        function activeToggle(id,el){
            $.ajax({
                url:`/dashboard/statistics-toggle-status/${id}`,
                type:'post',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(response)=>{
                    el.disabled=false;
                    Swal.fire("Updated!", "status changed Successfully!", "success");
                    statisticsTabel.clear();
                    statisticsTabel.ajax.reload();
                    statisticsTabel.draw();
                },
                error:()=>{
                    el.disabled=false;
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        }

        //Delete
        $(document).on('click','.delRow',function (){
            swalDel($(this).attr('data-id'), statisticsTabel);
        });

        //Bulck Delete
        let selectedIds = [];
        // options dropdown
        $('#btn_status_all, #btn_delete_all').click(function (){
            selectedIds = $("#statisticsTable td input.box1:checkbox:checked").map(function(){
                return $(this).val();
            }).toArray();
        })

        // delete all toggle
        $('#btn_delete_all').click(function (){
            if(selectedIds.length)
                swalDel(selectedIds, statisticsTabel)
            else
                Swal.fire("error", "please select Page at least", "error");
        })
        $('#btn_status_all').click(function (){
            console.log(selectedIds)
            if(selectedIds.length)
                swalStatus(selectedIds, statisticsTabel)
            else
                Swal.fire("error", "please select Page at least", "error");
        })

        let lang = $('.lang.active').data('value');
        $('.nav-link').click(function (){
            $(this).closest('.nav-pills').find('.nav-link.active').removeClass('active');
            $(this).addClass('active');
            lang = $(this).data('value');
            displayInputs(lang,statisticsTabel)
        })
        displayInputs(lang,statisticsTabel)
    });
</script>
