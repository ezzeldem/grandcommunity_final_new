<div class="row row-sm">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group mg-b-0">
            <label class="form-label">Name: <span class="text-danger">*</span></label>
            {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'name' ]) !!}
            @error('name')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Username: <span class="text-danger">*</span></label>
            {!! Form::text('username',null,['class' =>'form-control '.($errors->has('username') ? 'parsley-error' : null),'placeholder'=> 'Enter Username','id'=>'username' ]) !!}
            @error('username')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Email: <span class="text-danger">*</span></label>
            {!! Form::email('email',null,['class' =>'form-control '.($errors->has('email') ? 'parsley-error' : null),'placeholder'=> 'Enter Email','id'=>'email' ]) !!}
            @error('email')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Status: <span class="text-danger">*</span></label>
            {!! Form::select("active",status(),null,['class' =>'form-control '.($errors->has('active') ? 'parsley-error' : null),
                       'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'active','placeholder'=>'select status'])!!}
            @error('active')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Password: <span class="text-danger">*</span></label>
            {!! Form::password('password',['class'=>'form-control '.($errors->has('password') ? 'parsley-error' : null),'placeholder'=> 'Enter Password','id'=>'pwd' ]) !!}
            @error('password')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Password Confirmation: <span class="text-danger">*</span></label>
            {!! Form::password('password_confirmation',['class'=>'form-control '.($errors->has('password') ? 'parsley-error' : null),'placeholder'=> 'Re-enter Password','id'=>'confirm_pwd' ]) !!}
            @error('password_confirmation')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    @if (auth()->user()->roles[0]->type == 'admin'|| auth()->user()->roles[0]->name == 'operationManager' || auth()->user()->roles[0]->name == 'superCommunity')
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Role: <span class="text-danger">*</span></label>
            {!! Form::select("role_id",communityRoles(),null,['class' =>'form-control '.($errors->has('role_id') ? 'parsley-error' : null),
                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'role_id','placeholder'=>'select roles'])!!}
            @error('role_id')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
      @endif
{{--    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--        <div class="form-group">--}}
{{--            <label class="form-label">Type: <span class="text-danger">*</span></label>--}}
{{--            {!! Form::select("status_id",operationStatus(),null,['class' =>'form-control '.($errors->has('status_id') ? 'parsley-error' : null),--}}
{{--                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status_id','placeholder'=>'select status'])!!}--}}
{{--            @error('status_id')--}}
{{--            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="col-12">
        <div class="form-group mt-2">
            @isset($community)
                <img src="{{$community->image}}" alt="user" class="img-thumbnail img-choose" height="70" width="70">
            @endisset
                <label class="form-label">Image: <span class="text-danger">*</span></label>
                <div class="custom-file">
                    {!! Form::file('image',['class'=>'custom-file-input '.($errors->has('image') ? 'parsley-error' : null),'id'=>'image']) !!}
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            @error('image')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-12"> <button type="submit" class="btn btn-primary pd-x-20 mg-t-10"><i class="far fa-save"></i> Save</button></div>
</div>
