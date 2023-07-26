<script>
    $(document).ready(function() {
        var i = 0;
        $(document).on('click', '.repeatter', function(e) {
            i = i + 1
            e.preventDefault();
            $(`.divforrpeat`).append(`
            <div class="form-group mg-b-0 appened_post_link_${i}">
                    <label class="form-label">Post Link: <span class="tx-danger">*</span></label>
                    {!! Form::text('post_link[]',null,['class' =>'en-inputs form-control poslink'.($errors->has('post_link') ? 'parsley-error' : null),'placeholder'=> 'Enter  Post Link','data-id'=>'${i}']) !!}
                    <button data-id="${i}" class="btn  deletPost">  <i class="far fa-trash-alt text-danger" style="font-size:16px;"></i></button>
                    @error('post_link')
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror </div>
            `)
        });


        var i = parseInt('{{ isset($case) ? (int)$case->count()  : 0 }}');
        $('.addAnswer').on('click', function(e) {
            e.preventDefault();
            i = i + 1;
            var lang = $('input[name="lang"]').val();
            $('.repeatanswer').append(`
        <div class="row deleteAnswer_${i}">
                <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ar" style="${lang == 'en' ? 'display:none' : 'display:block'}">
                    <div class="form-group mg-b-0">
                        <label class="form-label">AR question: <span class="tx-danger">*</span></label>
                        {!! Form::text('question[${i}][0]',null,['class' =>'ar-inputs form-control '.($errors->has('question_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter ar question']) !!}
                        @error('question_ar')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mt-3 ar" style="${lang == 'en' ? 'display:none' : 'display:block'}">
                    <div class="form-group mg-b-0">
                        <label class="form-label">AR answer: <span class="tx-danger">*</span></label>
                        {!! Form::textarea('answer[${i}][0]',null,['class' =>'ar-inputs form-control '.($errors->has('answer_ar') ? 'parsley-error' : null),'placeholder'=> 'Enter ar answer']) !!}
                        @error('answer_ar')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror
                    </div>
                </div>


                <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en" style="${lang == 'ar' ? 'display:none' : 'display:block'}">
                    <div class="form-group mg-b-0">
                        <label class="form-label">En question: <span class="tx-danger">*</span></label>
                        {!! Form::text('question[${i}][1]',null,['class' =>'en-inputs form-control '.($errors->has('question_en') ? 'parsley-error' : null),'placeholder'=> 'Enter en question']) !!}
                        @error('question_en')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mt-3 en" style="${lang == 'ar' ? 'display:none' : 'display:block'}"
                    <div class="form-group mg-b-0">
                        <label class="form-label">En answer: <span class="tx-danger">*</span></label>
                        {!! Form::textarea('answer[${i}][1]',null,['class' =>'en-inputs form-control '.($errors->has('answer_en') ? 'parsley-error' : null),'placeholder'=> 'Enter en answer']) !!}
                        @error('answer_en')
                        <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                        @enderror
                    </div>
                    <div class="col-12 mb-2">
                        <button class="btn deleteAnswer"  data-id="${i}"> <i class="far fa-trash-alt text-danger" style="font-size:16px;"></i></button>
                    </div>
                </div>

        </div>



        `);

        });


        $(document).on('click', '.deletPost', function(e) {
            e.preventDefault();
            var thisid = $(this).attr("data-id");
            ele = $('.appened_post_link_' + thisid).remove();

        })

        $(document).on('click', '.deleteAnswer', function(e) {
            e.preventDefault();
            var thisid = $(this).attr("data-id");
            ele = $('.deleteAnswer_' + thisid).remove();

        })


    });
</script>
