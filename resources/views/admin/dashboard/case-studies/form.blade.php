 <div class="row row-sm create_form case_form">
     <div class="col-12">
         <div class="row">
             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Total Followers: <span class="tx-danger">*</span></label>
                     {!! Form::number('total_followers',isset($case) ? $case->total_followers : old('total_followers'),['class' =>'form-control '.($errors->has('total_followers') ? 'parsley-error' : null),'placeholder'=> 'Enter Total Followers']) !!}
                     @error('total_followers')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Total Influencers: <span class="tx-danger">*</span></label>
                     {!! Form::number('total_influencers',isset($case) ? $case->total_influencers : old('total_influencers'),['class' =>'form-control '.($errors->has('total_influencers') ? 'parsley-error' : null),'placeholder'=> 'Enter Total Influencers']) !!}
                     @error('total_influencers')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Total Reels: <span class="tx-danger">*</span></label>
                     {!! Form::number('total_reals',isset($case) ? $case->total_reals : old('total_reals'),['class' =>'form-control '.($errors->has('total_reals') ? 'parsley-error' : null),'placeholder'=> 'Enter Total Reels']) !!}
                     @error('total_reals')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Total Days: <span class="tx-danger">*</span></label>
                     {!! Form::number('total_days',isset($case) ? $case->total_days : old('total_days'),['class' =>'form-control '.($errors->has('total_days') ? 'parsley-error' : null),'placeholder'=> 'Enter Total Days']) !!}
                     @error('total_days')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Client Profile Link: <span class="tx-danger">*</span></label>
                     {!! Form::text('client_profile_link',isset($case) ? $case->client_profile_link : old('client_profile_link'),['placeholder'=>'Enter Client Profile Link', 'class' =>'form-control profile_link '.($errors->has('client_profile_link') ? 'parsley-error' : null)]) !!}
                     @error('client_profile_link')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Campaign Type: <!-- <span class="tx-danger">*</span>--></label>
                     {!! Form::select("campaign_type",campaignType(),null,['class' =>'form-control select2'.($errors->has('campaign_type') ? 'parsley-error' : null),
                                'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'campaign_type','placeholder'=>'Select Campaign Type'])!!}
                     @error('campaign_type')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Campaign Name: <span class="tx-danger">*</span></label>
                     {!! Form::select("campaign_name",[],null,['class' =>'form-control select2 campName'.($errors->has('campaign_name') ? 'parsley-error' : null),
                     'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'campaign_name','placeholder'=>'Select'])!!}
                     @error('campaign_name')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>


             <div class="col-xl-4 col-lg-4  col-md-4 col-xs-12 mt-3">
                 <div class="form-group">
                     <label class="form-label">Category: <span class="tx-danger">*</span></label>
                     <select class="form-control en-inputs select2 @if($errors->has('category'))  parsley-error @endif" id="category" name="category" data-placeholder="Choose one or more" >
                         <option disabled selected> Select</option>
                         @if(isset($case))
                             @foreach($caseCategories as $cat_item)
                                 <option value="{{$cat_item->id}}" {{old('category')==$cat_item->id? "selected":""}} @if($cat_item->id ==(integer)$case->category_id ) selected @endif>{{$cat_item->name}}</option>
                             @endforeach
                         @else
                             @foreach($caseCategories as $cat_item)

                                 <option value="{{$cat_item->id}}" {{old('category')==$cat_item->id? "selected":""}}>{{$cat_item->name}}</option>
                             @endforeach
                         @endif
                     </select>
                     @error('category')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Platforms: <span class="tx-danger">*</span></label>
                     <div style="display: flex;justify-content: space-around;">
{{--                         @dd($case->channels)--}}
                         <div class="custom-control custom-checkbox">
                             <input type="checkbox" name="channel_data[]" {{isset($case) ? (str_contains($case->channels, '1') ? "checked" : "") : ''}} value="1" class="custom-control-input channelsData" id="customCheck1">
                             <label class="custom-control-label" for="customCheck1">Instagram</label>
                         </div>

                         <div class="custom-control custom-checkbox">
                             <input type="checkbox" name="channel_data[]" {{isset($case) ? (str_contains($case->channels, '2') ? "checked" : "") : ''}} value="2" class="custom-control-input channelsData" id="customCheck2">
                             <label class="custom-control-label" for="customCheck2">Facebook</label>
                         </div>

                         <div class="custom-control custom-checkbox">
                             <input type="checkbox" name="channel_data[]" {{isset($case) ? (str_contains($case->channels, '3') ? "checked" : "") : ''}} value="3" class="custom-control-input channelsData" id="customCheck3">
                             <label class="custom-control-label" for="customCheck3">Twitter</label>
                         </div>

                         <div class="custom-control custom-checkbox">
                             <input type="checkbox" name="channel_data[]" {{isset($case) ? (str_contains($case->channels, '4') ? "checked" : "") : ''}} value="4" class="custom-control-input channelsData" id="customCheck4">
                             <label class="custom-control-label" for="customCheck4">Snapchat</label>
                         </div>

                         <div class="custom-control custom-checkbox">
                             <input type="checkbox" name="channel_data[]" {{isset($case) ? (str_contains($case->channels, '5') ? "checked" : "") : ''}} value="5" class="custom-control-input channelsData" id="customCheck5">
                             <label class="custom-control-label" for="customCheck5">TikTok</label>
                         </div>
                     </div>
                     @error('channel_data')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Reel Description (Ar): <span class="tx-danger">*</span></label>
                     {!! Form::text('real_ar',isset($case) ? json_decode($case->real,true)['ar']: old('real_ar'),['class' =>'form-control '.($errors->has('real_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter Reel Description']) !!}
                     @error('real_ar')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Reel Description (En): <span class="tx-danger">*</span></label>
                     {!! Form::text('real_en',isset($case) ? json_decode($case->real,true)['en']: old('real_en'),['class' =>'form-control '.($errors->has('real_en') ? 'parsley-error' : null),'placeholder'=> 'Enter Reel Description']) !!}
                     @error('real_en')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

             <div class="col-12">
                 <div class="form-group mg-b-0">
                     <label class="form-label">Image: <span class="tx-danger">*</span></label>
                     <input type="file" id="image" name="image[]" multiple="multiple">
                     <div class="imagesShow" style="display: flex;gap: 3px;"></div>
                     @error('image')
                     <ul class="parsley-errors-list filled" id="parsley-id-11">
                         <li class="parsley-required">{{$message}}</li>
                     </ul>
                     @enderror
                 </div>
             </div>

{{--             @if(isset($case))--}}
{{--             <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ar">--}}
{{--                 <div class="form-group mg-b-0">--}}
{{--                     <label class="form-label">description ar: <span class="tx-danger">*</span></label>--}}
{{--                     {!! Form::text('description_ar',$case->getTranslation('description', 'ar'),['class' =>' form-control '.($errors->has('description_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter ar description ']) !!}--}}
{{--                     @error('description_ar')--}}
{{--                     <ul class="parsley-errors-list filled" id="parsley-id-11">--}}
{{--                         <li class="parsley-required">{{$message}}</li>--}}
{{--                     </ul>--}}
{{--                     @enderror--}}
{{--                 </div>--}}
{{--             </div>--}}
{{--             @endif--}}

{{--                 @if(isset($case))--}}
{{--                 <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en">--}}
{{--                      <input type="file" id="avatar" value="{{$case->image}}" name="image" accept="image/png, image/jpeg">--}}
{{--                </div>--}}
{{--                @endif--}}
{{--                @if(!isset($case))--}}
{{--                 <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en">--}}
{{--                      <input type="file" id="avatar" value="" name="image" accept="image/png, image/jpeg">--}}
{{--                </div>--}}
{{--                @endif--}}
{{--                 <div class="divforrpeat mr-0 ml-0">--}}
{{--                 </div>--}}
{{--             </div>--}}


         </div>
     </div>


     <div class="col-12 text-right save">
         <button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10" type="submit">
             <i class="far fa-save"></i> Save
         </button>
         <input type="hidden" id="checkIfEdit" value="{{isset($case) ? '1' : '2' }}" >
         <input type="hidden" id="campaign_id" value="{{isset($case) ? $case->campaign_id : null }}" >
     </div>
 </div>
