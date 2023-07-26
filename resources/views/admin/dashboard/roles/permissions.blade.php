@foreach($permissionsTbl as $tbl)
    @if(count(userPermissions($tbl)))
    <div class="col-xl-4 col-lg-4 col-md-6">
        <div class="card" style="">
            <div class="card-body box " style="padding: 10px !important;">
                <h4 class="card-title text-white">{{($tbl)}} <i class="icon-spellcheck check-all"></i></h4>
            </div>

            <div class="comment-widgets">
                <div class="card-body" style="background: var(--main-bg-color) !important;">
                    @forelse(tblPermissions($tbl) as $permission)
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input name="permissions[]" type="checkbox" class="custom-control-input" id="{{$tbl . $permission->id}}"
                                   value="{{$permission->name}}" @if( isset($role) && $role->hasPermissionTo($permission->name) ) checked @endif >
                            <label class="custom-control-label" for="{{$tbl . $permission->id}}">
                                {{$permission->name}}
                            </label>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>
    @endif
@endforeach

@section('js')
    <script>
            $('.check-all').on('click',function(){
                let checkBoxes = $(this).parents('.card-body').next().children().find('input[type=checkbox]');
                checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            });
    </script>
@endsection
