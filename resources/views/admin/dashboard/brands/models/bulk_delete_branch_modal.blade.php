{{--  statrt modal delete all branches   --}}
<div  class="modal fade" id="delete_all_branch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Delete Branches
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 style="color:#fff"> Are You Sure ? </h6>
                <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right"
                        data-dismiss="modal">Close</button>
                <button type="button" id="submit_delete_all_branch" class="btn Active hvr-sweep-to-right">Delete</button>
            </div>
        </div>
    </div>
</div>
{{--  end modal delete all branches   --}}

@push('js')
<script>
    //DELETE ALL BRANCHES (GET IDS OF SELECTED BRANDS)
    $(document).on('click','#btn_delete_all_branch',function (){
        var selected = new Array();
        $("#brand_branch_new input[type=checkbox]:checked").each(function() {
            if(this.value != 'on'){
                selected.push(this.value);
            }
        });
        if (selected.length > 0) {
            $('#delete_all_branch').modal('show')
            $('input[id="delete_all_id"]').val(selected);
        }else{
            Swal.fire("Error", "Please select a branch first", "warning");
        }
    });

    //SUBMIT DELETE ALL TO SELECTED Brancehs
    $(document).on('click','#submit_delete_all_branch',function (){
        let selected_ids =  $('input[id="delete_all_id"]').val();
        let brand_id=$("#brand_me_id").val();
        $.ajax({
            type: 'POST',
            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            url: '{{route('dashboard.branches.all.delete.all')}}',
            data: {selected_ids:selected_ids,brand_id:brand_id},
            dataType: 'json',
            success: function (data) {
                if(data.status){
                    console.log(data)

                    $('#delete_all_branch').modal('hide')
                    branchtable.ajax.reload();
                    for (let statictic in data.stat){
                        let elId = data.stat[statictic].id;
                        $(`#${elId}`).find('.counters').text(data.stat[statictic].count)
                    }
                    let list = data.message.map((msg)=>`<li>${msg}</li>`).toString();
                    Swal.fire("Success!",`<ul>${list}</ul>`, "success");
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
</script>
@endpush

