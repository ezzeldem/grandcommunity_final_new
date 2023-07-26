<style>
.input-group-prepend {
  position: relative;
  margin-bottom: 28px;
}

.input-group-prepend .invalid-feedback {
  position: absolute;
  bottom: -18px;
  font-size: 12px;
}

.input-group-prepend .invalid-feedback~.invalid-feedback {

  bottom: -29px;
}
</style>

<div class="row row-sm create_form company_form">
  <div class="col-12">
    <div class="profile-avatar mb-5">
      <ul>
        <li> <img
            src="{{ old('image') ? asset('storage/' . old('image')) : ( isset($brand) && !empty($brand->image) ? $brand->image : '/assets/img/avatar_logo.png') }}"
            id="imgLogo" alt=""> </li>
        <li class="edit">
          <i class="far fa-edit"></i>
          <input type="file" name="image" id="inputFile" value="{{ old('fileReader') }}"
            class="@if ($errors->has('image')) parsley-error @endif" accept="image/x-png,image/gif,image/jpeg">
        </li>
        {{-- @error('image')
                    <span class="error-msg-input">{{ $message }}</span>
        @enderror --}}
      </ul>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-label">Company Name: <span class="text-danger">*</span></label>
      <input class="form-control  @if ($errors->has('name')) parsley-error @endif "
        value="{{ isset($brand) ? old('name', $brand->name) : old('name') }}" name="name" placeholder="Enter Name"
        type="text">
      {{-- @error('name')
                <span class="error-msg-input">{{ $message }}</span>
      @enderror --}}
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group" style="width: 100%;">
      <label class="form-label">Countries: <span class="text-danger">*</span></label>
      <select class="form-control @if ($errors->has('country_id')) parsley-error @endif" id="country_id"
        name="country_id[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"
        data-placeholder="Select One Or More" multiple>
        @foreach ($countries as $country)
        <option value="{{ $country->id }}"
          {{ isset($brand) && !empty($brand->country_id) && in_array($country->id, $brand->country_id) ? 'selected' : (collect(old('country_id'))->contains($country->id) ? 'selected' : '') }}>
          {{ $country->name }}
        </option>
        @endforeach
      </select>
      {{-- @error('country_id')
                <span class="error-msg-input">{{ $message }}</span>
      @enderror --}}
    </div>
  </div>

  <!-- <div class="col-xl-4 col-md-6 col-xs-12">
        <div class="form-group mg-b-0">
            <label class="form-label">Image:</label>
            <div class="custom-file">
                <input type="file" value="{{ old('fileReader') }}" name="image"
                    class="custom-file-input @if ($errors->has('image')) parsley-error @endif"
                    id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept="image/x-png,image/gif,image/jpeg">
                <label class="custom-file-label" for="inputGroupFile01">Select file</label>
            </div>
            @error('image')
                <span class="error-msg-input">{{ $message }}</span>
            @enderror
        </div>
    </div> -->


    <div class="col-12 col-md-6">
        <div class="form-group">
            <label class="form-label">Main Phone Number: <span class="text-danger">*</span></label>
            <div class="input-group-prepend">
                <select class="input-group-text country_code select2" name="main_phone_code" data-placeholder="Code"
                style="width:200px;">
                <option></option>
                @foreach ($all_countries_data as $country)
                <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}"
                    {{ isset($brand) && $brand->user->code == $country->phonecode ? 'selected' : (!empty(old('main_phone_code')) && old('main_phone_code') == $country->phonecode ? 'selected' : '') }}>
                    (+)
                    {{ $country->phonecode }}
                </option>
                @endforeach
                </select>
                <input style="width:200%;margin-top:3px;"
                class="form-control @if ($errors->has('main_phone')) parsley-error @endif"
                value="{{ isset($brand) ? $brand->user->phone : old('main_phone') }}" name="main_phone"
                placeholder="Enter Main Phone" type="number" id="main_phone">
            </div>
            {{-- @error('main_phone_code')
                        <span class="error-msg-input">{{ $message }}</span>
            @enderror
            @error('main_phone')
            <span class="error-msg-input">{{ $message }}</span>
            @enderror --}}
        </div>
        <!-- <div style="margin-top:10px;"><button type="button" id="add_phone_input"
            class="add_phone_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i>Add New</button>
        </div> -->
        <div class="main-toggle-group-demo" style="top:20px;">
            <div class="form-group">
                <div class="switch_parent">
                    <input type="checkbox" id="switch-if-same-as-whatsapp" class="switch_toggle togBtn" name="phone_same_as_whatsapp" value="1" @if(isset($brand) && !empty($brand->user->phone) && ($brand->whatsapp_code.$brand->whatsapp) == ($brand->user->code.$brand->user->phone)) checked @endif>
                    <label class="switch" for="switch-if-same-as-whatsapp" title="inactive"></label><span style="color:#A27929;margin:2px 0px 0px 3px;">whatsapp is the same as phone</span>
                </div>
            </div>
        </div>
    </div>


  <div class="col-12 col-md-6" id="whatsappSection"  data-phone="{{$brand->whatsapp??null}}" data-code="{{$brand->whatsapp_code??null}}">
    <div class="form-group">
      <label class="form-label">WhatsApp Phone Number: <span class="text-danger">*</span></label>
      <div class="input-group-prepend">
        <select class="input-group-text country_code select2" name="whatsapp_code" data-placeholder="Code" style="width:200px;">
          <option></option>
          @foreach ($all_countries_data as $country)
          <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}"
            {{ isset($brand) && $brand->whatsapp_code == $country->phonecode ? 'selected' : (!empty(old('whatsapp_code')) && old('whatsapp_code') == $country->phonecode ? 'selected' : '') }}>
            (+)
            {{ $country->phonecode }}
          </option>
          @endforeach
        </select>
        <input style="width:200%;margin-top:3px;"
          class="form-control phoneInput @if ($errors->has('whatsapp')) parsley-error @endif"
          value="{{ isset($brand) ? $brand->whatsapp : old('whatsapp') }}" name="whatsapp"
          placeholder="Enter WhatsApp Phone Number" type="number">
      </div>
      {{-- @error('whats_code')
                <span class="error-msg-input">{{ $message }}</span>
      @enderror
      @error('whatsapp')
      <span class="error-msg-input">{{ $message }}</span>
      @enderror --}}
    </div>
  </div>

  <div class="col-12">
    @php
    if(isset($brand)) {
    $phonesNumbers = $brand->InfluencerPhones;
    } else {
    $phonesNumbers = [];
    }
    $typePhone = $staticData['typePhone'];
    @endphp

    @include('admin.dashboard.layouts.includes.phones', [
    'phoneNumbers' => $phonesNumbers,
    'typePhone' => $typePhone
    ])
  </div>
  <!-- =================================== Phones ===============================-->

  <div class="clearfix"></div>
  <hr>
  <!-- =================================== Social Media ===============================-->

  <div class="col-md-6 social_media_card">
    <h5 class="mt-3"><i class="fas fa-link"></i> Social Media</h5>
    <div class="row allSocails">
      @php
      if(isset($brand)) {
      $socialMedia = $brand->socialMedia;
      } else {
      $socialMedia = [];
      }
      @endphp

      @include('admin.dashboard.layouts.includes.main_social_media', $socialMedia)
    </div>
</div>
<div class="col-md-6">
    <div style="margin-top:60px;"><button type="button" id="#add_social_input"
        class="#add_social_input btn seeMore hvr-sweep-to-right" onClick="addSocialMediaSelect();"><i
          class="fas fa-plus"></i></button></div>
</div>

<div class="col-md-6 mt-3">
  <div class="form-group">
    <label class="form-label">Website: </label>
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i
          style="color: #fff;" class="fas fa-globe"></i></span>
      <input class="form-control @if ($errors->has('website_uname')) parsley-error @endif"
        value="{{ isset($brand) ? $brand->website_uname : old('website_uname') }}" name="website_uname"
        placeholder="Enter Website URL" type="url">
    </div>
    {{-- @error('website_uname')
                    <span class="error-msg-input">{{ $message }}</span>
    @enderror --}}
  </div>
</div>


  <div class="col-12 social_media_card mt-2">
    <h5><i class="fas fa-link"></i> Authentication</h5>
    <hr>
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
          <label class="form-label">Username: <span class="text-danger">*</span></label>
          <input class="form-control @if ($errors->has('user_name')) parsley-error @endif"
            value="{{ isset($brand) ? $brand->user_name : old('user_name') }}" name="user_name"
            placeholder="Enter Username" type="text">
          {{-- @error('user_name')
                            <span class="error-msg-input">{{ $message }}</span>
          @enderror --}}
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
          <label class="form-label">Email: <span class="text-danger">*</span></label>
          <input class="form-control  @if ($errors->has('email')) parsley-error @endif"
            value="{{ isset($brand) ? $brand->email : old('email') }}" name="email" placeholder="Enter Email"
            type="email">
          {{-- @error('email')
                            <span class="error-msg-input">{{ $message }}</span>
          @enderror --}}
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
          <label class="form-label">Password: <span class="text-danger">*</span></label>
          <i class="fas fa-eye"></i>
          <input class="form-control @if ($errors->has('password')) parsley-error @endif" value="{{ old('password') }}"
            name="password" placeholder="Enter Password" type="password">
          {{-- @error('password')
                            <span class="error-msg-input">{{ $message }}</span>
          @enderror --}}
        </div>
      </div>

      <!-- <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Password Confirmation: <span class="text-danger">*</span></label>
                        <i class="fas fa-eye"></i>
                        <input class="form-control  @if ($errors->has('password_confirmation')) parsley-error @endif"
                            value="{{ old('password_confirmation') }}" name="password_confirmation"
                            placeholder="Re-enter Password" type="password">
                        @error('password_confirmation')
                            <span class="error-msg-input">{{ $message }}</span>
                        @enderror
                    </div>
                </div> -->

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group" style="width: 100%;">
          <label class="form-label">Status: <span class="text-danger">*</span></label>
          <select class="form-control select2 @if ($errors->has('status')) is-invalid @endif"
            value="{{ old('status') }}" id="status" name="status" data-parsley-class-handler="#slWrapper2"
            data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one">
          </select>
          {{-- @error('status')
                            <span class="error-msg-input">{{ $message }}</span>
          @enderror --}}
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
          <label class="form-label">Expiration Date: </label>
          <input class="form-control @if ($errors->has('expirations_date')) parsley-error @endif"
            value="{{ isset($brand) ? $brand->expirations_date : old('expirations_date') }}" name="expirations_date"
            placeholder="Enter Expiration Date" type="date" id="expire_date">
          {{-- @error('expirations_date')
                            <span class="error-msg-input">{{ $message }}</span>
          @enderror --}}
        </div>
      </div>

    </div>
  </div>
  <hr>

  <div class="col-12 text-right save"><button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10" type="submit"> <i
        class="far fa-save"></i> Save </button>
  </div>
</div>

@push('js')
<script src="{{ asset('js/curd.js') }}"></script>
<script>
$(function() {
  let countriesInSubBrands = "{{json_encode($countriesInSubBrands)}}";
  $('#country_id').select2({
    tags: true
  }).on("select2:unselecting", function(e) {
    // check if originalEvent.currentTarget.className is "select2-results__option" (in other words if it was raised by a item in the dropdown)
    if (countriesInSubBrands.includes(e.params.args.data.id)) {
      e.preventDefault();
      alert("You cannot remove this country because it's related to sub brands")
    }
  });
});
let brand = <?php if (isset($brand)) {
                    echo json_encode($brand);
                } else {
                    echo json_encode('');
                } ?>;

statusElmenetNode = document.querySelector("#status");
let statusObj = {};
if (brand) {
  statusName = getStatusNameByValue(brand.status);
  statusObj = checkAndGetStatus(statusName, statusObj);
  statusObj['current_status'] = buildOption(brand.status, statusName, true);
} else {
  statusObj = checkAndGetStatus("all", statusObj);
}

statusElmenetNode.innerHTML =
  `<option label="Select" disabled selected></option> ${Object.values(statusObj).join("")}`;
</script>
<script type="text/javascript">
$(function() {

  // var dtToday = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
  // var month = dtToday.getMonth() + 1;
  // var day = dtToday.getDate();
  // var year = dtToday.getFullYear();
  // if (month < 10)
  //   month = '0' + month.toString();
  // if (day < 10)
  //   day = '0' + day.toString();
  // var maxDate = year + '-' + month + '-' + day;
  // $('#expire_date').attr('min', maxDate);
  // var today = new Date().toISOString().split('T')[0];
  // document.getElementsByName("setTodaysDate")[0].setAttribute('min', today);
});
</script>
<script>
// clone and add btn delete
$(document).ready(function() {
  $(".add_phone_input").click(function() {
    $(".copy_phone__").eq(0).clone().insertAfter(".copy_phone__:last");
    $(".copy_phone__:last").append("<a class='remove'><i class='fas fa-trash-alt'></i></a>");
  });
  $(document).on("click", ".remove", function() {
    $(this).closest(".copy_phone__").remove();
  });
});
</script>
<script>
$(".copy_phone__ input").on('input', function(e) {
  $(this).val($(this).val().replace(/[^0-9]/g, ''));
});
</script>
<script>
//ShowPassword
$('.fa-eye').on('click', function(e) {
  input = $(this).parent().children('.form-control');
  inputType = input.attr('type');
  if (inputType == "password") {
    input.attr('type', 'text');
  } else {
    input.attr('type', 'password');
  }
});
</script>
<script>
$(function() {
  $("#inputFile").change(function() {
    readURL(this);
  });
});


function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      //alert(e.target.result);
      $('#imgLogo').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

// $( "input[type=checkbox]" ).click(function() {
//     // console.log("jhlkjhlkj")
//     $(".btn_sec").style("display" , "block")
// })

// function valueChanged()
//     {
//             if($('.switch_toggle').is(":checked"))
//                 $(".btn_sec").css("display" , "block")
//             else
//             $(".btn_sec").css("display" , "block")
//     }
</script>

@endpush
