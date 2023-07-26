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
    <div class="col-12">
        <div class="row">


            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ar">
                <div class="form-group mg-b-0">
                    <label class="form-label">Question (Ar): <span class="tx-danger">*</span></label>
                    {!! Form::text('question_ar',$faq->question_lang->ar??null,['class' =>'ar-inputs form-control '.($errors->has('question_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter Question']) !!}
                    @error('question_ar')
                        <ul class="parsley-errors-list filled" id="parsley-id-1">
                            <li class="parsley-required text-danger">
                                {{$message}}
                            </li>
                        </ul>
                    @enderror
                </div>
            </div>
           

            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en">
                <div class="form-group mg-b-0">
                    <label class="form-label">Question (En): <span class="tx-danger">*</span></label>
                    {!! Form::text('question_en',$faq->question_lang->en??null,['class' =>'en-inputs form-control '.($errors->has('question_en') ? 'parsley-error' : null),'placeholder'=> 'Enter Question']) !!}
                    @error('question_en')
                        <ul class="parsley-errors-list filled" id="parsley-id-1">
                            <li class="parsley-required text-danger">
                                {{$message}}
                            </li>
                        </ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ar">
                <div class="form-group mg-b-0">
                    <label class="form-label">Answer (Ar): <span class="tx-danger">*</span></label>
                    {!! Form::textarea('answer_ar',$faq->answer_lang->ar??null,['class' =>'ar-inputs form-control '.($errors->has('answer_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter Answer']) !!}
                    @error('answer_ar')
                        <ul class="parsley-errors-list filled" id="parsley-id-1">
                            <li class="parsley-required text-danger">
                                {{$message}}
                            </li>
                        </ul>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en">
                <div class="form-group mg-b-0">
                    <label class="form-label">Answer (En): <span class="tx-danger">*</span></label>
                    {!! Form::textarea('answer_en',$faq->answer_lang->en??null,['class' =>'en-inputs form-control '.($errors->has('answer_en') ? 'parsley-error' : null),'placeholder'=> 'Enter Answer']) !!}
                    @error('answer_en')
                        <ul class="parsley-errors-list filled" id="parsley-id-1">
                            <li class="parsley-required text-danger">
                                {{$message}}
                            </li>
                        </ul>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 text-right">
        <button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10 button_submit"  type="submit">
            <i class="far fa-save"></i> Save
        </button>
    </div>
</div>



