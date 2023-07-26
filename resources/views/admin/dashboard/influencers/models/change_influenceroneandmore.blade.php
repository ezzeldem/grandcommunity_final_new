<div class="modal fade effect-newspaper show" id="change_details_Moda_influencer_one_or_more" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Change Influencers Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label><b>Brand</b></label>

                <small id="brand_id_error" class="text-danger"></small>
                <div id="appendingdata">
                    <select name="brand_id" multiple id="d">
                    </select>
                </div>

                <div id="newdatabind" style="width:250ox ;">
                 
                </div>
                
                
                <div class="modal-footer">
                    <button type="button" id="submit_change_status" style="" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')

@endpush
