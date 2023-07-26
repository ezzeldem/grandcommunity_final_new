<div class="card mt-2 filterSearch" id="campaign-details-search">
    <div class="card-header" data-toggle="collapse" href="#collapseExampleFilter" role="button" aria-expanded="true" aria-controls="collapseExampleFilter"> <i class="fas fa-filter mr-3"></i> Filter <i class="fas fa-chevron-down ml-2"></i></div>
    <div class="card-body collapse in" id="collapseExampleFilter" style="" aria-expanded="true">
            <div class="card">
                <div class="card-body" >
                        <div class="row">
                            <div class="col-md-3 col-sm-6  mb-3">
                                <label class="">Rate Search</label>
                                <select id="checkrate" class="form-control selected-item">
                                    <option selected value="0">Select</option>
                                    <option value="1">Rate 1</option>
                                    <option value="2">Rate 2</option>
                                    <option value="3">Rate 3</option>
                                    <option value="4">Rate 4</option>
                                    <option value="5">Rate 5</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <label class="">Has QRcode</label>
                                <select id="checkqr"  class="form-control selected-item" >
                                    <option selected value="0">Select</option>
                                    <option value="1">Has QRcode:</option>
                                    <option value="2">Has not QRcod:</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <label class="">Visit Search</label>
                                <select id="checkvisit" class="form-control selected-item">
                                    <option selected value="0">Select</option>
                                    <option value="1">Visited</option>
                                    <option value="2">Not Visited</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6  mb-3">
                                <label class="">Coverage</label>
                                <select id="coverage_status" class="form-control selected-item">
                                    <option selected value="0">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6  mb-3">
                                <label class="">brief</label>
                                <select id="brief" class="form-control selected-item">
                                    <option selected value="0">Select</option>
                                    <option value="1">Send</option>
                                    <option value="2">Not Send</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6  mb-3">
                                <label class="">Code Search</label>
                                <input type="text" id="qrcode_search_form_input" class="form-control" placeholder="enter code ">

                            </div>
                        </div>
                        <div style="display:flex;justify-content:flex-start;gap:15px;align-items:flex-start;flex-direction:row">
                            <button  id="visitSearch" type="button" class="btn mx-0 mb-2 mt-3 hvr-sweep-to-right">
                                <i class="fas fa-search pr-2" style="color:#fff;"></i> Search
                            </button>
                            <button  id="reset" type="button" class="btn mx-0 mb-2 mt-3 hvr-sweep-to-right">Reset</button>
                        </div>
                </div>
            </div>
    </div>
</div>

