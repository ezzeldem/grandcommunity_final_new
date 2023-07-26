@php
if (count($phonesNumbers) > 0) {
$editMode = true;
} else {
$editMode = false;
}
@endphp
<div class="phone_number_container"></div>

@push('js')

<script>
    let phonesNumbers = <?php echo json_encode($phonesNumbers); ?>;
    let typephone = <?php echo json_encode($typePhone); ?>;
    let countires = <?php echo json_encode($all_countries_data); ?>;

let phoneNumberContainer = $('.phone_number_container');
let phoneNumberWrapper = $(`
        <div class="inputs "
            style="display: flex;width: 100%;align-items: center;gap: 25px;margin-top: -7px;max-width: 100%;width: 100% !important;"
            min="0"></div>
    `);
let allPhones = $(`<div class="allPhones"></div>`);


function addPhoneNumberComponent(firstComponent = false) {

  if (phonesNumbers.length) {
    bulidPhoneNumber(allPhones, firstComponent);
  } else {
    allPhones.append(bulidPhoneNumberComponent(buildInputGroup(), firstComponent))
  }

  let addButton = $(`
         <div style="margin:10px 10px 0 10px;"><button type="button" id="add_phone_input" class="add_phone_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i></button></div>
    `);

  if (firstComponent) {
    phoneNumberWrapper.append(allPhones);
    phoneNumberWrapper.append(addButton);
    phoneNumberContainer.append(phoneNumberWrapper);
  }

}

function buildPhoneType(phoneNumberTypeId = null) {
  let select = $(`
        <select class="input-group-text" name="phone_type[]" data-placeholder="Type"
            style="width:200px;margin-top:2px;">
            <option value="" disabled selected>Select</option>
        </select>
    `);

  for (let type of typephone) {
    let option = $(
      `<option value="${type.id}" ${type.id == phoneNumberTypeId ? 'selected' : '' }></option>`);
    option.text(type.title);
    select.append(option);
  }
  return select;
}

function buildPhoneCode(phoneNumberCode = null) {
  let select = $(`
        <select class="input-group-text country_code " name="phone_code[]"
            data-placeholder="Code" style="width:200px;">
            <option></option>
        </select>
    `);

  for (let country of countires) {
    let option = $(`
                <option value="${country.phonecode}" data-flag="${country.code}" ${country.phonecode == phoneNumberCode ? 'selected' : ''}>(+)${country.phonecode}</option>
        `);
    select.append(option);
  }
  return select;
}

function buildInputNumberInput(phoneNumber = null) {
  return $(`
        <input style="width:200%;margin-top:2px;" value="${phoneNumber || '' }"
                    class="form-control phoneInput"
                    name="phone[]" min="0" placeholder="Enter Phone Number" type="text">
    `);
}

function bulidPhoneNumber(allPhones, firstComponent) {
  for (let phoneNumber of phonesNumbers) {
    let inputGroup = bulidPhoneNumberComponent(buildInputGroup(), firstComponent, phoneNumber.type, phoneNumber
      .code,
      phoneNumber.phone);
    allPhones.append(inputGroup);
    firstComponent = false;
  }
  phonesNumbers = [];
}

function buildInputGroup() {
  return $(`<div class="input-group-prepend mb-2 position-relative"></div>`);
}

function bulidPhoneNumberComponent(inputGroup, firstComponent, phoneNumberTypeId = null, phoneNumberCode = null,
  phoneNumber =
  null) {
  if (!firstComponent) {
    inputGroup.append(buildPhoneType(phoneNumberTypeId));
    inputGroup.append(buildPhoneCode(phoneNumberCode));
    inputGroup.append(buildInputNumberInput(phoneNumber));
    let removeButton = $(
      `<a href="javascript:void(0)" onClick="removebutton(this)" class="deleterr btn btn-danger mb-2 position-absolute" style="right: -20px;top: 4px;"><i class="fas fa-trash-alt"></i></a>`
    );
    inputGroup.append(removeButton);
  }
  return inputGroup;
}

function removebutton(select) {
  $(select).parent().remove();
}

addPhoneNumberComponent(true);


$('.add_phone_input').on('click', function() {
  addPhoneNumberComponent();
  selectCountry()
});
</script>

@endpush
