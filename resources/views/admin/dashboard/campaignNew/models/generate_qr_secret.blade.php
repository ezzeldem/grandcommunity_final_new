<!-- Modal -->
<div class="modal fade" id="generate_qr" tabindex="-1" role="dialog" aria-labelledby="generate_qr" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"  style="max-width: 100%;width: 100%;text-align: center;display: flex;align-items: center;justify-content: center;">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title" id="generate_qr_title">Generate Qr/Secret</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="influ-counts" style="font-size: 27px" role="alert">
                    Influencer Count : <span class="influ-count badge badge-pill badge-success" ></span>
                </div>
                <div class="container">
                    <div class="row" style="flex-direction: column;">
                        <div class="form-group form-check-box" style="font-size: 20px">
                            <input type="checkbox" value="qr" name="generator"/>
                            <label class="form-label">Generate Qr</label>
                        </div>
                        <div class="form-group form-check-box">
                            <input type="checkbox" value="secret" name="generator"/>
                            <label class="form-label">Generate Secret</label>
                        </div>
                        <div class="form-group form-check-box">
                            <label class="switch"><input type="checkbox" id="is_test" name="is_test"> <span class="slider round"></span></label>
                            <label class="form-label">Generate Test Code / Qrcode</label>
                        </div>
                        <div class="form-group form-input">
                            <label class="form-label">Valid Times</label>
                            <input type="number" value="" name="qrcode_valid_times" id="qrcode_valid_times" step="1" placeholder="Valid Times"/>
                        </div>
                        <div class="form-group form-input">
                            <label class="form-label">Date</label>
                            <input type="date" value="" name="visit_or_delivery_date" id="visit_or_delivery_date" min="{{date('Y-m-d')}}"/>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer m-auto">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn" id="submit-qr_form">Save</button>
            </div>
        </div>
    </div>
</div>
