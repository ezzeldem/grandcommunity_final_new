<div class="row row-sm create_form subbrand_form">
    <div class="col-12">
        <h5><i class="fas fa-link"></i> Brand</h5>
        <div class="row">

            <div class="col-12">
                <div class="profile-avatar mb-5">
                    <ul>
                        <li> <img src="{{ old('image') ? asset('storage/' . old('image')) : ( isset($subBrand) && !empty($subBrand->image) ? $subBrand->image : '/assets/img/avatar_logo.png') }}" id="imgLogo" alt=""> </li>
                        <li class="edit">
                            <i class="far fa-edit"></i>
                            <input type="file" name="image" id="inputFile" value="{{ old('fileReader') }}" class="@if ($errors->has('image')) parsley-error @endif" accept="image/x-png,image/gif,image/jpeg">
                        </li>
                        {{-- @error('image')
                            <span class="error-msg-input">{{ $message }}</span>
                        @enderror --}}
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="form-group mg-b-0">
                    <label class="form-label">Brand Name: <span class="tx-danger">*</span></label>
                    {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'name' ]) !!}
                    {{-- @error('name')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror --}}
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Company: <span class="tx-danger">*</span></label>
                    <input type="hidden" value="{{isset($subBrand)?$subBrand->brand_id:null}}" name="brand_id">
                    {!! Form::select("brand_id",brands(),null,['class' =>'form-control select2 '.($errors->has('brand_id') ? 'parsley-error' : null),
                                       'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'brand_id','placeholder'=>'Select Company', "disabled" => (isset($subBrand) && $subBrand)])!!}
                    {{-- @error('brand_id')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror --}}
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Countries: <span class="tx-danger">*</span></label>
                    {!! Form::select("country_id[]",((isset($subBrand) && $subBrand->brand)?getBrandCountries($subBrand->brand,true):countries()),null,['class' =>'form-control select2 '.($errors->has('country_id') ? 'parsley-error' : null),
                                      'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'country_id','multiple'])!!}
                    {{-- @error('country_id')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror --}}
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Preferred Gender: <span class="tx-danger">*</span></label>
                    {!! Form::select('preferred_gender',preferred_gender(),null,['class' =>'form-control '.($errors->has('preferred_gender') ? 'parsley-error' : null),
                                    'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'preferred_gender','placeholder'=>'Select Preferred Gender'])!!}
                    {{-- @error('preferred_gender')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror --}}
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Status: <span class="tx-danger">*</span></label>
                    {!! Form::select("status",status(),null,['class' =>'form-control '.($errors->has('subbrand_status') ? 'parsley-error' : null),
                            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status','placeholder'=>'Select Status'])!!}
                    {{-- @error('status')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    @isset($subbrand)
                        <img src="{{$subbrand->image}}" alt="user" class="img-thumbnail" height="70" width="70">
                    @endisset
                    <label class="form-label">Image: </label>
                    {!! Form::file('image',['class'=>'form-control  '.($errors->has('image') ? 'parsley-error' : null),'id'=>'image'])  !!}
                    {{-- @error('image')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror --}}
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <h5><i class="fas fa-link"></i> Social Links</h5>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Phone: <span class="tx-danger">*</span></label>
                    <div class="row">
                        <div class="input-group">
                            <div class="input-group-prepend col-4">
                                <select class="input-group-text country_code" id="code_phone" name="code_phone" data-placeholder="Code" style="width:200px;">
                                    <option></option>
                                    @foreach($all_countries_data as $country)
                                        <option value="{{$country->phonecode}}" data-flag="{{$country->code}}"  @if(isset($subBrand) && $subBrand && $subBrand->code_phone == $country->phonecode) selected @endif> (+){{$country->phonecode}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-8">
                                <input class="form-control" value="{{$subBrand->phone??null}}" name="phone" min="0" id="subbrand_phone" placeholder="Enter Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109" >

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
                                <select class="input-group-text country_code" id="code_whats" name="code_whats" data-placeholder="Code" style="width:200px;">
                                    <option></option>
                                    @foreach($all_countries_data as $country)
                                        <option value="{{$country->phonecode}}" data-flag="{{$country->code}}" @if(isset($subBrand) && $subBrand && $subBrand->code_whats == $country->phonecode) selected @endif> (+){{$country->phonecode}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-8">
                                <input class="form-control" value="{{$subBrand->whats_number??null}}" min="0" name="whats_number" id="subbrand_whats_number" placeholder="Enter WhatsApp Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109" >

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

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Instagram: <span class="tx-danger">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i  class="fab fa-instagram"></i></span>
                        </div>
                        {!! Form::text('link_insta',null,['class' =>'form-control '.($errors->has('link_insta') ? 'parsley-error' : null),'placeholder'=> 'Enter Instagram Username','id'=>'link_insta' ]) !!}
                        {{-- @error('link_insta')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Facebook: </label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i  class="fab fa-facebook"></i></span>
                        </div>
                        {!! Form::text('link_facebook',null,['class' =>'form-control '.($errors->has('link_facebook') ? 'parsley-error' : null),'placeholder'=> 'Enter Facebook Username','id'=>'link_facebook' ]) !!}
                        {{-- @error('link_facebook')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Tik Tok: </label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-icons"></i></span>
                        </div>
                        {!! Form::text('link_tiktok',null,['class' =>'form-control '.($errors->has('link_tiktok') ? 'parsley-error' : null),'placeholder'=> 'Enter Tik Tok Username','id'=>'link_tiktok' ]) !!}
                        {{-- @error('link_tiktok')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Snapchat: </label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-snapchat"></i></span>
                        </div>
                        {!! Form::text('link_snapchat',null,['class' =>'form-control '.($errors->has('link_snapchat') ? 'parsley-error' : null),'placeholder'=> 'Enter Snapchat Username','id'=>'link_snapchat' ]) !!}
                        {{-- @error('link_snapchat')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Twitter: </label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-twitter"></i></span>
                        </div>
                        {!! Form::text('link_twitter',null,['class' =>'form-control '.($errors->has('link_twitter') ? 'parsley-error' : null),'placeholder'=> 'Enter Twitter Username','id'=>'link_twitter' ]) !!}
                        {{-- @error('link_twitter')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Website: </label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i style="color: rgb(29, 155, 240);" class="fas fa-globe-americas"></i></span>
                        </div>
                        {!! Form::text('link_website',null,['class' =>'form-control '.($errors->has('link_website') ? 'parsley-error' : null),'placeholder'=> 'Enter Website Url','id'=>'link_website' ]) !!}
                        {{-- @error('link_website')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror --}}
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <input class="form-control" value="{{old('branches')}}" name="branches" id="branches" type="hidden">
                    @error('branches')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div> -->
        </div>

    </div>

    <!-- <div class="col-12 mt-4">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#branchModal">
            Add New Branch
        </button>
        <div class="clearfix"></div>
        <hr>
      @include('admin.dashboard.sub-brands.branches_tbl')
    </div> -->

    <div class="col-12">
        <div class="save text-left">
            <button class="btn btn-main-primary pd-x-20 mg-t-10 float-right save_sub_brand" type="submit">
                <i class="far fa-save"></i> Save
            </button>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('js/curd.js') }}"></script>
    <script>
        $(function (){
            function format(item, state) {
                if (!item.id) {
                    return item.text;
                }
                var flag= item.element.attributes[1];
                var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
                var url = state ? stateUrl : countryUrl;
                var img = $("<img>", {
                    class: "img-flag-all",
                    width: 18,
                    src: url + flag.value.toLowerCase() + ".svg"
                });
                var span = $("<span>", {
                    text: " " + item.text
                });
                span.prepend(img);
                return span;
            }
            function formatState (state) {
                if (!state.id) {
                    return state.text;
                }
                var flag= state.element.attributes[1].value;
                var baseUrl = "https://hatscripts.github.io/circle-flags/flags/";
                var $state = $(
                    '<span><img class="img-flag" width="22"/> <span></span></span>'
                );
                $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase() + ".svg");
                return $state;
            };

            function selectCountry(){
                $('.country_code_2').select2({
                    placeholder: "🌍 Global",
                    allowClear: true,
                    templateResult: function(item) {
                        return format(item, false);
                    },
                    templateSelection:function(state) {
                        return formatState(state, false);
                    },
                });
            }

            selectCountry();
        });
        $(function (){
            let countriesInSubBranches = "{{json_encode($countriesInSubBranches)}}";
            $('#country_id').select2({
                tags: true
            }).on("select2:unselecting", function (e) {
                // check if originalEvent.currentTarget.className is "select2-results__option" (in other words if it was raised by a item in the dropdown)
                if (countriesInSubBranches.includes(e.params.args.data.id)){
                    e.preventDefault();
                    alert("You cannot remove this country because it's related to branches")
                }
            });
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    //alert(e.target.result);
                    $('#imgLogo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function() {
            $("#inputFile").change(function() {
                readURL(this);
            });
        });

        $(document).ready(function () {
            // $(".select2").select2();
            // $('.save_sub_brand').click(function (event) {
            //     var branches = [];
            //     $('.branch').each(function () {
            //         var branch = {
            //             'name': $(this).find('.branch_name').val(),
            //             'address': $(this).find('.branch_address').val(),
            //             'phone': $(this).find('.branch_phone').val(),
            //             'email': $(this).find('.branch_email').val(),
            //             'lat': $(this).find('.branch_lat').val(),
            //             'lng': $(this).find('.branch_lng').val(),
            //         };
            //         branches.push(branch);
            //     });
            //     // $('#branches').val(JSON.stringify(branches));
            //     $('#branches').val(window.localStorage?.branches);
            // });
        });
    </script>
@endpush
