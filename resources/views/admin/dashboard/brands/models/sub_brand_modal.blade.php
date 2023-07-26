<!--Add Modal -->
<div class="modal fade" id="sub_brand_modal" role="dialog" aria-labelledby="add_branch" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px">
            <div class="modal-header">
                <h5 class="modal-title" id="subBrandModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="sub-brand-form">
                    <div class="col-12">
                        <div class="profile-avatar mb-5">
                            <ul>
                                <li> <img src="{{ old('image') ? asset('storage/' . old('image')) : ( isset($subBrand) && !empty($subBrand->image) ? $subBrand->image : '/assets/img/avatar_logo.png') }}" id="uploadedImage" alt=""> </li>
                                <li class="edit">
                                    <i class="far fa-edit"></i>
                                    <input type="file" name="image" id="inputFile" value="{{ old('fileReader') }}" class="@if ($errors->has('image')) parsley-error @endif" accept="image/x-png,image/gif,image/jpeg">
                                </li>
                                @error('image')
                                <span class="error-msg-input">{{ $message }}</span>
                                @enderror
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        {!! Form::hidden('sub_brand','',['class' =>'form-control','id'=>'sub_brand' ]) !!}
                        @if(isset($brand->id))
                            {!! Form::hidden('brand_id',$brand->id,['class' =>'form-control','id'=>'brand_subbrand_id' ]) !!}
                        @else
                            {!! Form::hidden('subbrand_d',$subbrand->id,['class' =>'form-control','id'=>'subbrand_id' ]) !!}
                        @endif
                        <div class="form-group mg-b-0">
                            <label class="form-label">Name: <span class="tx-danger">*</span></label>
                            {!! Form::text('name',null,['class' =>'form-control '.($errors->has('subbrand_name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'name' ]) !!}
                            @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                            @enderror
                        </div>
                    </div>



                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group custom-height">
                            <label class="form-label">Countries: <span class="tx-danger">*</span></label>
                            {!! Form::select("country_id[]",isset($brand) ? getBrandCountries($brand,true) : [] ,null,['class' =>'form-control '.($errors->has('country_id') ? 'parsley-error' : null),
                                'data-show-subtext'=>'true','data-live-search'=>'true',  'id' => 'subbrand_country_id', 'multiple', 'style'=>'width:100%;'])!!}
                            @error('country_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Status: <span class="tx-danger">*</span></label>
                            {!! Form::select("status",status(),null,['class' =>'form-control select2'.($errors->has('status') ? 'parsley-error' : null),
                                    'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status', 'placeholder'=>'Select', 'style'=>'width:100%;'])!!}
                            @error('status')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="form-label"> Preferred Influencer Gender: <span class="tx-danger">*</span></label>
                            {!! Form::select('preferred_gender',preferred_gender(),null,['class' =>'form-control select2 '.($errors->has('preferred_gender') ? 'parsley-error' : null),
                                    'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'preferred_gender','placeholder'=>'Select','style'=>'width:350px;'])!!}
                            @error('preferred_gender')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12" style="display:none;">
                        <div class="form-group">
                            <label class="form-label">Branches: </label>
                            {!! Form::select('branch_ids[]',[],null,['class' =>'form-control select2 '.($errors->has('branch_ids') ? 'parsley-error' : null),
                                    'data-show-subtext'=>'true','data-live-search'=>'true','multiple'=>'multiple','id' => 'subbrand_branch_ids','placeholder'=>'Select','style'=>'width:350px;'])!!}
                            @error('branch_ids')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="col-12 mt-5">
                        <h5 class="m-auto mt-2"><i class="fas fa-link"></i> Social Links</h5>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Phone: <span class="tx-danger">*</span></label>
                                    <div class="row">
                                        <div class="input-group">
                                            <div class="input-group-prepend col-4">
                                                <select class="input-group-text country_code select2" id="code_phone" name="code_phone" data-placeholder="Code" style="width:200px;">
                                                    <option></option>
                                                    @foreach($all_countries_data as $country)
                                                        <option value="{{$country->phonecode}}" data-flag="{{$country->code}}" > (+){{$country->phonecode}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control" name="phone" min="0" id="subbrand_phone" placeholder="Enter Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109" >

                                            </div>
                                        </div>
                                    </div>

                                    @error('phone')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                    @error('code_phone')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
{{--                            <div class="col-12 col-sm-12 main-toggle-group-demo">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="form-label">Whatsapp is Same as Phone: <span class="text-danger">*</span></label>--}}
{{--                                    <div class="switch_parent"  >--}}
{{--                                        <input type="checkbox" id="switch" class="switch_toggle togBtn" >--}}
{{--                                        <label class="switch" for="switch" title="inactive"></label>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-lg-6 col-md-6 col-sm-12" id="whatsappSection">
                                <div class="form-group">
                                    <label class="form-label">WhatsApp Phone Number: <span class="tx-danger">*</span></label>
                                    <div class="row">
                                        <div class="input-group">
                                            <div class="input-group-prepend col-4">
                                                <select class="input-group-text country_code select2" id="code_whats" name="code_whats" data-placeholder="Code" style="width:200px;">
                                                    <option></option>
                                                    @foreach($all_countries_data as $country)
                                                        <option value="{{$country->phonecode}}" data-flag="{{$country->code}}" > (+){{$country->phonecode}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-8">
                                                <input class="form-control" value="" min="0" name="whats_number" id="subbrand_whats_number" placeholder="Enter WhatsApp Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109" >

                                            </div>
                                        </div>
                                    </div>
                                    @error('whats_number')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                    @error('code_whats')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Instagram: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #bf1c6a;" class="fab fa-instagram"></i></span>
                                        </div>
                                        {!! Form::text('link_insta',null,['class' =>'form-control '.($errors->has('link_insta') ? 'parsley-error' : null),'placeholder'=> 'Enter Instagram Username','id'=>'subbrand_link_insta' ]) !!}
                                        @error('link_insta')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Facebook:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #0162e8;" class="fab fa-facebook"></i></span>
                                        </div>
                                        {!! Form::text('link_facebook',null,['class' =>'form-control '.($errors->has('link_facebook') ? 'parsley-error' : null),'placeholder'=> 'Enter Facebook Username','id'=>'subbrand_link_facebook' ]) !!}
                                        @error('link_facebook')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Tik Tok:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #000;" class="fas fa-icons"></i></span>
                                        </div>
                                        {!! Form::text('link_tiktok',null,['class' =>'form-control '.($errors->has('link_tiktok') ? 'parsley-error' : null),'placeholder'=> 'Enter Tik Tok Username','id'=>'subbrand_link_tiktok' ]) !!}
                                        @error('link_tiktok')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Snapchat:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #fffc00;" class="fab fa-snapchat"></i></span>
                                        </div>
                                        {!! Form::text('link_snapchat',null,['class' =>'form-control '.($errors->has('link_snapchat') ? 'parsley-error' : null),'placeholder'=> 'Enter Snapchat Username','id'=>'subbrand_link_snapchat' ]) !!}
                                        @error('link_snapchat')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Twitter:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: rgb(29, 155, 240);" class="fab fa-twitter"></i></span>
                                        </div>
                                        {!! Form::text('link_twitter',null,['class' =>'form-control '.($errors->has('link_twitter') ? 'parsley-error' : null),'placeholder'=> 'Enter Twitter Username','id'=>'subbrand_link_twitter' ]) !!}
                                        @error('link_twitter')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Website:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: rgb(29, 155, 240);" class="fas fa-globe-americas"></i></span>
                                        </div>
                                        {!! Form::text('link_website',null,['class' =>'form-control '.($errors->has('link_website') ? 'parsley-error' : null),'placeholder'=> 'Enter Website URL','id'=>'subbrand_link_website' ]) !!}
                                        @error('link_website')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                <button type="button" class="btn Active hvr-sweep-to-right" id="save_sub_brand"></button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#save_sub_brand').on('click',function () {
            $(this).prop('disabled',true);
            let formData = new FormData();
            let subbrand_id = $('#sub_brand').val()
            formData.append("id", subbrand_id);
            $('#sub-brand-form input,#sub-brand-form select').each((i,e)=>{
                if(e.getAttribute('name')!=null){
                    if(e.getAttribute('name')=='image'){
                        if( e.files[0])
                            formData.append("image", e.files[0]);
                    }else{
                        if(typeof  $(e).val() == 'object'){
                            for(let index in $(e).val()){
                                formData.append(e.getAttribute('name'),$(e).val()[index])
                            }
                        }else{
                            formData.append(e.getAttribute('name'),$(e).val())
                        }
                    }
                }
            });

            function country_flag(id){
            console.log(id);
             $.ajax({
                    url: '/dashboard/get-country-flag/'+id,
                    type:'GET',
                    headers:{
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                    },
                    success:(data)=>{
                        console.log('flag', data);
                    }
             });
        }

            let route_attr = $(this).attr('route')
            let route=''
            if(route_attr == 'add'){
                route = '/dashboard/sub-brands';
            } else{
                route = '/dashboard/sub-brands/'+subbrand_id;
                formData.append('_method','PUT')
            }
            $.ajax({
                    url: route,
                    type:'POST',
                    data:formData,
                    contentType: false,
                    processData: false,
                    headers:{
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                    },
                    success:(data)=>{
                        console.log(data);
                        for (let statictic in data.stats){
                            let elId = data.stats[statictic].id;
                            $(`#${elId}`).find('.counters').text(data.stats[statictic].count)
                        }
                        if(window.location.pathname.split("/")[2] == 'brands'){
                            subBrandTbl.ajax.reload();
                            $('#name').val('');
                            $('#subbrand_image').val('');
                            $('#subbrand_preferred_gender').val('').trigger('change');
                            $('#subbrand_country_id').val('').trigger('change');
                            $('#branch_ids').val('').trigger('change');
                            $('.country_code').val('').trigger('change');
                            $('#status').val('').trigger('change');
                            $('#subbrand_phone').val('');
                            $('#subbrand_whats_number').val('');
                            $('#subbrand_link_insta').val('');
                            $('#subbrand_link_facebook').val('');
                            $('#subbrand_link_tiktok').val('');
                            $('#subbrand_link_snapchat').val('');
                            $('#subbrand_link_twitter').val('');
                            $('#subbrand_link_website').val('');
                        }else if(window.location.pathname.split("/")[3] == 'groups'){
                            //console.log(data.data.name);
                            $('#group_name').text(data.data.name);
                            console.log(data.data.image);
                            $('#group_image').attr('src', data.data.image);
                            $('#group_preferred_gender').text(data.data.preferred_gender);
                            $('#subbrand_country_id').val('').trigger('change');
                            $('#group_country_code').text('');
                            $.each(data.data.countries, function(i, v){
                                if(v != null){
                                    $('#group_country_code').append(`<img style="display: inline-block;margin-bottom: 2px;" src="https://hatscripts.github.io/circle-flags/flags/${v}.svg" width="26" class="img-flag">`);
                                }
                            });
                            $('#group_status').text(data.data.status == 1 ? 'Active' : 'Inacative');
                            $('#group_phone').text(data.data.phone);
                            $('#group_whats_number').text(data.data.whats_number);
                            $('#group_link_insta').text(data.data.link_insta);
                            $('#group_link_facebook').text(data.data.link_facebook);
                            $('#group_link_tiktok').text(data.data.link_tiktok);
                            $('#group_link_snapchat').text(data.data.link_snapchat);
                            $('#group_link_website').text(data.data.link_website);
                        }
                        $('#sub_brand_modal').modal('hide');
                        Swal.fire("Success!", "Done Successfully!", "success");
                        $(this).prop('disabled',false);
                        selectCountry()
                    },
                    error:(error)=>{
                        $(this).prop('disabled',false);
                        if(error.responseJSON && error.responseJSON.hasOwnProperty('errors')){
                            let errors = error.responseJSON.errors
                            for(let key in errors) {
                                Swal.fire("Error", errors[key][0], "warning");
                                return;
                            }

                        }else{
                            Swal.fire("Error", "Something went wrong please reload page", "error");
                        }
                    }
                })
                select2Render()
        })

        function select2Render(){
            $(`#subbrand_preferred_gender,#status`).select2({
                placeholder: "Select",
                allowClear: true,
                maximumSelectionLength: 4,
            });
        }select2Render()



        @if(!empty(old('code_whats')) && old('code_whats')==old('code_phone') )
        $(".togBtn").addClass('on');
        let switchStatus = true
        hideShowWhatsappInput(switchStatus)
        @endif
        //Toggle
        var switchStatus = false;
        $('.main-toggle').on('click', function() {
            if($(this).attr('checked')){
                $(this).attr('checked',false);
            }else{
                $(this).attr('checked',true);
            }
        })

        $(".togBtn").on('click', function() {
            var switchStatus = false;
            if ($(this).is(":checked")){
                switchStatus = !switchStatus;
            }else{
                if(!($("#whatsappSection input").val() != ''))
                    switchStatus = !switchStatus;
            }
            hideShowWhatsappInput(switchStatus)
        });

        function hideShowWhatsappInput(switchStatus){
            if(switchStatus){
                $("#whatsappSection input").val($('input[name="phone"]').val())
                $('#whatsappSection select').val($('select[name="code_phone"]').val()).trigger('change');
                $("#whatsappSection").fadeOut(500)
            }else{
                $("#whatsappSection input").val(null)
                $('#whatsappSection select').val(null).trigger('change');
                $("#whatsappSection").fadeIn(500)
            }
        }
    </script>
@endpush
