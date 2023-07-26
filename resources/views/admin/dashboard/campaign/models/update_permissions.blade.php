<div class="modal fade effect-newspaper show " id="secrets_permissions_modal" tabindex="-1" role="dialog"
     aria-labelledby="secrets_permissions_modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 850px;">
        <form action="{{route('dashboard.campaigns.updateCampaignSecretKeys', ['campaign_id' => $campaign->id])}}" id="update_campaign_secrets_form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title">
                    Generate Secret Keys
                </h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    @if (isset($secrets))

                        <div class="col-md-12 mt-4 secret-container" id="brand-secrets">
                            {{-- <button class="btn btn-warning float-right add-secret" type="button">Add secret</button> --}}
                            <div class="clearfix"></div>

                            {{-- @if (isset($secrets)) --}}

                            @forelse($secrets as $secret)
                                <div class="row secrets secret-row"
                                     data-county-id="{{ @$secret->campaignCountry->country_id }}">
                                    <div class="col-8">
                                        <div class="form-group mg-b-0">
                                            <label class="form-label">{{ @$secret->campaignCountry->country->name }}
                                                secret: <span class="text-danger">*</span></label>
                                            {!! Form::text('secret[' . @$secret->campaignCountry->country_id . ']', $secret->secret, [
                                                'data-id' => $secret->campaignCountry->country_id,
                                                'class' => 'form-control secret ' . ($errors->has('secret') ? 'parsley-error' : null),
                                                'placeholder' => 'Enter secret',
                                                'id' => 'secret_' . $secret->campaignCountry->country_id,
                                            ]) !!}

                                            @error('secret')
                                            <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4 mt-4">
                                        <div class="form-group">
                                            <button class="grand-add-button" type="button">generate
                                                secret
                                            </button>
                                            <button class="grand-add-close" type="button"
                                                    style="display: none"><i class="icon-trash-2"></i></button>
                                        </div>
                                    </div>
                                    <div class="permissions mt-4 group-checkbox-inputs">

                                    </div>
                                </div>

                            @empty
                                @foreach ($campaign->campaignCountries as $country)
                                    <div class="row secrets secret-row" data-county-id="{{ @$country }}">
                                        <div class="col-8">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label">{{ @$country->country->name }}
                                                    secret: <span class="text-danger">*</span></label>
                                                {!! Form::text('secret[' . @$country->country_id . ']', null, [
                                                    'data-id' => $country->country_id,
                                                    'class' => 'form-control secret ' . ($errors->has('secret') ? 'parsley-error' : null),
                                                    'placeholder' => 'Enter secret',
                                                    'id' => 'secret_' . $country->country_id,
                                                ]) !!}

                                                @error('secret')
                                                <ul class="parsley-errors-list filled  text-danger"
                                                    id="parsley-id-11">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <div class="form-group">
                                                <button class="btn btn-success generate-secret"
                                                        type="button">generate secret
                                                </button>
                                                <button class="btn btn-danger del-secret" type="button"
                                                        style="display: none"><i class="icon-trash-2"></i></button>
                                            </div>
                                        </div>
                                        <div class="permissions mt-4 group-checkbox-inputs">

                                        </div>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    @else
                        <div class="col-12 mt-4" id="brand-secrets" style="display: none">

                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer" style="justify-content: center !important;">
                <div class="btn">
                    <button type="button" class="btn update-campaign-form-btn" data-action="{{route('dashboard.campaigns.updateCampaignSecretKeys', ['campaign_id' => $campaign->id])}}" data-form="#update_campaign_secrets_form">Save</button>
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@push('js')
    <script>
        //fixme::hide secret with campaign type

        // $(`.secrets`).each((index, e) => {
        //     $(e).find('input[name^="permissions"]').each((i, el) => {
        //         $(el).attr('name', `permissions[${index}][]`)
        //     })
        // })



        $('.generate-secret').on('click', function () {
            let btn = $(this)
            let url = '/dashboard/generate-unique-secret'
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if (response.status) {
                        let secret = response.secret;
                        btn.closest('.secret-row').find('.secret').val(secret);
                    }
                }
            })
        })

        // get brand secret permissions
        function brandSecretPermissions() {
            let inputsTemp = ``;
            $.ajax({
                url: '/dashboard/get-permission-by-type',
                type: 'GET',
                data: { type: Number("{{$campaign->campaign_type}}"), camp_id: Number("{{$campaign->id}}") },
                success: function (response) {
                    $('#brand-secrets').find('.secrets').each((i, e) => {
                        $(e).find('.permissions').children().remove();
                    });
                    response.data.forEach((item) => {
                        $('#brand-secrets').find('.secrets').each((i, e) => {
                            if (response.secrets_permissions) {
                                let dataSet = response.secrets_permissions[i];
                                if (dataSet) {
                                    let country_exists = dataSet['campaign_country']['country_id'] == $(e).data('county-id');
                                    if (country_exists) {
                                        item.checked = (dataSet['permissions'].findIndex(x => x.id == item.id) > -1) ? true : false;
                                    } else {
                                        item.checked = false
                                    }
                                } else {
                                    item.checked = false
                                }
                            }

                            inputsTemp = `
                        <label class="button" required>
                            <input class="sr-only secret_permissions"  id="permission_${item.id}" type="checkbox"  name="permissions[${i}][]" ${(item.checked == true) ? 'checked' : ''}  value="${item.id}"/>
                            <span>${item.name}</span>
                        </label>`;
                            $(e).find('.permissions').append(inputsTemp);
                        })
                    })

                }
            })
        }

        // //Generate Unique Password
        // function generateSecret() {
        //     $('.generate-secret').click(function () {
        //         let self = this
        //         let url = '/dashboard/generate-unique-secret'
        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             success: function (response) {
        //                 if (response.status) {
        //                     let secret = response.secret;
        //                     $(self).closest('.row').find('.secret').val(secret);
        //                 }
        //             }
        //         })
        //     })
        // }
        // //Delete Unique Password
        // function deleteSecret() {
        //     $('.del-secret').click(function () {
        //         if ($('.secrets').length > 1) {
        //             $(this).closest('.secrets').remove();
        //         }
        //     })
        // }

        $(document).ready(function () {
            brandSecretPermissions();
            // generateSecret()
        })


    </script>
@endpush
