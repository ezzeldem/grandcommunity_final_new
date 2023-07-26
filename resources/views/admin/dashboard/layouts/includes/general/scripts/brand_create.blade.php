<script>

let code_phone_val = 0;
let subbrand_phone_val = 0;


//Toggle
$('.main-toggle').on('click', function() {
	$(this).toggleClass('on');
})

$("#switch-if-same-as-whatsapp").on('click', function() {
    hideShowWhatsappInput($(this).is(':checked'))
});

$(document).ready(function () {
    hideShowWhatsappInput($("#switch-if-same-as-whatsapp").is(':checked'), false)
});

function hideShowWhatsappInput(switchStatus, clear = true) {
    let whatsAppSection = $('#whatsappSection');
    if (!switchStatus) {
        $("#whatsappSection").show()
        if(clear){
            $("#whatsappSection input").val('')
            $('#whatsappSection select').val('').trigger('change');
        }else{
            $("#whatsappSection input").val(whatsAppSection.data('phone'))
            $('#whatsappSection select').val(whatsAppSection.data('code')).trigger('change');
        }
    } else {
        $("#whatsappSection input").val($('input[name="main_phone"]').val())
        $('#whatsappSection select').val($('select[name="main_phone_code"]').val()).trigger('change');
        $("#whatsappSection").hide()
    }
}

// /
// user_name
var i =1;
$("#add_phone_input").click(function(event){

	event.preventDefault()
	let selectData = `<div class="input-group-prepend custom-3""><select class="input-group-text country_code select2" id="country_code_${i}" name="phone_code[]" data-placeholder="Select Code" style="width:100px !important;"> <option></option>`
	@foreach($all_countries_data as $country)
		selectData+= '<option value="{{$country->phonecode}}" data-flag="{{$country->code}}" > (+){{$country->phonecode}} </option>'
	@endforeach

	$(".allPhones").append('<div class="inputs" style="display: flex;width: 100% !important;align-items: flex-start;justify-content:flex-start;margin-top: 10px">' +selectData +
		'</select> </div>  <input style="display:inline-block;margin-left: 12px;flex-basis: 80.5%;" min="0" class=" form-control phoneInput" onkeypress="diableChars(event)"  placeholder="Enter Phone" type="number" name="phone[]" >' +
		' <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn mb-2" >' +
		'<i class="fas fa-trash-alt"></i></a></div>');
	selectCountry()
	i = i+1;
});



$('.phoneInput').on('keypress', function (event) {
	diableChars(event)
});

function diableChars(event){
	var regex = new RegExp("^[0-9]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)  )  {
		event.preventDefault();
		return false;
	}
}



function deleteBranch(e) {
	$(e).parents(".inputs").remove();

	if($(e).children(".input-group-prepend")){
		$(e).children(".input-group-prepend").remove();
	}
	else
		$(e).parents(".inputs").children('.input-group-prepend').first().remove()
}

$(`#status,#office_id`).select2({
	placeholder: "Select",
	allowClear: true,
});
$(document).ready(function (){
$(':input[type="number"]').each(function () {
$(this).attr('min',0);
});
});
</script>
