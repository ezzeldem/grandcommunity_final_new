<div class="modal fade effect-newspaper show" id="import_excels" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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
            <div class="modal-body">
                <form style="display:flex;align-items :center ; gap :20px"
                        @if(Route::currentRoutename() == 'dashboard.influences.index')

                          action="{{  url('dashboard/influe/import') }}"
                        @elseif(Route::currentRoutename() == 'dashboard.brands.index')

                          action="{{  route('dashboard.import') }}"
                        @elseif(Route::currentRoutename() == 'dashboard.sub-brands.index')
                          action="{{  route('dashboard.sub-brands.import') }}"
                        @elseif(Route::currentRoutename() == 'dashboard.branches.index')
                          action="{{  route('dashboard.branches.import') }}"
                        @elseif(Route::currentRoutename() == 'dashboard.admins.index')
                          action="{{  route('dashboard.importadmin.import') }}"
                        @elseif(Route::currentRoutename() == 'dashboard.operations.index')
                          action="{{  route('dashboard.importoperation.import') }}"
                        @elseif(Route::currentRoutename() == 'dashboard.sales.index')
                          action="{{  route('dashboard.getimportsales.import') }}"

                        @endif

                      method="POST" enctype="multipart/form-data" id="submit_import_form">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-12" style="width: 478px;height: 182px">
                            <input type="file" name="file" class="dropify" id="import_excel"  accept=".xls,.xlsx, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <a download="/file.xlsx" type="button" class="btn btn-dark"
                   @if(Route::currentRoutename() == 'dashboard.influences.index') href="{{ asset('assets/import_files/influencers.xlsx')}}"
                   @elseif(Route::currentRoutename() == 'dashboard.brands.index') href="{{asset('assets/import_files/brands.xlsx')}}"
                   @elseif(Route::currentRoutename() == 'dashboard.sub-brands.index') href="{{asset('assets/import_files/sub_brand.xlsx')}}"
                   @elseif(Route::currentRoutename() == 'dashboard.branches.index') href="{{asset('assets/import_files/branches.xlsx')}}"
                   @elseif(Route::currentRoutename() == 'dashboard.admins.index') href="{{asset('assets/import_files/Admins.xlsx')}}"
                   @elseif(Route::currentRoutename() == 'dashboard.operations.index') href="{{asset('assets/import_files/operation.xlsx')}}"
                   @elseif(Route::currentRoutename() == 'dashboard.sales.index') href="{{asset('assets/import_files/sales.xlsx')}}"
                   @endif

                    > <i class="bi bi-download"></i>
                    <i class="fas fa-download"></i> Sample</a>
                <div class="btn">
                    @if(Route::currentRoutename() == 'dashboard.influences.index')
                    <button type="button" id="general_import_influencers_excel_btn" class="btn Active hvr-sweep-to-right" data-url="{{  url('dashboard/influe/import') }}">Save</button>
                    @else
                        <button type="button" id="import_excel_btn" class="btn Active hvr-sweep-to-right">Save</button>
                    @endif
                    <button type="button" class="btn Delete hvr-sweep-to-right"
                        data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
    <!-- <script>
            // let import_excel = $('#import_excel').val();
            if("$('#import_excel').val() == '' "){
                $('#import_excel_btn').addClass('disabled');
            }
    </script>
    <script>
            // let import_excel = $('#import_excel').val();
            if("$('#import_excel').val()"){
                $('#import_excel_btn').addClass('disabled');
            }
    </script> -->
    <script>
        // else{
        //     $('#import_excel_btn').removeClass('disabled');
        // }

        $(document).ready( function () {
            $(document).on('click', '#import_excel_btn', function (e) {
                let import_excel = $('#import_excel').val();
                if (import_excel == '' || import_excel == null) {
                    e.preventDefault();
                    Swal.fire("Error", "Please select an Excel file", "error");
                } else {
                    $('#submit_import_form').submit();
                }
            });

            $(document).on('click', '#general_import_influencers_excel_btn', function (e) {
                url= $(this).data('url');
                let import_excel = $('#import_excel').val();
                if (import_excel == '' || import_excel == null) {
                    e.preventDefault();
                    Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
                } else {

                    var formData = new FormData();
                    var file_data = $('#import_excel').prop('files')[0];
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('file', file_data);
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
                            $('#influe').DataTable().ajax.reload()
                        },
                    });

                    $(".dropify-clear").trigger("click");
                }
            });
        })


    </script>
@endpush
