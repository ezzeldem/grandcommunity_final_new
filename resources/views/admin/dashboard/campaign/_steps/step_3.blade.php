    <div class="row setup-content" id="step-3">

{{--        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">--}}
{{--            <div class="form-group">--}}
{{--                <label class="form-label">Delivery Confirmation Link: <span class="text-danger">*</span></label>--}}
{{--                {!! Form::url('confirmation_delivery_link', null, [--}}
{{--                    'class' => 'form-control link-input' . ($errors->has('confirmation_delivery_link') ? 'parsley-error' : null),--}}
{{--                    'placeholder' => 'Enter confirmation delivery Link',--}}
{{--                    'id' => 'confirmation_delivery_link',--}}
{{--                ]) !!}--}}
{{--                @error('confirmation_delivery_link')--}}
{{--                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">--}}
{{--                    <li class="parsley-required">{{ $message }}</li>--}}
{{--                </ul>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
            <div class="form-group">
                <label class="form-label">Visit Coverage Link: <span class="text-danger">*</span></label>
                {!! Form::url('visit_coverage', null, [
                    'class' => 'form-control link-input ' . ($errors->has('visit_coverage') ? 'parsley-error' : null),
                    'placeholder' => 'Enter visit coverage Link',
                    'id' => 'visit_coverage',
                ]) !!}
                @error('visit_coverage')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>




        <div class="col-md-4 col-sm-12 mt-4" id="has_guest_container">
            <div class="form-group mg-b-0">
                <label class="form-label"> Guests Are Allowed: <span class="text-danger">*</span></label>
                {!! Form::select('has_guest', has_guests(), null, [
                    'class' => 'form-control select2 ' . ($errors->has('has_guest') ? 'parsley-error' : null),
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'has_guest',
                    'placeholder' => 'Select',
                ]) !!}
                @error('has_guest')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 mt-4 " id="guest_numbers_container">
            <div class="form-group mg-b-0  guest_num" @if(isset($campaign) && (int) $campaign->has_guest < 1) style="display: none" @endif id="guest_numbers_dev">
                <label class="form-label">Guests Number: <span class="text-danger">*</span></label>
                {!! Form::number('guest_numbers', null, [
                    'class' => 'form-control ' . ($errors->has('guest_numbers') ? 'parsley-error' : null),
                    'placeholder' => 'Enter Total Number Of Guests',
                    'id' => 'guest_numbers',
                    'min' => '0',
                ]) !!}
                @error('guest_numbers')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>


        <div class="col-md-6 mt-4">
            <div class="form-group mg-b-0 lablabla">
                <label class="form-label">Notes: </label>

                {!! Form::textarea('note',null , [
                    'class' => 'form-control ' . ($errors->has('note') ? 'parsley-error' : null),
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Notes ',
                    'id' => 'campaign_note',
                    'rows' => 2,
                    'id' => 'note',
                ]) !!}
                @error('note')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>


        <div class="col-md-6 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Brief: <span class="text-danger">*</span></label>
                {!! Form::textarea('brief', null, [
                    'class' => 'form-control' . ($errors->has('brief') ? 'parsley-error' : null),
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter Brief ',
                    'id' => 'brief',
                    'rows' => 2,
                ]) !!}
                @error('brief')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Invitation: </label>
                {!! Form::textarea('invitation', null, [
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'placeholder' => 'Enter invitation',
                    'id' => 'invitation',
                    'rows' => 2,
                ]) !!}
                @error('invitation')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <button type="button" class="btn btn-primary previous-btn-step btn-lg pull-right" data-step="3">Previous</button>
            <button type="button" class="btn btn-primary next-btn-step btn-lg pull-right" data-step="3">Next</button>
        </div>
    </div>

