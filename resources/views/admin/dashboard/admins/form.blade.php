<div class="row row-sm create_form">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group mg-b-0">
            <label class="form-label">Name: <span class="text-danger">*</span></label>
            {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'name' ]) !!}
            @error('name')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Username: <span class="text-danger">*</span></label>
            {!! Form::text('username',null,['class' =>'form-control '.($errors->has('username') ? 'parsley-error' : null),'placeholder'=> 'Enter Username','id'=>'username' ]) !!}
            @error('username')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Email: <span class="text-danger">*</span></label>
            {!! Form::email('email',null,['class' =>'form-control '.($errors->has('email') ? 'parsley-error' : null),'placeholder'=> 'Enter Email','id'=>'email' ]) !!}
            @error('email')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Status: <span class="text-danger">*</span></label>
            {!! Form::select("active",array('1' => 'active', '0' => 'inactive'),null,['class' =>'form-control select2'.($errors->has('active') ? 'parsley-error' : null),
            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'active','placeholder'=>'Select'])!!}
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
            <i class="fas fa-eye"></i>
            {!! Form::password('password',['class'=>'form-control '.($errors->has('password') ? 'parsley-error' : null),'placeholder'=> 'Enter Password','id'=>'pwd' ]) !!}
            @error('password')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Password Confirmation <span class="text-danger">*</span></label>
            <i class="fas fa-eye"></i>
            {!! Form::password('password_confirmation',['class'=>'form-control '.($errors->has('password') ? 'parsley-error' : null),'placeholder'=> 'Re-enter Password','id'=>'confirm_pwd' ]) !!}
            @error('password_confirmation')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Role: <span class="text-danger">*</span></label>
            {!! Form::select("role_id",adminRoles(),null,['class' =>'form-control select2 '.($errors->has('role_id') ? 'parsley-error' : null),
            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'role_id','placeholder'=>'Select'])!!}
            @error('role_id')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{$message}}</li>
                </ul>
            @enderror
        </div>
    </div>

    <!-- <div class="col-12">
        <div class="form-group mt-2" style="display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: column;">
            @isset($admin)
                <img src="{{$admin->image}}" alt="user" class="img-thumbnail img-choose" height="70" width="70">
            @endisset
            <label class="form-label">Image: <span class="text-danger">*</span></label>
            {{-- <div class="custom-file">--}}
            {{-- <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">--}}
            {{-- <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
            {{-- </div>--}}
            {!! Form::file('image') !!}
            @error('image')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{$message}}</li>
            </ul>
            @enderror
        </div>
    </div> -->
    <div class="col-12">
        <div class="profile-avatar my-5" style="justify-content: flex-start; align-items: flex-start;">
            <ul>
                @isset($admin)
                    <img src="{{$admin->image}}" alt="user" class="img-thumbnail img-choose" height="70" width="70">
                @endisset
                <li class="edit">
                    <label class="form-label d-block">Image: <span class="text-danger">*</span></label>
                    <button class="btn"> Upload Photo <i class="fas fa-upload"></i> </button>
                    {!! Form::file('image') !!}
                    @error('image')
                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{$message}}</li>
                        </ul>
                    @enderror
                </li>
            </ul>
        </div>
    </div>
    <div class="col-12 save"> <button type="submit" class="btn  pd-x-20 mg-t-10"><i class="far fa-save"></i> Save</button></div>
</div>
