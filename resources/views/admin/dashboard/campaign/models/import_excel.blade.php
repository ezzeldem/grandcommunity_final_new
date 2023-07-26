<div class="modal fade effect-newspaper show grand-add-model" id="import_excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Drag and drop Excel file
                </h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body" >
                <form style="display:flex;align-items :center ; gap :20px"  method="POST" enctype="multipart/form-data" id="submit_import_form">
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-12" style="width: 478px;height: 182px">
                            <input type="hidden" name="camp_id" id="campaign_id" value="{{$campaign->id}}">
                            <input type="hidden" name="campaign_type" id="campaign_type" value="{{$campaign->campaign_type}}">
                            <input type="hidden" name="brand_id" id="brand_id" value="{{$campaign->brand_id}}">
                            <input type="hidden" name="countryId" id="countryId" value="{{implode(',',$campaign->campaignCountries->pluck('country_id')->toArray())}}">
                            <input type="file" name="file" class="dropify" id="import_excel_status"  accept=".xls,.xlsx, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <a download="/file.xlsx" type="button" class="btn Import" href="{{ asset('assets/import_files/influencersCampList.xlsx')}}"
                    > <i class="bi bi-download"></i>
                    <i class="fas fa-download"></i> Sample</a>
                    <div class="btn">
                        <button type="button" data_url="{{route('dashboard.camp.addInfluencer.import')}}" id="import_excel_btn" class="grand-add-button">Save</button>
                        <button type="button" class="grand-add-close" data-dismiss="modal">Close</button>
                    </div>

            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready( function () {
            var url
            $('#import_excel_addInfluencer').click(function (){
                url= $(this).attr('data_url');
            })
            $(document).on('click', '#import_excel_btn', function (e) {
                url= $(this).attr('data_url');
                let import_excel = $('#import_excel_status').val();
                if (import_excel == '' || import_excel == null) {
                    e.preventDefault();
                    Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
                } else {

                    var formData = new FormData();
                    var file_data = $('#import_excel_status').prop('files')[0];
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('file', file_data);
                    formData.append('camp_id', $('#campaign_id').val());
                    formData.append('brand_id', $('#brand_id').val());
                    formData.append('country_id', $('#countryId').val());
                    formData.append('campaign_type', $('#campaign_type').val());

                    $.ajax({
                        type: 'POST',
                        url: url,
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

                    $(".dropify-clear").trigger("click");
                }
            });
        })
    </script>
@endpush

