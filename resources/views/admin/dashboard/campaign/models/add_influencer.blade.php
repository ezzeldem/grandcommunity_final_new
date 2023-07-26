<div class="modal fade effect-newspaper show grand-add-model" id="add_influecer_modal" tabindex="-1" role="dialog" aria-labelledby="camp_complain"
     aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="camp_complain">
                    Add Influencer
                </h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 parentInfluencers mt-3">
                        <label>Influencers</label>
                        <select class="form-control select2 " name="influencersData" multiple="multiple"  id="influencersData">
                        </select>
                        <small class="text-danger" id="errorInfluencers"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button type="button" class="grand-add-button" id="actionAddInfluencer">Add Influencer</button>
                    <button type="button" class="grand-add-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        function getInfluencerByCampaignCountry() {
            $('.open_add_influecer_modal_btn').prop('disabled', true)
           $.ajax({
                   url: '{{route("dashboard.campaigns.get-influencers-by-country")}}',
                   type: "GET",
                   dataType: 'json',
                   delay: 150,
                   cache: true,
                   data: {
                           '_token': '{{ csrf_token() }}',
                           'countries': "{{implode(",", $campaign->country_id)}}"
                    },
                   success: function(response) {

                       let options = $.map(response['data'], function(val, key) {
                           return `<option value="${key}">${val}</option>`;
                       });
                       $('#influencersData').html(options)
                       $('#influencersData').select2({
                           placeholder: 'Select',
                       });

                       $('.open_add_influecer_modal_btn').find('.fa-spinner').remove();
                       $('.open_add_influecer_modal_btn').prop('disabled', false)

                   }
           })
        }
        $(document).ready( function () {
            getInfluencerByCampaignCountry()
            //add influencers to campaign
            $(document).on('click','#actionAddInfluencer',function(){
                var campaignId = "{{$campaign->id}}";
                var brandId = "{{$brand->id}}";
                var influencsers = $('#influencersData').val();
                $('#errorInfluencers').empty()
                $.ajax({
                    url:'{{route("dashboard.campaigns.add-influencers-to-campaign")}}',
                    type:'post',
                    data:{
                        '_token': '{{ csrf_token() }}' , 'campaignId':campaignId
                        , 'brandId':brandId, 'influencsers':influencsers
                    },success:function(res){
                        Swal.fire(
                            'success',
                            'Influerncers Inserted Successfully',
                            'success',
                        )
                        $("#exampleTbl").DataTable().ajax.reload()
                        $('#influencersData').empty()
                        $('#errorCountry').html('')
                        $('#add_influecer_modal').modal('hide')
                    },error:function (err){
                        if(err.responseJSON.errors.influencsers){
                            $('#errorInfluencers').html(err.responseJSON.errors.influencsers)
                        }
                    }
                })
            })


        })
    </script>
@endpush
