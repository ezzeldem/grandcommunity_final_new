<div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Delete Influencer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 style="color:#fff"> Are You Sure you want delete? </h6>
                <hr>
                <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value='' style="display: block;">
                <div class="row">
                <div class="col-md-12" >
                <textarea class="text" type="textarea" id="reasonall" name="reason" value='' placeholder="Enter Reason" style="background-color: #202020; color:white;width:100%;height:40px;border: 0;padding:5px"></textarea>
                <span id="reason_error" style="color: red"></span>
                </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right"
                        data-dismiss="modal">Close</button>
                <button type="button" id="submit_delete_all" class="btn Active hvr-sweep-to-right">Delete</button>
            </div>
        </div>
    </div>
</div>
