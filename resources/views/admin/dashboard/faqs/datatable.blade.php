<script>
    $('#faqsTable input[name="select_all"]').click(function () {
        $('#faqsTable td input.box1:checkbox').prop('checked', this.checked);
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
                    url: '/dashboard/faqs-status',
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
                    reqUrl = `/dashboard/faqs/${id}`;
                else if(typeof id == "object")
                    reqUrl = `/dashboard/faqs-delete`;


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

    function displayInputs(lang,faqsTable){
        $('input[name="lang"]').val(lang);
        faqsTable.ajax.reload();
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
        let faqsTable = $("#faqsTable").DataTable({
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
                url: "{{route('dashboard.faqs.datatable')}}",
                headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                data: function (d) {
                    d.lang = $('.lang.active').data('value');
                }
            },
            "columns": [
                {
                    "data": "id",
                },
                {"data": "question",},
                {"data": "answer",},
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
                        let route_edit = `/dashboard/faqs/${data}/edit`
                        return `<td>
                        @can('update faqs')
                             <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2">
                                <i class="far fa-edit text-success" style="font-size:16px;"></i>
                            </a>
                         @endcan

                        @can('delete faqs')
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
        $('#faqsTable tbody').on( 'change', '.switch_toggle', function (event) {
            let id = $(this).data('id');
            $.ajax({
                url:`/dashboard/faqs-toggle-status/${id}`,
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
            swalDel($(this).attr('data-id'), faqsTable);
        });

        //Bulck Delete
        let selectedIds = [];
        // options dropdown
        $('#btn_status_all, #btn_delete_all').click(function (){
            selectedIds = $("#faqsTable td input.box1:checkbox:checked").map(function(){
                return $(this).val();
            }).toArray();
        })

        // delete all toggle
        $('#btn_delete_all').click(function (){
            if(selectedIds.length)
                swalDel(selectedIds, faqsTable)
            else
                Swal.fire("error", "please select Page at least", "error");
        })
        $('#btn_status_all').click(function (){
            console.log(selectedIds)
            if(selectedIds.length)
                swalStatus(selectedIds, faqsTable)
            else
                Swal.fire("error", "please select Page at least", "error");
        })

        let lang = $('.lang.active').data('value');
        $('.nav-link').click(function (){
            $(this).closest('.nav-pills').find('.nav-link.active').removeClass('active');
            $(this).addClass('active');
            lang = $(this).data('value');
            displayInputs(lang,faqsTable)
        })
        displayInputs(lang,faqsTable)
    });
</script>
