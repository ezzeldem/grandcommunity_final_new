<div class="modal fade effect-newspaper show" id="favListBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Add Influencer To  
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div id="error_msg"></div>
                <label><b>Company</b></label>
                <select class="form-control  select-to-get-other-options" name="brands"  id="select_brands"  data-other-id="#select_brands_groups" data-other-name="brand_id" data-other-to-reset=".reset-when-change-brand" data-url="{{route('dashboard.getGroupsListByBrandId')}}" data-show-other=".fav_list" required>
                    <option value=""> Select </option>

                </select>
                <small id="brand_id_error" class="text-danger"></small>

                <input class="text" type="hidden" id="influe_all_id" name="influe_all_id" value=''>
                <br/>
                <div class="fav_list" style="display: none">
                    <div class="my_create">
                        <button class="btn btn-dark mt-2 mb-2"  id="create_new_group"><i class="fa fa-plus-circle"></i> Group </button>
                    </div>
                    <div  style="margin-top: 20px !important;" id="accordion-dev">
                        <div class="" id="card_edit" style="margin-bottom: 0 !important;">
                            <label><b>Groups</b></label>
                            <select class="form-control reset-when-change-brand select2" name="brands_groups"  id="select_brands_groups" multiple="multiple" required></select>
                            <small id="brands_groups_error" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" id="submit_addInflueToGroup" style="" class="btn Active hvr-sweep-to-right"><i class="fa fa-plus-circle"></i> Save</button>
                    <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>

        $(document).ready(function(){

            $('#select_brands').select2({
            dropdownParent: $('#favListBrand'),
                placeholder: "Select",
                allowClear: true,
                ajax: {
                url: '{{ url('/dashboard/get_brand') }}',
                type: "get",
                dataType: 'json',

                delay: 150,
                data: function(params) {
                    return {
                        '_token': '{{ csrf_token() }}',
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: $.map(response['data'], function(item) {
                            // console.log(item);
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        });
        // $('#submit_addInflueToGroup').off().on('click', function (e) {
        //     e.preventDefault();
        //     var brand_id=$('#brand_id').val();
        //     var copy_all_id=$('#influe_all_id').val();
        //     var brands_groups=$('#brands_groups').val();
        //     $.ajax({
        //         type: "POST",
        //         url: "/dashboard/influe/AddInflue_to_group",
        //         dataType: 'json',
        //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         data: {
        //             brand_id: brand_id,
        //             copy_all_id:copy_all_id,
        //             brands_groups:brands_groups,
        //             country:country_arrayList
        //         },
        //         success: function (data) {
        //             $('#favListBrand').modal('hide');
        //             let countSuccess=0
        //             let countFaild=0
        //             let name=[];
        //             data.message.map((msg)=> (msg.status=='success')?(countSuccess = countSuccess+1):(countFaild=countFaild+1 ,name.push(msg.Name+'Group : '+msg.group_name)));
        //             let item=name.map((i,key)=> `<li>${key+1} - ${i}</li>`).join('');
        //
        //             Swal.fire("Done", `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li>  <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`, "success");
        //             name=[];
        //             setTimeout(function () { location.reload(true); }, 1000);
        //         },
        //         error: function (data) {
        //             if(data.responseJSON.errors){
        //                 $('#brands_groups_error').text('')
        //                 $('#brand_id_error').text('')
        //                 $('#name_error').text('')
        //                 $('#country_error').text('')
        //                 if(data.responseJSON.errors.brands_groups)
        //                     $('#brands_groups_error').text(data.responseJSON.errors.brands_groups[0])
        //
        //                 if(data.responseJSON.errors.brand_id)
        //                     $('#brand_id_error').text(data.responseJSON.errors.brand_id[0])
        //
        //                 if(data.responseJSON.errors.name)
        //                     $('#name_error').text(data.responseJSON.errors.name[0])
        //
        //                 if(data.responseJSON.errors.country_id)
        //                     $('#country_error').text(data.responseJSON.errors.country_id[0])
        //             }
        //
        //             setTimeout(function () { location.reload(true); }, 1000);
        //         }
        //
        //     });
        //
        //
        // });
        $('#brands').change(function (){
            $('.fav_list').show();
            $('#brand_id').val($(this).val());
            var country =$('option:selected', this).attr('attr-country');
            var groups =$('option:selected', this).attr('attr-groups');
            var myObject = eval('(' +country + ')');
            var mygroups = eval('(' +groups + ')');
            $.ajax({
                type: "GET",
                url: "/dashboard/brand_groups"+'/'+$(this).val(),
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    brand_id: $(this).val(),
                },

                success: function (data) {
                    $('#brands_groups').empty();
                    $.each(data.data, function (key, value) {
                        $('#brands_groups').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#brands_groups').val(mygroups).trigger('change');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

            $('#country_id_group').children().remove();
            $('#brands_groups').children().remove();
            for (i in myObject)
            {
                $("#country_id_group").append(`<option value="${myObject[i]["id"]}">${myObject[i]["name"]}</option>`);
            }
            for (i in mygroups)
            {
                $("#brands_groups").append(`<option value="${mygroups[i]["id"]}" attr-country='${mygroups[i]["country_id"].toString()}'>${mygroups[i]["name"]}</option>`);
            }
        });
        var country_arrayList=[];
        $('#brands_groups').change(function(){
            // $('option:selected').attr('attr-country');
            var value = $(this).children("option:selected").attr('attr-country');
            $('#brands_groups option:selected').each(function(){
                var value =$(this).attr('attr-country');
                country_arrayList.push(value)
            });
        });

        $(document).on('click','#create_new_group',function (){
            $("#card_add").show();
            // $("#card_edit").hide();
            $("#groupname").val('')
            $("#country_id_group").val("");
            $("#groupname").val('')
            $("#groupAdd").modal('show');
            getSubBrandByBrandId();
        });

        function getSubBrandByBrandId(){
            $('#select_sub_brands').html("<option value=''>{{__('lang.select_an_option')}}</option>");
            $.ajax({
                url: '{{route('dashboard.getSubBrandsListByBrandId')}}?brand_id='+Number($('#select_brands').val()),
                success: function (data){
                    let options = "<option value=''>{{__('lang.select_an_option')}}</option>";
                    $.each(data.options, function(key, row){
                        options += "<option value='"+row.key+"'>"+row.value+"</option>";
                    });
                    $('#select_sub_brands').html(options);
                },
                error: function(e) {
                    alert('Error! Cannot process this action.');
                }});
        }

        $(document).on('click','#card_edit',function (){
            $('#card_add').hide();
            $('#card_edit').show();
        });
    </script>
@endpush
