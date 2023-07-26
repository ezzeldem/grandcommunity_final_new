
<div class="modal fade effect-newspaper show" id="add_influecer_modal" tabindex="-1" role="dialog" aria-labelledby="camp_complain"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="camp_complain">
                   Add Influencer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-sm-12 col-md-12 mt-3" >
                        <label>Campaign Type</label>
                        <select class="form-control select2 " name="campaignType"  id="campaignType">
                            @if($campaign->campaign_type == 3)
                            <option value="0">Visit</option>
                            <option value="1">Delivery</option>
                            @elseif($campaign->campaign_type == 0)
                                <option value="0">Visit</option>
                            @else
                                <option value="1">Delivery</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-12 mt-3" >
                        <label>Country</label>
                        <select class="form-control select2 " name="countryType"  id="countryType">
                            <option disabled selected>Select Country...</option>
                            @foreach($countries as $country)
                                <option value={{$country->id}}> {{$country->name}} </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="errorCountry"></small>
                    </div>

                    <div class="col-sm-12 col-md-12 parentInfluencers mt-3" style="display: none">
                        <label>Influencers</label>
                        <select class="form-control select2 " name="influencersData" multiple="multiple"  id="influencersData">
                        </select>
                        <small class="text-danger" id="errorInfluencers"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button style="display: none" type="button" id="actionAddInfluencer" class="btn">Add Influencer</button>
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready( function () {

            //get influencers not in campaign
            $(document).on('change','#countryType',function (){
                var country = $(this).val()
                $('#errorCountry').empty()
                $('#influencersData').empty()
                $('.parentInfluencers').hide()
                $('#actionAddInfluencer').hide()
                $.ajax({
                    url:'{{route("dashboard.campaigns.get-influencers-by-country")}}',
                    type:'get',
                    data:{
                        '_token': '{{ csrf_token() }}' ,'country':country
                    },success:function(res){
                        if(res.data.length > 0){
                            $('.parentInfluencers').show()
                            $('#actionAddInfluencer').show()
                            res.data.forEach((item) => {
                                $('#influencersData').append(`<option value="${item.id}">${item.insta_uname}</opton>`)
                            })
                        }
                    },error:function (err){
                        if(err.responseJSON.errors.country){
                            $('#errorCountry').html(err.responseJSON.errors.country)
                        }
                    }
                })

            });

            //add influencers to campaign
            $(document).on('click','#actionAddInfluencer',function(){
                var campaignType = $('#campaignType').val()
                var campaignId = "{{$campaign->id}}";
                var brandId = "{{$brand->id}}";
                var influencsers = $('#influencersData').val();
                var countryType = $('#countryType').val();
                $('#errorInfluencers').empty()
                $.ajax({
                    url:'{{route("dashboard.campaigns.add-influencers-to-campaign")}}',
                    type:'post',
                    data:{
                        '_token': '{{ csrf_token() }}' ,'campaignType':campaignType, 'campaignId':campaignId
                        , 'brandId':brandId, 'influencsers':influencsers,'countryType':countryType
                    },success:function(res){
                        Swal.fire(
                            'success',
                            'Influerncers Inserted Successfully',
                            'success',
                        )
                        exampleTbl.ajax.reload()
                        $('#influencersData').empty()
                        $('.parentInfluencers').hide()
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
