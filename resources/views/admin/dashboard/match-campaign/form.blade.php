 <div class="row row-sm">
    <ul class="nav justify-content-center nav-pills">
         <li class="nav-item">
             <span class="nav-link lang active" data-value="ar">ar</span>
         </li>
         <li class="nav-item">
             <span class="nav-link lang" data-value="en">en</span>
         </li>
         <input type="hidden" name="lang">
     </ul>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ar">
                <div class="form-group mg-b-0">
                    <label class="form-label">ar name: <span class="tx-danger">*</span></label>
                    {!! Form::text('name_ar',null,['class' =>'ar-inputs form-control '.($errors->has('name_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter ar name']) !!}
                    @error('name_ar')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en">
                <div class="form-group mg-b-0">
                    <label class="form-label">en name: <span class="tx-danger">*</span></label>
                    {!! Form::text('name_en',null,['class' =>'en-inputs form-control '.($errors->has('name_en') ? 'parsley-error' : null),'placeholder'=> 'Enter en name']) !!}
                    @error('name_en')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 text-right">
        <button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10" type="submit">
            <i class="far fa-save"></i> Save
        </button>
    </div>
</div>



