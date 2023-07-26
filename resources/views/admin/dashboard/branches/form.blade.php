<div class="row row-sm">
    <div class="col-12">
        <h5><i class="fas fa-link"></i> Branch </h5>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group mg-b-0">
                    <label class="form-label">Name: <span class="tx-danger">*</span></label>
                    {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'name' ]) !!}
                    @error('name')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Sub Brand: <span class="tx-danger">*</span></label>
                    {!! Form::select("subbrand_id",subBrands(),null,['class' =>'form-control select2 '.($errors->has('brand_id') ? 'parsley-error' : null),
                                       'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'subbrand_id','placeholder'=>'select sub brand'])!!}
                    @error('subbrand_id')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group mg-b-0">
                    <label class="form-label">City: <span class="tx-danger">*</span></label>
                    {!! Form::text('city',null,['class' =>'form-control '.($errors->has('city') ? 'parsley-error' : null),'placeholder'=> 'Enter City','id'=>'city' ]) !!}
                    @error('city')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group mg-b-0">
                    <label class="form-label">Country: <span class="tx-danger">*</span></label>
                    {!! Form::select("country_id",countries(),null,['class' =>'form-control select2'.($errors->has('country_id') ? 'parsley-error' : null),
                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'country_id','placeholder'=>'select country'])!!}
                    @error('country_id')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="form-label">Status: <span class="tx-danger">*</span></label>
                    {!! Form::select("status",status(),null,['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status','placeholder'=>'select status'])!!}
                    @error('status')
                    <ul class="parsley-errors-list filled" id="parsley-id-11">
                        <li class="parsley-required">{{$message}}</li>
                    </ul>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 text-right">
        <button style="width: 150px;" class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">
            <i class="far fa-save"></i> Save
        </button>
    </div>
</div>
