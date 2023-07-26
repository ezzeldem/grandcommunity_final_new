<!-- Modal -->
<div class="modal fade" id="delivered_details" tabindex="-1" role="dialog" aria-labelledby="delivered_details" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">influencer Deliver Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="labels">
                    <label class="" style="flex-basis:30%" >Name  : </label>
                    <label class="inflencer_name"></label>
                </div>
                <div class="labels">
                    <label class="" style="flex-basis:30%" >Username  : </label>
                    <label class="inflencer_username"></label>
                </div>

                <div class="form-body all addressDetailsBody" style="display: block;">
                    <form id="deliverDetail_form">
                        <div class="form-group">
                            <label class="control-label col-md-6"> Address</label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Influencer Address" minlength="5">
                            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required address-error"></li></ul>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6"> Location</label>
                            <input type="url" name="location" id="location" class="form-control" placeholder="Influencer Location">
                            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required location-error"></li></ul>
                        </div>
                        <div class="form-group phoneForm">
                            <label class="control-label col-md-6"> Phones</label>
                            <div id="phoneDiv">

                            </div>
                            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required phone-error"></li></ul>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="date">Delivered Date</label>
                            <input class="form-control" type="date" id="date" name="date">
                            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required date-error"></li></ul>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="time">Delivered time</label>
                            <input class="form-control" type="time" id="time" name="time">
                            <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required time-error"></li></ul>
                        </div>
                        <fieldset id="printNote">
                            <h6>Note</h6>
                            <div id="noteText" style="padding: 5px;">
                                <textarea name="note" id="note" class="form-control" rows="4" cols="5" placeholder="please enter your note....." maxlength="50"></textarea>
                                <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required note-error"></li></ul>
                            </div>
                        </fieldset>
                        <input type="hidden" class="camp_influ_id" name="camp_influ_id">
                        <input type="hidden" name="influencer_id" id="influencer_id">
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveDeliverDetail">Save changes</button>
            </div>
        </div>
    </div>
</div>
