<div class="modal fade effect-newspaper show" id="change_details_influencer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Change Influencer Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="influe_id"; />
                <div class="row" >
                    <div class="col">
                        <label><b>Instagram Username</b></label>
                        <input type="text" class="form-control" name="influe_insta_uname" place="Enter Instagram Username" id="influe_insta_uname"/>
                        <small id="old_influe_insta_uname" class="text-warning">good</small>
                        <br>
                        <small id="insta_uname_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <div class="row">
                        <div class="col-4">
                            <label><b>Code</b></label>
                            <select class="form-control" id="influe_code" name="influe_code" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" >
                                <option disabled selected> Select</option>
                                @foreach($all_countries_data as  $country)
                                    <option value="{{$country->phonecode}}"> (+){{$country->phonecode}} </option>
                                @endforeach
                            </select>
                            <small id="old_influe_code" class="text-warning">good</small>
                            <br>
                            <small id="code_error" class="text-danger"></small>
                        </div>
                            <div class="col-8">
                                <label><b>Phone Number</b></label>
                                <input type="number" class="form-control" name="influe_phone" placeholder="Enter Phone Number" id="influe_phone"/>
                                <small id="old_influe_phone" class="text-warning">good</small>
                                <br>
                                <small id="phone_error" class="text-danger"></small>
                            </div>

                        </div>



                    </div>
                </div>
                <div class="row" >
                    <div class="col">
                        <label><b>Address (Ar)</b></label>
                        <input type="text" class="form-control" name="influe_address_ar" placeholder="Enter Address" id="influe_address_ar"/>
                        <small id="old_influe_address_ar" class="text-warning">good</small>
                        <br>
                        <small id="address_ar_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row" >
                    <div class="col">
                        <label><b>Address (En)</b></label>
                        <input type="text" class="form-control" name="influe_address_en" placeholder="Enter Address" id="influe_address_en"/>
                        <small id="old_influe_address_en" class="text-warning">good</small>
                        <br>
                        <small id="address_en_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row" >
                    <div class="col">
                        <label><b>Status</b></label>
                        <select class="form-control select2 " multiple="multiple" name="influe_status[]" placeholder="Select" id="influe_status" >
                        </select>
                        <small id="old_influe_status" class="text-warning">good</small>
                    </div>
                </div>
                <div class="row" >
                    <div class="col">
                        <label class="form-label">Country: <span class="text-danger">*</span></label>
                        <select class="form-control" id="influe_country_id" name="influe_country_id" data-parsley-class-handler="#slWrapper2" placeholder="Select" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" >
                           <option disabled selected> Select </option>
                            @foreach($all_countries_data as  $country)
                                <option value="{{$country->id}}" {{ old('country_id') == $country->id ? "selected":""}} >{{$country->name}}</option>
                            @endforeach
                        </select>

                        <small id="old_influe_country_id" class="text-warning">good</small>
                        <br>
                        <small id="country_id_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">Government: <span class="text-danger">*</span></label>
                        <select class="form-control" id="influe_state_id" name="influe_state_id" data-parsley-class-handler="#slWrapper2" placeholder="Select" Select data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" >

                        </select>

                        <small id="old_influe_state_id" class="text-warning">good</small>
                        <br>
                        <small id="state_id_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="form-label">City: <span class="text-danger">*</span></label>
                        <select class="form-control" id="influe_city_id" name="influe_city_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" >

                        </select>

                        <small id="old_influe_city_id" class="text-warning">good</small>
                        <br>
                        <small id="city_id_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row" >
                    <div class="col">
                        <label><b>Date of Return</b></label>
                        <input type="date" class="form-control" name="influe_return_date" id="influe_return_date"/>
                        <small id="return_date_error" class="text-danger"></small>
                    </div>
                </div>
                <div class="row" >
                    <div class="col">
                        <label><b>Note</b></label>
                        <textarea class="form-control" name="note" id="note">

                        </textarea>
                        <small id="note_error" class="text-danger"></small>
                    </div>
                </div>




                <div class="modal-footer">
                    <button type="button" id="submit_change_influe_details" style="" class="btn"><i class="fa fa-plus-circle"></i> Save</button>
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{asset('/js/influencer/cit_state.js')}}"></script>
    <script>

        $('#brands_groups').select2({
            placeholder: "Select",
            allowClear: true
        });
        $("#influe_country_id").change(function() {
            getStatesData($(this).val(),'influe_state_id')
        });
        $("#influe_state_id").change(function() {
            getCityData($(this).val(),'influe_city_id')
        });

        $(document).on('click','#submit_change_influe_details',function (){
            var influe_insta_uname= $('#influe_insta_uname').val();
            var influe_phone= $('#influe_phone').val();
            var influe_address= {'ar':$('#influe_address_ar').val(),'en':$('#influe_address_en').val()};
            var influe_country_id= $('#influe_country_id').val();
            var influe_state_id= $('#influe_state_id').val();
            var influe_city_id= $('#influe_city_id').val();
            var influencer_id= $('#influe_id').val();
            var status= $('#influe_status').val();
            var note= $('#note').val();
            var influe_return_date= $('#influe_return_date').val();
            var code= $('#influe_code').val();
            $.ajax({
                type: "POST",
                url:  "/dashboard/influe/submit_influ_change_details/",
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    influencer_id:influencer_id,
                    insta_uname:influe_insta_uname,
                    phone:influe_phone,
                    code:code,
                    address:influe_address,
                    status:status,
                    country_id:influe_country_id,
                    state_id:influe_state_id,
                    city_id:influe_city_id,
                    return_date:influe_return_date,
                    current:0,
                    note:note,
                },
                success: function (data) {
                    Swal.fire("Change Detail!", "Change Detail Successfully!", "success");
                    $('#change_details_influencer').modal('hide');
                    influe_tabels.ajax.reload();
                },

                error : function(data) {
                   var errors =JSON.parse(data.responseText).errors
                    $.each(errors, function (key, val) {
                        if(key=='address.ar'){
                            key='address_ar'
                        }
                        if(key=='address.en'){
                            key='address_en'
                        }
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
        //details_change_modal
        $(document).on('click','#change_detail_influencer',function (){
            var influe_id =$(this).attr('data-id');
            $.ajax({
                type: "POST",
                url:  "/dashboard/influe/influ_details/",
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    influencer_id:influe_id
                },
                success: function (data) {
                    $('#influe_status').select2({
                        placeholder: "Select",
                        allowClear: true
                    });

                    $('#old_influe_insta_uname').html(`( Current Value : ${(data.influencerDetails.change_detail)?data.influencerDetails.change_detail.insta_uname:data.influencerDetails.insta_uname})`);
                    $('#old_influe_phone').html(`( Current Value :${(data.influencerDetails.change_detail)?data.influencerDetails.change_detail.phone:(data.influencerDetails.user.phone)??'--'})`);
                    $('#old_influe_code').html(`( Current Value :${(data.influencerDetails.change_detail)?data.influencerDetails.change_detail.code:(data.influencerDetails.user.code)??'--'})`);
                    $('#old_influe_address_ar').html(`( Current Value :${(data.influencerDetails.address_ar)??'--'})`);
                    $('#old_influe_address_en').html(`( Current Value :${(data.influencerDetails.address_en)??'--'})`);
                    $('#old_influe_country_id').html(`( Current Value :${(data.influencerDetails.countryName)??'--'})`);
                    $('#old_influe_state_id').html(`( Current Value :${(data.influencerDetails.stateName)??'--'})`);
                    $('#old_influe_city_id').html(`( Current Value :${(data.influencerDetails.cityName)??'--'})`);
                    $('#influe_id').val(data.influencerDetails.id);
                    var html='';
                    var status=[];
                    $.each( data.socialStatus, function( key, value ) {
                        if(data.influencerDetails.change_detail){
                            if(data.influencerDetails.change_detail.status.includes(value.value.toString())){
                                status.push(value.name);
                            }
                        }else{
                            if(data.influencerDetails.status.includes(value.value.toString())){
                                status.push(value.name);
                            }
                        }

                        html+=`<option value="${value.id}">${value.name}</option>`
                    })
                    $('#influe_status').html(html)
                    $('#old_influe_status').html(`( Current Value : ${status.join(',')} )`)

                },

                error : function(data) {

                }
            });
            $('#change_details_influencer').modal('show')
        })

        $('#change_details_influencer').on('hidden.bs.modal', function (e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("small")
                .text("")
                .end();

        })
    </script>
@endpush
