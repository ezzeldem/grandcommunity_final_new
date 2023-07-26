<!--Add Modal -->
<div class="modal fade" id="add_branch" tabindex="-1" role="dialog" aria-labelledby="add_branch" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row row-sm">
                    <input class="form-control" name="brand_id" id="brand_id" type="hidden"
                        value="{{ $brand->id ?? 0 }}">
                    <input class="form-control" name="subBrandId" id="subBrandId" type="hidden"
                        value="{{ $subbrand->id ?? 0 }}">
                    <input class="form-control" name="branch_id" id="branch_id" type="hidden">

                    <div class="col-12">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Branch Name: <span class="text-danger">*</span></label>
                            <input class="form-control" name="branch_name" id="branch_name" placeholder="Enter Name"
                                type="text">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Brands: <span class="text-danger">*</span></label>
                            <select class="form-control" name="subbrandss" id="subbrandss"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                <option disabled selected value="">Select</option>
                                @if (isset($brand))
                                    @foreach (getSubBrands($brand) as $subbrand)
                                        <option value="{{ $subbrand->id }}">{{ $subbrand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Country: <span class="text-danger">*</span></label>
                            <select class="form-control" name="branch_country" placeholder="Select" id="branch_country">
                                <option disabled selected value="">Select</option>
                                {{-- @if (isset($brand))
                                    @foreach (getBrandCountries($brand) as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                @else
                                    @foreach ($subbrand->country_id as $country)
                                        <option value="{{country($country)->id}}">{{country($country)->name}}</option>
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mg-b-0">
                            <label class="form-label">State: <span class="text-danger">*</span></label>
                            <select class="form-control" name="branch_state" id="branch_state"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                <option disabled selected value="">Select</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mg-b-0">
                            <label class="form-label">City: <span class="text-danger">*</span></label>
                            <select class="form-control" name="branch_city" id="branch_city"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                <option disabled selected value="">Select</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Address: <span class="text-danger">*</span></label>
                            <input class="form-control" name="address" id="address" placeholder="Enter Address"
                                type="text">

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Status: <span class="text-danger">*</span></label>
                            <select class="form-control" name="branch_status" id="branch_status"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                <option label="Choose status" disabled selected>
                                </option>
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                <button type="button" class="btn Active hvr-sweep-to-right" id="savenewbranch">save</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/influencer/cit_state.js') }}"></script>

    <script>
        $('#branch_country').val('')
        $(document).on('change', '#branch_country', function() {
            let idselect = 'branch_state';
            $('#branch_city').val('');
            $('#branch_state').val('');
            getStatesData($(this).val(), idselect)

        });

        $("#branch_state").change(function() {
            let idselect = 'branch_city';
            $('#branch_city').val('');
            getCityData($(this).val(), idselect)
        });

        // $("#branch_country").change(function() {
        //     let brand_id = $('#brand_id').val();
        //     if(window.location.pathname.split("/")[3] == 'groups'){
        //         let sub_brand_id = $('[name=subBrandId]').val();
        //         var url = window.location.pathname.split("/")[3];
        //         getSubBrandCountryData($(this).val(), brand_id, sub_brand_id, url);
        //     }else{
        //         $('#subbrandss').val('');
        //         getSubBrandCountryData($(this).val(),brand_id)
        //     }
        // });

        $("#subbrandss").change(function() {
            let idselect = 'branch_country';
            $('#branch_country').val('');
            getSubbrandCountriesData($('#subbrandss').val(), idselect);
        });

        $('#savenewbranch').on('click', function() {
            console.log("edit function ##########")
            let branch_name = $('#branch_name').val();
            let branch_city = $('#branch_city').val();
            let branch_state = $('#branch_state').val();
            let branch_country = $('#branch_country').val();
            let branch_status = $('#branch_status').val();
            let branch_id = $('#branch_id').val();
            let subbrannd_id = $('#subbrandss').val();
            let address = $('#address').val();
            let brand_id = $('#brand_id').val();
            let sub_brand_id = $('#subBrandId').val();

            if (branch_name == '' || branch_name == null || branch_city == '' || branch_city == null ||
                branch_state == '' || branch_state == null || branch_country == '' || branch_country == null ||
                branch_status == '' || branch_status == null || address == '' || address == null || subbrannd_id ==
                '' || subbrannd_id == null) {
                Swal.fire("Error", "Please enter all data to save the branch", "error");
                return;
            } else {
                let route = '/dashboard/add-new-branch';
                $.ajax({
                    url: route,
                    type: 'post',
                    data: {
                        branch_name: branch_name,
                        branch_city: branch_city,
                        branch_state: branch_state,
                        branch_country: branch_country,
                        branch_status: branch_status,
                        brand_id: brand_id,
                        sub_brand_id: sub_brand_id,
                        branch_id: branch_id,
                        subbrannd_id: subbrannd_id,
                        address: address,
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        console.log(data);
                        for (let statictic in data.stat) {
                            let elId = data.stat[statictic].id;
                            $(`#${elId}`).find('.counters').text(data.stat[statictic].count)
                        }
                        branchtable.ajax.reload();

                        $('#branch_country').val('');
                        $('#branch_status').val(null).trigger('change');
                        $('#subbrandss').val(null).trigger('change');
                        $('#branch_city').val('');
                        $('#branch_state').val('');
                        $('#branch_name').val('');
                        $('#address').val('');
                        $('#add_branch').modal('hide');
                        Swal.fire("Inserted!", "Done Successfully!", "success");
                    },
                    error: (data) => {
                        let _err = 'something went wrong please reload page'
                        if (data.responseJSON.errors && data.responseJSON.errors.name)
                            _err = data.responseJSON.errors.name[0]
                        Swal.fire("error", _err, "error");
                    }
                })
            }
        })
    </script>
@endpush
