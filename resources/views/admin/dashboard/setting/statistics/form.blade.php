 <div class="row row-sm">
     <ul class="nav justify-content-center nav-pills">
         <li class="nav-item">
             <span class="nav-link lang active" data-value="ar">Ar</span>
         </li>
         <li class="nav-item">
             <span class="nav-link lang" data-value="en">En</span>
         </li>
         <input type="hidden" name="lang">
     </ul>
    <div class="col-12 create_form">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mt-3 ar">
                <div class="form-group mg-b-0">
                    <label class="form-label">Title: <span class="tx-danger">*</span></label>
                    {!! Form::text('ar_title',null,['class' =>'ar-inputs form-control '.($errors->has('ar_title') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                    @error('ar_title')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 mt-3 en">
                <div class="form-group mg-b-0">
                    <label class="form-label">Title: <span class="tx-danger">*</span></label>
                    {!! Form::text('en_title',null,['class' =>'en-inputs form-control '.($errors->has('en_title') ? 'parsley-error' : null),'placeholder'=> 'Enter Title']) !!}
                    @error('en_title')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                <div class="form-group mg-b-0">
                    <label class="form-label">Count: <span class="tx-danger">*</span></label>
                    {!! Form::text('count',null,['class' =>'form-control '.($errors->has('count') ? 'parsley-error' : null),'placeholder'=> 'Enter Count']) !!}
                    @error('count')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 mt-3 en">
                <div class="form-group mg-b-0">
                    <label class="form-label">Description: <span class="tx-danger">*</span></label>
                    {!! Form::textarea('en_body',null,['class' =>'en-inputs form-control summernote '.($errors->has('en_body') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                    @error('en_body')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 mt-3 ar">
                <div class="form-group mg-b-0">
                    <label class="form-label">Description: <span class="tx-danger">*</span></label>
                    {!! Form::textarea('ar_body',null,['class' =>'ar-inputs form-control summernote '.($errors->has('ar_body') ? 'parsley-error' : null),'placeholder'=> 'Enter Description']) !!}
                    @error('ar_body')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                <div class="form-group mg-b-0" style= "width: 100%;" >
                    <label class="form-label">Image: <span class="tx-danger">*</span></label>
                    <input type="file" class="dropify" data-height="200" name="image" data-default-file="{{ (isset($statistic))? asset($statistic->image):'' }}"  />
                    @error('image')
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




<script>

</script>
