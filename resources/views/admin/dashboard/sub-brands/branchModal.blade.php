<!--Add Modal -->
<div class="modal fade" id="branchModal" tabindex="-1" role="dialog" aria-labelledby="add_branch" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="branchModalLabel">Add Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row row-sm">

                    <div class="col-12 mt-2">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Name: <span class="tx-danger">*</span></label>
                            {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Name','id'=>'name' ]) !!}
                            @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="form-group mg-b-0">
                            <label class="form-label">City: <span class="tx-danger">*</span></label>
                            {!! Form::text('city',null,['class' =>'form-control '.($errors->has('city') ? 'parsley-error' : null),'placeholder'=> 'Enter City','id'=>'city' ]) !!}
                            @error('city')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="form-group mg-b-0">
                            <label class="form-label">Country: <span class="tx-danger">*</span></label>
                            {!! Form::select("branch_country_id",countries(),null,['class' =>'form-control '.($errors->has('branch_country_id') ? 'parsley-error' : null),
                                       'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'branch_country_id','placeholder'=>'Select Country','style'=>'width:100%;'])!!}
                            @error('branch_country_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label class="form-label">Status: <span class="tx-danger">*</span></label>
                            {!! Form::select("status",status(),null,['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
                                       'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'branch_status','placeholder'=>'Select Status','style'=>'width:100%;'])!!}
                            @error('status')
                            <ul class="parsley-errors-list filled" id="parsley-id-11">
                                <li class="parsley-required">{{$message}}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                <button type="button" class="btn Active hvr-sweep-to-right" id="save_branch">Save</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    let branches = $('#table_branches').data('branches');
</script>
<script src="{{asset('js/influencer/branches_crud.js')}}"></script>
@endsection
