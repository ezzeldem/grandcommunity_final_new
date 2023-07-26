@can('create group lists')
        <!-- Copy influe Modal -->
        <div class="modal fade" id="copy_influ_modal" tabindex="-1" role="dialog"
             aria-labelledby="copyInfluModel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyInfluModel">Choose Group</h5>
                        <button type="button" class="close influencer_close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="copy_influencer_modal_form">
                            <div class="form-group">
                                <label for="choose_group_list">Choose group</label>
			  
                                <select  class="form-control" id="choose_group_list" required>
                                </select>
                            </div>
                            <input type="hidden" id="copy_all_id" name="copy_all_id[]">
							<input type="hidden" id="from_group_id" name="from_group_id" value="0">
							<input type="hidden" id="copy_move_type" name="copy_move_type" value="0">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn influencer_close Delete hvr-sweep-to-right"  data-dismiss="modal">Close</button>
                        <button type="button" id="addgroupfavadd" name="addgroupfavadd" class="btn Active hvr-sweep-to-right" style="width:33%;text-align:center;">Save<span class="spinner"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Copy influe Modal -->
        @if (Session::has('error'))
            <script>
                Swal.fire("Cancelled", "Please select an influencer first!", "warning")
            </script>
        @endif

@endcan	