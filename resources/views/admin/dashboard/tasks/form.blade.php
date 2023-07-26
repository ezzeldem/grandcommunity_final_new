

<div class="row row-sm create_form tasks_form">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Description: <span class="text-danger">*</span></label>
            {!! Form::textarea('description', null, ['class' =>'form-control '.($errors->has('description') ? 'parsley-error' : null),'placeholder'=> 'Enter Description','id'=>'description' ]) !!}
            @error('description')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-1"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Start Date: <span class="text-danger">*</span></label>


            {!! Form::date('start_date', isset($task) ? $task->start_date : '', ['class' =>'form-control '.($errors->has('start_date') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'start_date' ]) !!}
            @error('start_date')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-2"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">End Date: <span class="text-danger">*</span></label>
            {!! Form::date('end_date',  isset($task) ? $task->end_date : '', ['class' =>'form-control '.($errors->has('end_date') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'end_date' ]) !!}
            @error('end_date')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-3"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Priority: <span class="text-danger">*</span></label>
            {!! Form::select("priority",['0' => 'Top', '1' => 'High', '2' => 'Low'],null,['class' =>'form-control '.($errors->has('priority') ? 'parsley-error' : null),
                            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'priority','placeholder'=>'-- Select Priority --'])!!}
            @error('priority')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <label class="form-label">Status: <span class="text-danger">*</span></label>
            {!! Form::select("status",['0' => 'Resolved', '1' => 'Unresolved'],null,['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
                            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status','placeholder'=>'-- Select Status --'])!!}
            @error('status')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group tasks_form">
            <div class="" style="display: flex;
                    justify-content: flex-start;
                    align-items: flex-start;
                    flex-direction: column;">
                <label class="form-label">Assign Status: <span class="text-danger">*</span></label>
                <div style="    display: flex;
                    justify-content: flex-start;
                    align-items: flex-start;
                    flex-direction: column;">
                    <div class="">
                        {!! Form::radio('assign_status', 0, true,['class' => 'assign_status', 'id' => 'individuals']) !!}
                        {!! Form::label('individuals', 'Individuals', ['class' => 'form-label']) !!}
                    </div>
                    <div class="">
                        {!! Form::radio('assign_status', 1, true,['class' => 'assign_status', 'id' => 'departments']) !!}
                        {!! Form::label('departments', 'Departments', ['class' => 'form-label']) !!}
                    </div>
                </div>
                @error('assign_status')
                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12" >
        <div class="form-group">

            <label class="form-label">Assign To: <span class="text-danger">*</span></label>

            {!! Form::select("assigned_to[]",isset($task)?$assigns:[],isset($task)?$task->assign_to:null,['class' =>'form-control select2'.($errors->has('assigned_to') ? 'parsley-error' : null),
                                'multiple'=>'multiple', 'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'assigned_to','placeholder'=>'-- Assign to an individual or a department --'])!!}
            @error('assigned_to')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            @isset($task)
                <a href="{{$task->file}}" download>
                    <label class="form-label">Click Here To Download</label>
                </a>
            @endisset
                <label class="form-label">File: <span class="text-danger">*</span></label>
                <div class="custom-file">
                    {!! Form::file('file',['class'=>'custom-file-input '.($errors->has('file') ? 'parsley-error' : null),'id'=>'file']) !!}
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            @error('file')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 save">
        {!! Form::submit('Save', [ "id" => "submit_addInflueToGroup", "class" => "btn" , "style" => "background-color: #202020;color: #fff" ]) !!}
        <!-- <a href="{{route('dashboard.tasks.index')}}"  class="btn" style="background:#a27929;color:#fff" data-dismiss="modal">Back</a> -->
    </div>
</div>
<script>

</script>
