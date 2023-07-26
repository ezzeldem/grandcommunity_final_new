{{--  statrt modal delete all groups   --}}
<div  class="modal fade" id="delete_all_groups" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Delete GroupList
                </h5>
                <button type="button" class="close close-group-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 style="color: #fff;"> Are You Sure ? </h6>
                <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn close-group-modal Active hvr-sweep-to-right"
                        data-dismiss="modal">Close</button>
                <button type="button" id="submit_delete_all_groups" class="btn Delete hvr-sweep-to-right">Delete</button>
            </div>
        </div>
    </div>
</div>
{{--  end modal delete all groups   --}}


