<script>
    $('#CaseStudiesTable input[name="select_all"]').click(function () {
        $('#CaseStudiesTable td input.box1:checkbox').prop('checked', this.checked);
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

                    reqUrl = `/dashboard/caseStudies/${id}`;


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


    function displayInputs(lang,CaseStudiesTable){
        $('input[name="lang"]').val(lang);
        CaseStudiesTable.clear();
        CaseStudiesTable.ajax.reload();
        CaseStudiesTable.draw();
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
        $(function() {
    $(':input[type="number"]').each(function () {
        $(this).attr('min',0);
     });
});
        let status_type;
        let CaseStudiesTable = $("#CaseStudiesTable").DataTable({
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
                url: "{{route('dashboard.casestudies.datatable')}}",
                headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                data: function (d) {


                }
            },
            "columns": [
                // {
                //     "data": "id",
                // },
                {"data": "total_followers",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }
                },
                {"data": "total_influencers",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},
                {"data": "campaign_name",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},
                {"data": "total_days",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},
                {"data": "real",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},
                {"data": "client_profile_link",
                    render :function (data){
                        return `
                                <span class="_username_influncer">${data}</span>`;
                    }},

                {
                    "data": "id",
                    render: function (data, type) {

                        let route_edit = `/dashboard/caseStudies/${data}/edit`
                        return `<td>
                        @can('update faqs')
                             <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-success mt-2 mb-2">
                                <i class="far fa-edit text-success" style="font-size:16px;"></i>
                            </a>
                         @endcan

                        @can('delete faqs')
                         <button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 deletecase" data-id="${data}" id="del-${data}">
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



        //Delete
        $(document).on('click','.deletecase',function (){

            swalDel($(this).attr('data-id'), CaseStudiesTable);
            CaseStudiesTable.ajax.reload();
        });

        let lang = $('.lang.active').data('value');
        $('.nav-link').click(function (){
            $(this).closest('.nav-pills').find('.nav-link.active').removeClass('active');
            $(this).addClass('active');
            lang = $(this).data('value');
            displayInputs(lang,CaseStudiesTable)
        })
        displayInputs(lang,CaseStudiesTable)


    });
</script>
