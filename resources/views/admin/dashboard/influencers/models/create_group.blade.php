<div class="modal fade effect-newspaper show" id="groupAdd" tabindex="-1" role="dialog" aria-labelledby="groupAdd" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Add Group
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card" id="card_add" style="margin-bottom: 0 !important;  display: none">
                    <div class="card-body">
                        <form>
                            <br/>
                            <div class="form-group">

                            <label><b>Brand</b></label>
                            <select class="form-control reset-when-change-brand select-to-get-other-options select2" name="sub_brands"  id="select_sub_brands"  data-other-id="#select_brands_groups" data-other-name="sub_brand_id" data-other-to-reset="#select_brands_groups" data-show-other=".fav_list" data-url="{{route('dashboard.getGroupsListBySubBrandId')}}" required>
                                <option value=""> Select </option>

                            </select>
                            <small id="sub_brand_id_error" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Group Name</label>
                                <input type="text" class="form-control" name="name" id="groupname" aria-describedby="emailHelp" placeholder="Enter group name" maxlength="15" required />
                                <small id="name_error" class="text-danger"></small>
                                <input type="hidden" id="account_user_login_id" value="{{auth()->user()->id}}">
                                <input type="hidden" id="flag">
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="color">Group Country</label><br>--}}
{{--                                <select class="form-control select2 "  multiple="multiple" name="country_id[]" placeholder="select country...."  id="country_id_group" style="width: 100%">--}}

{{--                                </select>--}}

{{--                                <small id="country_error" class="text-danger"></small>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label for="color">Group Color</label><br>
                                <input type="color" class="form-control"  name="color" id="symbol" required/>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="brand_id" value="" id="brand_id">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit_addGroup" class="btn Active hvr-sweep-to-right"><i class="fa fa-plus-circle"></i> Save </button>
                <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('body').off().on('click', '#submit_addGroup', function (e) {
            e.preventDefault();
            var name = $('#groupname').val();
            var created_by = $('#account_user_login_id').val();
            var brand_id=$('#select_brands').val();
            var sub_brand_id=$('#select_sub_brands').val();
            var country_id=[];
            var color = $('#symbol').val();
            var flag=$('#flag').val();
            $.ajax({
                type: "POST",
                url: "/dashboard/influe/groups_create",
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    name: name,
                    created_by: created_by,
                    brand_id: brand_id,
                    sub_brand_id: sub_brand_id,
                    country_id: country_id,
                    color:color,
                    flag:flag,

                },
                success: function (data) {
                    $('#brands_groups').append(`<option value="${data.data.id}" selected> ${data.data.name}</option>`);
                       // $('#card_add').hide();
                    $('#card_edit').show();
                    $("#groupAdd").modal('hide');
                    $('#select_brands_groups').append(`<option value="${data.data.id}" selected> ${data.data.name}</option>`);
                    Swal.fire("Done", "Group Created Successfully !", "success");
                },
                error: function (data) {
                    if("brand_id" in data.responseJSON.errors){
                        $('#brand_id_error').text('The company field is required.');
                    }
                    if("sub_brand_id" in data.responseJSON.errors){
                        $('#sub_brand_id_error').text('The brand field is required.');
                    }
                    if("name" in data.responseJSON.errors){
                        $('#name_error').text('The group name field is required.');
                    }
                }
            });


        });
    </script>
@endpush
