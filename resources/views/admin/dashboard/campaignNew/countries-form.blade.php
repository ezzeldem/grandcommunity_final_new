{{--@foreach($states as $key=>$state)--}}
{{--<div class="col-6 mt-3">--}}
{{--    <div class="form-group mg-b-0">--}}
{{--        <label class="form-label">{{$key}} States : <span class="tx-danger">*</span></label>--}}
{{--        <select class="form-control select2  @if($errors->has('state_id')) @endif "--}}
{{--                id="state_id_{{$key}}" data-id-suffix="{{$key}}" name="state_id[{{$key}}]">--}}
{{--            <option value="" disabled selected>select state ...</option>--}}
{{--            @foreach($state as $index=>$single)--}}
{{--                <option value="{{$single->id}}">--}}
{{--                    {{$single->name}}--}}
{{--                </option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        @error('state_id')--}}
{{--        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>--}}
{{--        @enderror--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="col-6 mt-3" style="display:none;">--}}
{{--    <div class="form-group mg-b-0">--}}
{{--        <label class="form-label">{{$key}} City : <span class="tx-danger">*</span></label>--}}
{{--        <select class="form-control select2  @if($errors->has('city_id')) @endif " id="city_id_{{$key}}" data-id-suffix="{{$key}}" name="city_id[{{$key}}][]" multiple style="width: 100%;">--}}

{{--        </select>--}}
{{--        @error('city_id')--}}
{{--        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>--}}
{{--        @enderror--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endforeach--}}
@foreach($groups as $key=>$group)
{{--    @dd($key,$group)--}}
    @php
        $country = \App\Models\Country::where('id',$key)->first()
    @endphp
<div class="col-6 mt-3">
    <div class="form-group mg-b-0">
        <label class="form-label">{{$country->name}} Favourite List : <span class="tx-danger">*</span></label>
        <select class="form-control select2  @if($errors->has('list_id')) @endif "
                id="list_ids_{{$key}}" data-id-suffix="{{$key}}" name="list_ids[{{$country->name}}]">
            <option value="" disabled selected>select item ...</option>
            @foreach($group as $i => $single_group)
            
                @if(!is_null($camp_id))
                    @php
                        $select_id = \App\Models\CampaignCountryFavourite::where('campaign_id',$camp_id)->where('country_id',$country->id)->first()->list_id;
                    @endphp
                    <option value="{{$single_group->id}}" {{ $single_group->id == $select_id ? 'selected' : ''}}>
                    {{$single_group->name}}
                </option>
                @else
                    <option value="{{$single_group->id}}">
                        {{$single_group->name}}
                    </option>
                @endif
                
            @endforeach
        </select>
        @error('list_id')
            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
        @enderror
    </div>
</div>
@endforeach
