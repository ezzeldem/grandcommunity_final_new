<div class="modal fade effect-newspaper show" id="reply_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                   Reply
                </h5>
                <button type="button" class="close closeReplyModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                {!! Form::open(['url' => [''],'method'=>'post','data-parsley-validate'=>'','id'=>'reply_form','class'=>'display:flex;align-items :center ; gap :20pxdisplay:flex;align-items :center ; gap :20px', 'enctype'=>'multipart/form-data']) !!}
                    <div class="replySection">
                        {!! Form::hidden('complain_id', null, []) !!}
                        {!! Form::textarea('reply', old('reply'), ['class'=>'form-control', 'id'=>'reply']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button type="button" id="save_reply" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary closeReplyModal"
                            data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#save_reply').on('click', function(){
            var complain_id = $('[name="complain_id"]').val();
            var reply = $('[name="reply"]').val();
            $.ajax({
                url:`/dashboard/replying`,
                type:'post',
                data:{'_token': '{{ csrf_token() }}' , 'reply': reply,'complain_id':complain_id},
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(data)=>{
                    if(data.status){
                        $('#reply_modal').toggle('true');
                        $('[name="reply"]').val(' ');
                        Swal.fire(data.text, data.icon);
                    }else{
                        swal.close();
                        let err = data.message.expirations_date[0];
                        $('#reply_form').show();
                        $('#expre_date_err').text(err)
                    }
                },
                error:(data)=>{
                    // console.log(data);
                }
            })
        })
    </script>
@endpush
