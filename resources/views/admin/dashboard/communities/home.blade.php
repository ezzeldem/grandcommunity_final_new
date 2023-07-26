<div class="row gutters">

      
        <div class="container">
            <div class="row">
                <div class="span12">
                    <h1>Bootstrappy Faux Table List Thing With Tooltip Alternative</h1>
                </div>
            </div>
            <div class="list">
                @foreach($tasks as $task)
                    <div class="row listItem">
                        <div class="span4 truncate">
                            <a class="truncated" href="#">
                                {{ $task->description }}
                            </a>
                        </div>
                        <div class="span2">{{$task->start_date}}</div>
                        <div class="span2">{{$task->end_date}}</div>
                        <div class="span2">{{taskPriority($task->priority)}}</div>
                        <div class="span2">{{ $task->status == 0 ? 'Resolved' : 'Uresolved'}}</div>
                        <div class="span2">
                            <input type="checkbox" id="task_status" name="status" data-id="{{ $task->id }}" {{ $task->status == 0 ? 'checked' : ''}}>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

</div>

@push('js')
    <script>
        $(document).ready(function(){
            $('#task_status').change(function() {
                var id = $(this).data('id');
                $.ajax({
                    url:"{{ url('/dashboard/task/status/toggle') }}"+"/"+id,
                    type:'get',
                    data:{'_token':'{{csrf_token()}}', 'status':this.checked},
                    success:function(res){
                        console.log(res);
                    }
                })
            });
        })
    </script>
@endpush
