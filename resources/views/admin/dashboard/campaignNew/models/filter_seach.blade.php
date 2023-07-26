<div class="card mt-2 filterSearch" >
    <div class="card-header" data-toggle="collapse" href="#collapseExampleFilter" role="button" aria-expanded="true" aria-controls="collapseExampleFilter">Search <i class="fas fa-chevron-down"></i></div>
    <div class="card-body collapse in" id="collapseExampleFilter" style="" aria-expanded="true">
        <div class="row">
            <div class="card">
                <div class="card-body" >
                        <div class="row">
                            <div class="col-md-3 mt-2">
                                <label class="badge badge-primary">Rate Search</label>
                                <select id="rateCheck" class="form-control">
                                    <option selected disabled>Select</option>
                                    <option value="1">Rate 1</option>
                                    <option value="2">Rate 2</option>
                                    <option value="3">Rate 3</option>
                                    <option value="4">Rate 4</option>
                                    <option value="5">Rate 5</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label class="badge badge-primary">Has QRcode</label>
                                <select id="qrCheck"  class="form-control" >
                                    <option selected disabled>Select</option>
                                    <option value="1">Has QRcode:</option>
                                    <option value="2">Has not QRcod:</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label class="badge badge-primary">Visit Search</label>
                                <select id="visitCheck" class="form-control">
                                    <option  disabled selected="">Select</option>
                                    <option value="1">Visited</option>
                                    <option value="2">Not Visited</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label class="badge badge-primary">Coverage</label>
                                <select id="coverage_status" class="form-control">
                                    <option  disabled selected="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label class="badge badge-primary">brief</label>
                                <select id="brief" class="form-control">
                                    <option  disabled selected="">Select</option>
                                    <option value="1">Send</option>
                                    <option value="2">Not Send</option>
                                </select>
                            </div>

                            <div class="col-md-3 mt-2">
                                <label class="badge badge-primary">Code Search</label>
                                <input type="text" id="qrcode_search_form_input" class="form-control" placeholder="enter code ">

                            </div>
                        </div>
                    <button  id="visitSearch" type="button" class="btn mx-0 mb-2 mt-3">
                        <i class="fas fa-search pr-2" style="color:#fff;"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

