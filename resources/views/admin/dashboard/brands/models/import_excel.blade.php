<div class="modal fade effect-newspaper show" id="dislikes_import_excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Drag and drop Excel file
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form style="display:flex;align-items :center ; gap :20px" action="" method="POST" enctype="multipart/form-data" id="submit_import_form">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-12" style="width: 478px;height: 182px">
                            <input type="file" name="file" class="dropify" id="import_excel_dislike_status"  accept=".xls,.xlsx, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <a download="/file.xlsx" type="button" class="btn btn-dark text-muted"
                    @if(Route::currentRoutename() == 'dashboard.influences.index') href="{{ asset('assets/import_files/influencers.xlsx')}}"
                    @endif
                    > <i class="bi bi-download"></i>
                    <i class="fas fa-download"></i> Sample</a>
                <div class="btn">
                    <button type="button" id="import_excel_dislike_btn" class="btn Active hvr-sweep-to-right">Save</button>
                    <button type="button" class="btn hvr-sweep-to-right Delete"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready( function () {

    $(document).on('click', '#import_excel_dislike_btn', function (e) {
    let import_excel = $('#import_excel_dislike_status').val();
    if (import_excel == '' || import_excel == null) {
        console.log('impty');
        e.preventDefault();
        Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
    } else {
        let modal_box = document.querySelector("#import_excel_dislike_status");

        var formData = new FormData();
        var file_data = $('#import_excel_dislike_status').prop('files')[0];
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('file', file_data);
        formData.append('camp_id', $('#campaign_id').val());
        formData.append('brand_id', $('#brand_id').val());
        var brand_id = $('#brand_id').val();
        // var url=$('.modal-body form').getAttribute('action');


        $.ajax({
            type: 'POST',
            url: "{{ url('/dashboard/dislikes/import/') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                let countSuccess=0
                let countFaild=0
                let name=[];
                data.message.map((msg)=> (msg.status=='success')?(countSuccess = countSuccess+1):(countFaild=countFaild+1 ,name.push(msg.Name+'---'+msg.message)));
                let item=name.map((i,key)=> `<li>${key+1} - ${i}  <small></small> </li>`).join('');
                Swal.fire("Done", `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`, "success");
                name=[];
                $('#import_excel').modal('hide');
                exampleTbl.ajax.reload()
            },
        });
    }
});
})
    </script>
@endpush
