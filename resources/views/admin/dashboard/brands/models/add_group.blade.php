@can('create group lists')
        <!-- Modal create Groups -->
        <div class="modal fade" id="favgrouplist_modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editlabelmodal">Create Group</h5>
                        <button type="button" class="close close_addgroup_model" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="brand_add_group_form">
                            <input type="hidden" id="hidden_name">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Group Name</label>
                                <input type="text" class="form-control" name="name" id="groupname"
                                       aria-describedby="emailHelp" placeholder="Enter group name"
                                       maxlength="255" required />
                                <small id="name_error" class="text-danger"></small>
                                <input type="hidden" id="account_user_login_id" value="{{auth()->user()->id}}">
                                <input type="hidden" name="id" id="hidden_id">
                                <input type="text" id="flag" name="flag" value=""/>
                                <input type="hidden" name="sub_brand_id" value="{{$subbrand->id??0}}" id="sub_brand_id">
                                <input type="hidden" name="country_id[]" value=[] id="country_id_group">
                            </div>

                            @if(($subbrand->id??0) <= 0 && isset($brand->subbrands))
                            <div class="form-group">
                                <label for="color">Group Of Brand</label><br>
                                <select class="form-control select2 " name="sub_brand_id" placeholder="Select Country" id="sub_brand_id" style="width:100%" required>
                                    @if(isset($brand->subbrands))
                                    @foreach($brand->subbrands as $sub_brand)
                                        <option  value={{$sub_brand->id}}> {{$sub_brand->name}} </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="color">Group Color</label><br>
                                <input type="color" class="form-control"  name="color" id="symbol" required/>
                                <input type="hidden" id="hidden_symbol">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="brand_id" value="{{ $brand->id }}" id="brand_id">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn close_addgroup_model Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                        <button type="button" id="addgroupfav" name="addgroupfav" class="btn Active hvr-sweep-to-right" style="width:33%;text-align:center;">Save<span class="spinner"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Modal create Groups  -->
    @endcan
