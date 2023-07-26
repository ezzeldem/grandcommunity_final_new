<div class="row row-sm">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group mg-b-0">
            <label class="form-label">Name: <span class="text-danger">*</span></label>
            {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'office_name' ]) !!}
            @error('name')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <label class="form-label">Country: <span class="text-danger">*</span></label>
            {!! Form::select("country_id",$countries,null,['class' =>'form-control '.($errors->has('country_id') ? 'parsley-error' : null),
            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'office_country','placeholder'=>'select country'])!!}
            @error('country_id')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <label class="form-label">Status: <span class="text-danger">*</span></label>
            {!! Form::select("status",[ '0' => 'Inactive', '1' => 'Active' ],null,['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'office_status','placeholder'=>'select status'])!!}
            @error('status')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn Active hvr-sweep-to-right pd-x-20 mg-t-10"><i class="far fa-save"></i> Save</button>
        <button type="submit" class="btn Delete hvr-sweep-to-right pd-x-20 mg-t-10" data-dismiss="modal" aria-label="Close">
            <i class="far fa-x"></i>Close
        </button>
    </div>
</div>
