<!-- Expiration date Modal -->
<div class="modal fade" id="add_expiration_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Expiration Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">
                <input type="hidden" value="" id="brand_id" />
                <div class="parent_of_expiration">
                    <label>Expiration Date</label>
                    <input type="date" class="form-control" min="{{date('Y-m-d')}}" id="expire_date_input" />
                    <small class="text-danger" id="expre_date_err"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" id="active_user" class="btn">Active</button>
            </div>
        </div>
    </div>
</div>

