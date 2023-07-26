@can('delete group lists')
        <!-- delete influencers from group Modal -->
        <div class="modal fade" id="dlete_influ_group_modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delInfluencerLabel">Move To Disliked</h5>
                        <button type="button" class="close close_dislike_influencer" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 style="color:#fff;"> Are You Sure ? </h6>
                        <input type="hidden" id="brand_id" name="brand_id" value="{{ $brand->id }}">
                        <input type="hidden" id="remove_all_iddss" name="remove_all_iddss[]">
						<input type="hidden" id="delete_influ_option" name="delete_influ_option" value="">
						
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn Delete close_dislike_influencer hvr-sweep-to-right" data-dismiss="modal">Close</button>
                        <button type="button" id="deletegroupss_influencers"
                                class="btn Active hvr-sweep-to-right" style="width:33%;text-align:center;" >Remove <span class="spinner"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!--end  delete influencers from group Modal -->
    @endcan