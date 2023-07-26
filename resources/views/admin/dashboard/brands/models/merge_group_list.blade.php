<div class="modal fade effect-newspaper show" id="merge_group_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                Merge
                </h5>
				<button type="button" class="close close-mergegroup-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body" >
                <form style="" action="" method="POST" enctype="multipart/form-data" id="submit_import_form">
                    @csrf
                    <input type="hidden" value="{{$brand->id}}" id="brand_user" data-country="{{is_array($brand->country_id) ? implode(',',$brand->country_id) : $brand->country_id}}">
                    <input type="hidden" value=""  id="brand_select">
                    <input type="hidden" value="" id="merge_left_groups_ids">
                    <input type="hidden" value="" id="merge_right_groups_ids">
                    <div class="row" id="sub-brand-form">
                        <div class="col-lg-6">
                            <div class="form-group" id="merge_brand_from_id">
                                <label class="form-label">Brand: <span class="tx-danger">*</span></label>
                                <select class="form-control" id="merge_brand_from"></select>
                            </div>
                            <div class="merge_all merge_left" style="display: none">

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="merge-right">
                                <div class="m-auto merge_icon">
                                    <i class="fas fa-exchange" style="color:#fff"></i>
                                </div>
                                <div class="merge_all" style="width: 90%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="to_group_id"  id="select_all_brand_groups" value="0">
                                        <label class="form-check-label" for="inlineCheckbox5">Add To Favourite List</label>
                                    </div>
									<div id="brand_groups"></div>


                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn m-auto">
                    <button type="button" id="save_merge" class="btn Active hvr-sweep-to-right">Save<span class="spinner"></span></button>
                    <button type="button" class="btn Delete close-mergegroup-modal hvr-sweep-to-right" id="close_modal"
                        data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready( function () {

            $('.merge-right input:checkbox').click(function() {
                $('.merge-right input:checkbox').not(this).prop('checked', false);
            });
            $('#merge_brand_from').on('change',function (){
                var id =$(this).val();
                if(id.length){
                    getGroupBrands(id);
                }else{
                    $('.merge_left').empty()
                }
            })

            function CheckAll(className, elem) {

                var elements = document.getElementsByClassName(className);
                var l = elements.length;
                if (elem.checked) {
                    for (var i = 0; i < l; i++) {
                        elements[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < l; i++) {
                        elements[i].checked = false;
                    }
                }
            }

            //TO SELECT ALL
            $(document).on('click','#select_all_groups',function (){
                CheckAll('merge_box1',this);
            });

         function getGroupBrands(id){
             $('#brand_select').val(id);
             $.ajax({
                        type: 'GET',
                        url: `/dashboard/groupList_merge/${id}`,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $('.merge_left').empty()
                            $('.merge_left').show()
                            if(data.data.length>0){
                                $('.merge_left').append(`<div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="select_all_groups" value="option1">
                                    <label class="form-check-label" for="inlineCheckbox1">all</label>
                                </div>`)
                                for(let i=0; i < data.data.length; i++){
                                    $('.merge_left').append(`
                                   <div class="form-check">
                                      <input class="form-check-input merge_box1" type="checkbox" id="merge_box1" value="${data.data[i].id}">
                                        <label class="form-check-label" for="inlineCheckbox1">${data.data[i].name} [<small>${data.groupsCount[i].brand_name}</small>]</label>
                                        <span style="float: right;color: #fff">${data.groupsCount[i].count}</span>
                                    </div>
                                `)
                                }
                            }else{
                                $('.merge_left').append(`<p>No Group Found</p>`)
                            }

                        },
                    });

         }
            $(document).on('click','#save_merge',function (){

                var selected_left = new Array();
				// $("#save_merge").addClass("spin");
				// $("#save_merge").attr("disabled", true);
                $(".merge_left input[type=checkbox]:checked").each(function() {
                    if(this.value!='on'){
                        selected_left.push(this.value);
                    }
                });

                // var selected_right = $('.merge-right input[type=checkbox]:checked').val();
                var selected_right = $('.merge-right input[type=radio]:checked').val();
                    $('input[id="merge_right_groups_ids"]').val(selected_right);
                if (selected_left.length > 0 && selected_right!='' ) {
                    $('input[id="merge_left_groups_ids"]').val(selected_left);
                    $.ajax({
                        type: 'POST',
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        url: '{{url('/dashboard/groupList-merge-save')}}',
                        data:{"brands_from":$('#merge_left_groups_ids').val(),"brand_id":$('#brand_user').val(),'brand_select':$('#brand_select').val(),"brands_to":$('#merge_right_groups_ids').val(),'brand_country_select': $('#merge_brand_from').find('option:selected').attr("data-country-from") ,'brand_user_country':$('#brand_user').attr('data-country')},
                        dataType: 'json',
                        success: (data) => {
							 // $("#save_merge").removeClass("spin");
				             // $("#save_merge").attr("disabled", false);
                             if(data.status==true){
                                 let countSuccess=0
                                 let countFaild=0
                                 let name=[];
                                 data.message.map((msg)=> (msg.status=='success')?(countSuccess = countSuccess+1):(countFaild=countFaild+1 ,name.push(msg.Name+'---'+msg.message)));
                                 let item=name.map((i,key)=> `<li>${key+1} - ${i}  <small></small> </li>`).join('');
                                 Swal.fire("Done", `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`, "success").then((result) => {
                                     if (result.isConfirmed) {
                                         location.reload();
                                     }
                                 });
                             }

                        },
                        error: function (data) {
                            if(data.responseJSON.status=='false'){
                                Swal.fire("Error",data.responseJSON.message,'error')
                            }

                            // setTimeout(function(){
                            //     window.location.reload();
                            // }, 4000);
                        }
                    });

                }else{
                    Swal.fire("Error", "Please Select Group First", "error");
                    // setTimeout(function(){
                    //     window.location.reload();
                    // }, 4000);
                }

            });

})
    </script>
@endpush
