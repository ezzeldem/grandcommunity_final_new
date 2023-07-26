<div class="modal fade" id="edit_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header" style="align-items: center">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Edit
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="mod_close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="text" type="hidden" id="influe_all_id" name="influe_all_id" value=''>
                <div class="col_change">
                    <div class="form-group">
                        <label class="form-label" >Status</label>
                        <select class="form-control"  id="bulk_active"  name="bulk_active" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose Status">
                            <option value="1">Active</option>
                            <option value="-1">InActive</option>
                        </select>
                    </div>
                    @if(Route::currentRoutename() == 'dashboard.admins.index')
                        <div class="form-group">
                            <label class="form-label">Roles</label>
                            {!! Form::select("bulk_role_id",adminRoles(),null,['class' =>'form-control select2 '.($errors->has('role_id') ? 'parsley-error' : null),
                                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'bulk_role_id','placeholder'=>'select roles'])!!}
                        </div>
                    @elseif(Route::currentRoutename() == 'dashboard.operations.index')
                        <div class="form-group">
                            <label class="form-label">Roles</label>
                            {!! Form::select("bulk_role_id",operationRoles(),null,['class' =>'form-control select2 '.($errors->has('role_id') ? 'parsley-error' : null),
                                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'bulk_role_id','placeholder'=>'select roles'])!!}
                        </div>
                    @elseif(Route::currentRoutename() == 'dashboard.sales.index')
                        <div class="form-group">
                            <label class="form-label">Roles</label>
                            {!! Form::select("bulk_role_id",salesRoles(),null,['class' =>'form-control select2 '.($errors->has('role_id') ? 'parsley-error' : null),
                                               'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'bulk_role_id','placeholder'=>'select roles'])!!}
                        </div>
                    @endif


                </div>

            </div>

            <div class="modal-footer custom">
                <div class="left-side">
                    <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal" id="mod_close">Cancel</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <button type="button" id="submit_edit_all" class="btn Active hvr-sweep-to-right">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* .form-group {
        display: flex;
        align-items: center ;
    } */
    .form-group .form-label {
        flex-basis: 20%
    }
    .form-group .select2-container--default {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        background-color: #202020  !important;
        border: 1px solid #202020 !important;
        color: var(--second-color) !important;
    }
</style>
@push('js')
    <script>
        //CLOSE BUTTON
        $(document).on('click','#mod_close',function(){
            $('#edit_all').modal('hide')
        })
    </script>
@endpush
