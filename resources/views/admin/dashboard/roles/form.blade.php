<style>
    .switch_parent input[type='checkbox']{
        display: block;
        opacity: 0;
    }
    .switch_parent .switch{
        position: relative;
        width: 60px;
        height: 34px;
        display: inline-block;
        background: #666666;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        -moz-transition: all 0.3s;
        -webkit-transition: all 0.3s;
    }
    .switch_parent .switch:after{
        content: "";
        position: absolute;
        left: 2px;
        top: 2px;
        width: 30px;
        height: 30px;
        background: #FFF;
        border-radius: 50%;
        box-shadow: 1px 3px 6px #666666;
    }
    .switch_parent input[type='checkbox']:checked + .switch{
        background: #009900;
    }
    .switch_parent input[type='checkbox']:checked + .switch:after{
        left: auto;
        right: 2px;
    }
</style>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group mg-b-0">
            <label class="form-label">Role Name: <span class="text-danger">*</span></label>
            {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Role Name','id'=>'name' ]) !!}
            @error('name')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    @if(auth()->user()->role == 'admin')
    <div class="col-6">
        <div class="form-group">
            <label class="form-label">Role Type: <span class="text-danger">*</span></label>
            {!! Form::select('type',roleTypes(),null,['class' =>'form-control '.($errors->has('type') ? 'parsley-error' : null), 'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'type','placeholder'=>'Select Role'])!!}
            @error('type')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    @endif
    <!-- @if(auth()->user()->role == 'admin')
        <div class="col-6">
            <div class="form-group">
               <label class="form-label">Has Role: </label>
                <div class="switch_parent">
                    <input type="checkbox" id="switch" class="switch_toggle togBtn">
                    <label class="switch" for="switch" title="inactive"></label>
                </div>
                @error('switch')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                @enderror
            </div>
        </div>
    @endif
    @if(auth()->user()->role == 'admin')
        <div class="col-6 has_roles" style="display: none">
            <div class="form-group">
                <label class="form-label">Sub Role: <span class="text-danger">*</span></label>
                {!! Form::select("has_roles_id",[],null,['class' =>'form-control '.($errors->has('has_roles_id') ? 'parsley-error' : null),
                                   'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'has_roles_id','placeholder'=>'Select'])!!}
                @error('has_roles_id')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                @enderror
            </div>
        </div>
    @endif -->

</div>

<div class="row row-sm">
    <input type="hidden" name="user_id" value="{{auth()->id()}}">
    @if(auth()->user()->role == 'sales')
        @include('admin.dashboard.roles.permissions',['permissionsTbl'=>dbSalesTables()])
    @elseif(auth()->user()->role == 'operations')
        @include('admin.dashboard.roles.permissions',['permissionsTbl'=>dbOperationsTables()])
    @else
        @include('admin.dashboard.roles.permissions',['permissionsTbl'=>adminDbTablesPermissions()])
    @endif

    @error('permissions')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
    @enderror

        <div class="col-12"> <button type="submit" class="btn pd-x-20 mg-t-10"><i class="far fa-save"></i> Save</button></div>
</div>
@push('js')
<script>
    @if(isset($role))
        var type =$('#type').val();
           getRolesData(type)
    @endif

    var switchStatus = false;
    $(".togBtn").on('click', function() {
        if ($(this)[0].classList.contains("on"))
            switchStatus = !switchStatus;
        else
            switchStatus = !switchStatus;

        hideShowWhatsappInput(switchStatus)
    });

    function hideShowWhatsappInput(switchStatus){
        if(switchStatus){
            $(".has_roles").fadeIn(500)
        }else{
            $(".has_roles").fadeOut(500)
            $('#has_roles_id').val('')
        }
    }

    $(document).on('change','#type',function (){
        var role =$(this).val();
        getRolesData(role)
    });

    function getRolesData(data){
        $.ajax({
            url:`/dashboard/checkRoles/${data}`,
            type:'get',
            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success:(response)=>{
                var listItems='';
                listItems+="<option selected disabled> Select </option>"
                $.each(response.data,function(key,value){
                    let oldHasRole = null;
                    @if(isset($role)&&$role->parent_role)
                        oldHasRole={{$role->parent_role}};
                        if(oldHasRole==value.id){
                            listItems += "<option value='" + value.id+ "' selected  >" + value.name + "</option>";
                        }else{
                            listItems += "<option value='" + value.id+ "'  >" + value.name + "</option>";
                        }
                        @else
                            listItems += "<option value='" + value.id+ "'  >" + value.name + "</option>";

                    @endif
                });
                $('#has_roles_id').html(listItems);
            },
            error:()=>{
                Swal.fire("error", "something went wrong please reload page", "error");
            }
        })
    }

    @if(isset($role) && $role->parent_role!=0)
    $(".togBtn").prop('checked',true);
    switchStatus = true
    hideShowWhatsappInput(switchStatus)
    @endif

</script>
@endpush
