
<style>
.multiselect {
    width: 200px;
}

.selectBox {
    position: relative;
}

.selectBox select {
    width: 100%;
    font-weight: bold;
}

.overSelect {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
}

#checkboxes {
    display: none;
    border: 1px #dadada solid;
}

#checkboxes label {
    display: block;
}

#checkboxes label:hover {
    background-color: #1e90ff;
}
</style>


<div class="modal fade" id="edit_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Edit Influencer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="hidden" type="hidden" id="influe_all_id" name="influe_all_id" value=''>
                <div class="row">

                        {{-- <div class="form-group">
                            <label class="form-label">Type</label>
                            <select class="form-control select2" data-placeholder="Chose number" data-allow-clear="true"  multiple="multiple" name="bulk_status" id="bulk_status" >
                                       @foreach($status as $stat)
                                            @if($stat->value !=0)
                                            <option value="{{$stat->value}}" {{ (collect(old('status'))->contains($stat->value)) ? 'selected':'' }}>{{$stat->name}}</option>
                                            @endif
                                        @endforeach
                            </select>

                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Country: </label>
                                <select class="form-control  @if ($errors->has('country_id')) parsley-error @endif"
                                    id="country_id" name="country_id" data-parsley-class-handler="#slWrapper2"
                                    data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                    @if (empty(old('country_id')))
                                        <option disabled selected> Select</option>
                                    @endif
                                    @foreach ($all_countries_data as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>






                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Government: </label>
                            <select class="form-control  @if ($errors->has('state_id')) parsley-error @endif"
                                disabled id="state_id" name="state_id" data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2">
                            </select>
                            @error('state_id')
                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 city">
                        <div class="form-group">
                            <label class="form-label">City: </label>

                            <select class="form-control  @if ($errors->has('city_id')) parsley-error @endif"
                                disabled id="city_id" name="city_id" data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2">

                            </select>
                            @error('city_id')
                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Status: <span class="text-danger">*</span></label>
                            <select class="form-control " id="bulk_active"  name="bulk_active" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                <option value="2"> InActive </option>
                                <option value="1"> Active </option>
                                <option value="0"> Pending </option>
                                <option value="3"> Rejected </option>
                                <option value="4"> Blocked </option>
                                <option value="5"> No Response </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Expiration Date: <span class="text-danger">*</span></label>
                            <input class="form-control" name="bulk_expirations_date" id="bulk_expirations_date" placeholder="Enter Date" type="date"  min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Gender: </label>
                            <select id="influencer_gender"
                                class="form-control select2 @if ($errors->has('gender')) parsley-error @endif"
                                value="{{ old('gender') }}" name="gender"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                <option label="Select" disabled selected>
                                </option>
                                <option value=1 {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                                <option value=0 {{ old('gender') == '0' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Interests: </label>
                            <select
                                class="form-control select2 @if ($errors->has('interest')) parsley-error @endif"
                                multiple name="interest[]" id="interest"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2"
                                data-placeholder="Select One Or More">
                                @foreach ($interests as $interest)
                                    <option value={{ $interest->id }}
                                        {{ collect(old('interest'))->contains($interest->id) ? 'selected' : '' }}>
                                        {{ $interest->interest }}</option>
                                @endforeach
                            </select>
                            @error('interest')
                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Select Classification: </label>
                            <select
                                class="form-control select2 @if ($errors->has('classification')) parsley-error @endif"
                                multiple name="classification_ids[]" id="classification"
                                data-parsley-class-handler="#slWrapper2"
                                data-parsley-errors-container="#slErrorContainer2"
                                data-placeholder="Select One Or More">
                                @inject('allStatus','App\Models\InfluencerClassification' )
                                @php
                                    $status = $allStatus->get();
                                @endphp

                                @foreach ($status as $stat)
                                @if($stat->status == 'classification')
                                    <option value={{ $stat->id }}
                                        {{ collect(old('classification'))->contains($stat->id) ? 'selected' : '' }}>
                                        {{ $stat->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('classification')
                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right"
                        data-dismiss="modal">Close</button>
                <button type="button" id="submit_edit_all" class="btn Active hvr-sweep-to-right">Edit</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
$(document).ready(function(){
    $('#state_id').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#interest').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#country_id').select2({
            placeholder: "Select",
            allowClear: true,

        });
        $('#city_id').select2({
            placeholder: "Select",
            allowClear: true,

        });
});


function selectCountry() {
            $('.country_code').select2({
                placeholder: "🌍 Global",
                allowClear: true,
                templateResult: function(item) {
                    return format(item, false);
                },
                templateSelection: function(state) {
                    return formatState(state, false);
                },
            });
        }
        selectCountry()

        if ($("#country_id").val()) {
            getStateData($("#country_id").val())
            @if (!empty(old('state_id')))
                getCity("{{ old('state_id') }}")
            @endif

        } else if ($("#state_id").val()) {
            getCity("{{ old('state_id') }}")
        }

        $("#country_id").change(function() {
            getStateData($(this).val())
            $('#city_id').html('');
        });
        $("#state_id").change(function() {
            getCity($(this).val())
        });


        function getStateData(val) {
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "/dashboard/state/" + val,
                corssDomain: true,
                dataType: "json",
                success: function(data) {
                    //$('.state').show()
                    $('#state_id').prop('disabled', false);
                    var listItems = ""
                    @if (empty(old('state_id')))
                        listItems = "<option value=''>Select </option>";
                    @endif
                    $.each(data.data, function(key, value) {
                        let oldState = null
                        @if (!empty(old('state_id')))
                            oldState = "{{ old('state_id') }}"
                            if (oldState == value.id)
                                listItems += "<option value='" + value.id + "' selected >" + value
                                .name + "</option>";
                            else
                                listItems += "<option value='" + value.id + "'>" + value.name +
                                "</option>";
                        @else
                            listItems += "<option value='" + value.id + "' >" + value.name +
                                "</option>";
                        @endif
                    });
                    $("#state_id").html(listItems);
                },

                error: function(data) {

                }
            });
        }



function getCity(val) {
            log = console.log;
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "/dashboard/city/" + val,
                corssDomain: true,
                dataType: "json",
                success: function(data) {


                    $('#city_id').prop('disabled', false);
                    var listItems = "";
                    @if (empty(old('city_id')))
                        listItems = "<option value=''>Select City </option>";
                    @endif
                    $.each(data.data, function(id, name) {
                        let oldCity = null
                        @if (!empty(old('city_id')))
                            oldCity = "{{ old('city_id') }}"
                            if (oldCity == id)
                                listItems += "<option value='" + id + "' selected >" + name +
                                "</option>";
                            else
                                listItems += "<option value='" + id + "'>" + name + "</option>";
                        @else
                            listItems += "<option value='" + id + "'>" + name + "</option>";
                        @endif
                    });
                    $("#city_id").html(listItems);
                },

                error: function(data) {

                }
            });
        }

var classification_ids = [];

$("input[name='classification_ids[]']").change(function() {
var checked = $(this).val();
console.log(checked)
  if ($(this).is(':checked')) {
    classification_ids.push(checked);
  }else{
    classification_ids.splice($.inArray(checked, classification_ids),1);
  }
});

  var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
        $(document).on('click','#submit_edit_all',function (){
            let selected_ids =  $('input[id="influe_all_id"]').val();
            let bulk_status =  $('#bulk_status').val();
            let bulk_active =  $('#bulk_active').val();
            let bulk_country =  $('#country_id').val();
            let bulk_governorate =  $('#state_id').val();
            let bulk_city =  $('#city_id').val();
            let bulk_gender =  $('#influencer_gender').val();
            let bulk_interests =  $('#interest').val();
            let bulk_classification = $('#classification').val();


            let bulk_expirations_date =  $('#bulk_expirations_date').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.influe_edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_status:bulk_status,bulk_expirations_date:bulk_expirations_date,bulk_classification:bulk_classification,bulk_country:bulk_country,bulk_governorate:bulk_governorate,bulk_city:bulk_city,bulk_gender:bulk_gender,bulk_interests:bulk_interests},
                    dataType: 'json',
                    success: function (data) {
                        if(data.status){
                            $('#edit_all').modal('hide')
                            $("#bulk_status").val("").trigger("change")
                            $("#bulk_active").val("").trigger("change")
                            $("#classification_ids").val("").trigger("change")
                            $("#bulk_expirations_date").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            window.location = window.location;
                        }else{
                            Swal.fire('warning', data.message,'warning')
                        }

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

        });
    </script>
@endpush
