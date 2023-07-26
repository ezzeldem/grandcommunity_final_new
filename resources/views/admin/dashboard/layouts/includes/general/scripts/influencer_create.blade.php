<script src="https://unpkg.com/bootstrap-multiselect@0.9.13/dist/js/bootstrap-multiselect.js"></script>
<script>
	$('#status_infl').on('change', function() {
        $(".databindOnlyDelivery").hide();
        var selected = [];
        valuesele = $('#status_infl').find(":selected").val();
        if (valuesele == 7) {
            $(".databindOnlyDelivery").show();

        }
    });
    /////////////////////
    $('#category_id').on('change', function() {
        for (var option of document.getElementById('category_id').options) {
            option.removeAttribute('disabled');
        }
        var selected = [];
        for (var option of document.getElementById('category_id').options) {
            if (option.selected) {
                selected.push(option.value);
            }
            console.log(selected)
        }
        if (selected.includes("7") || selected.includes("8")) {
            if (selected.includes("9") || selected.includes("10") || selected.includes("11") || selected.includes("12")) {
                for (var option of document.getElementById('category_id').options) {
                    option.setAttribute('disabled', true);
                }
            }
        }
    });
    // $('#chkveg').on('change', function() {

    //     var id = $(this).find(':selected').attr('id');
    //     console.log('sele_' + id);
    //     if (id) {
    //         var ele = $('#' + 'sele_' + id).hide()
    //         console.log(ele)
    //     }

    // });


    // $(function() {

    //     $('#chkveg').multiselect({
    //         allSelectedText: 'All Classification Already Selected',
    //         numberDisplayed: 10,
    //     });
    // });

    function removeSpaces(string) {
        return string.split(' ').join('');
    }


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

    function diableChars(event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }

    $('.phoneInput').on('keypress', function(event) {
        diableChars(event)
    });
    var i = 1;
    {{--$("#add_phone_input").click(function(event) {--}}
    {{--    event.preventDefault()--}}
    {{--    let selectData =--}}
    {{--        `<div class="input-group-prepend type_phone_div custom-2 col-5">--}}

    {{--                <div class="type_phone" style="padding: 0.2rem 0rem;">--}}
    {{--                <select class="input-group-text" name="phone_type[]" id="phone_type_${i}" data-placeholder="Code" style="width:145px;" placeholder="select">--}}
    {{--                    <option value="" disabled selected>Select</option>--}}
    {{--                    @foreach ($staticData['typePhone'] as $key => $typephone)--}}
    {{--                    selectData +=--}}
    {{--                     '<option value="{{ $typephone['id'] }}">{{ $typephone['title'] }} </option>'--}}
    {{--                    @endforeach--}}
    {{--                    selectData +--}}
    {{--                </select>--}}
    {{--              </div>--}}

    {{--                <select class="input-group-text country_code select2" id="country_code_${i}" name="phone_code[]" data-placeholder="Code" style="width:800px;"> <option></option>`--}}
    {{--    @foreach($all_countries_data as $country)--}}
    {{--    selectData +=--}}
    {{--        '<option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" > (+){{ $country->phonecode }} </option>'--}}
    {{--    @endforeach--}}
    {{--    $(".allPhones").append(--}}
    {{--        '<div class="inputs inputs-margin" style="display: flex;width: 60% !important;align-items: flex-start;justify-content:flex-start;gap: 25px;margin-top: 10px">' +--}}
    {{--        selectData +--}}
    {{--        '</select> </div>  <input style="display:inline-block;margin-left: 12px;flex-basis: 80.5%;" min="0" class=" form-control phoneInput" onkeypress="diableChars(event)"  placeholder="Enter Phone Number" type="number" name="phone[]" >' +--}}
    {{--        ' <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn btn-danger" >' +--}}
    {{--        '<i class="fas fa-trash-alt" style="margin:0rem !important"></i></a></div>');--}}
    {{--    selectCountry()--}}
    {{--    i = i + 1;--}}
    {{--});--}}


    function deleteBranch(e) {
        $(e).parents(".inputs").remove();
        if ($(e).children(".input-group-prepend"))
            $(e).children(".input-group-prepend").remove();
        else
            $(e).parents(".inputs").children('.input-group-prepend').first().remove()
    }
    $('.select2').select2({
        placeholder: "Select",
        allowClear: true,

    });

    function socialType(type) {
        $("#children_num").val('')
        $("#childrenContainer .row").html('')
        if (type != 1) {
            $("#children_num").parent().slideDown(500)
        } else {
            $("#children_num").parent().slideUp(500)
        }
    }

    function childrenContainer(numberOfChildren) {

        for (let children = 0; children < numberOfChildren; children++) {

            $("#childrenContainer").append(`
                    <div class="row">

                    <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="child_name">Children Name  <span class="text-danger">*</span> </label>
                                    <input type="text" name="childname[`+children+`]" placeholder="Children Name " class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="DOB">Children Date Of Birth  <span class="text-danger">*</span> </label>
                                    <input type="date" name="childdob[`+children+`]" class="form-control"  max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" >
                                </div>
                                <div class="col-md-4" >
                                    <label for="gender" style="display:block">Children Gender  <span class="text-danger">*</span> </label>
                                    <select class="input-group-text childrenGender select2" placeholder="Children Type" name="childgender[`+children+`]">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
        }
    }
    $("#children_num").off().on('input', function(event) {

        $("#childrenContainer").html('')
        event.preventDefault()
        let numberOfChildren = event.target.value;
        childrenContainer(numberOfChildren)
        $(".childrenGender").select2({
            // allowClear: true,
            placeholder: "Select Children Gender "
        });
    })
    $(document).on('change', '#influencer_gender', function() {
        let val_gander = $(this).val();
        $('.socialRadioType').each(function(i, element) {
            if (val_gander == 1) {
                if ($(element).attr('data-type') == 4) {
                    $(element).parent().hide()
                } else if ($(element).attr('data-type') == 3) {
                    $(element).parent().show()
                }
            } else {
                if ($(element).attr('data-type') == 3) {
                    $(element).parent().hide()
                } else if ($(element).attr('data-type') == 4) {
                    $(element).parent().show()
                }
            }
        })

    });


	var platforms = [];
            var platforms = ['insta', 'facebook', 'twitter',  'snapchat', 'tiktok'];
            var selected_value = [];
            var html = '';
            $.each(platforms, function(index, value) {
                html += '<option value=' + value + '>' + value + '</option>'
            });
            $('.social_media').on('change',function(){
                html = '';
                   var foo = [];
                    $('.selectappend :selected').each(function(i, selected){
                        foo[i] = $(selected).val();
                       });

                      platforms = platforms.filter(val => !foo.includes(val));
                      $.each(platforms, function(index, value) {
                      html += '<option value=' + value + '>' + value + '</option>'
                      });
                 var  slectedvalue = $(this).val()
                 $('.inputsocial').attr('name',slectedvalue+'_uname')
                 $('.inputsocial').attr('placeholder',slectedvalue)
            });



            $('.social_media').append(html);
            var counter = 0;
            $('.add_social_input').on('click',function(){
                   counter++;
                   html = '';
                   var foo = [];
                    $('.selectappend :selected').each(function(i, selected){
                        foo[i] = $(selected).val();
                       });
                      platforms = platforms.filter(val => !foo.includes(val));
                      $.each(platforms, function(index, value) {
                      html += '<option value=' + value + '>' + value + '</option>'
                      });
                      if(platforms.length && counter < 5){
                      var myselect = $(`
                      <div class="col-xl-4 col-lg-6  col-md-6 col-xs-6 add-closest">

                              <label class="form-label">Social Media <span class="text-danger">*</span></label>
                              <div class="form formgroupsocialMedia" style=" display: flex; align-items: stretch;" title="" id="formgroupsocialMedia">
                                    <select name="platforms[]" class="form-control parsley-error selectappend"  onchange="appendvalues(this)" id="social_media" name="social_media" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                        <option value="" selected disabled>Select</option>
                                        ${html}
                                    </select>
                                        @error('social_media')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    <input type="text" style=" flex: 1 1 auto; min-width: 70%; background: aliceblue; " id="inputselect"  class="form-control inputselect">
                                    <button class="remove_main_channel"> <i class="fas fa-trash-alt"></i> </button>
                                    </div>
                                </div>
                            `)
                          $('.allSocails').append(myselect)
                          $(document).on("click", ".remove_main_channel", function() {
                              $(this).closest(".add-closest").remove();
                              counter = 0
                          });
                        }
            });


                    function appendvalues(ele){
                      var elem =   $(ele).closest('.formgroupsocialMedia').children('.inputselect');
                      var main =   $(ele).closest('.formgroupsocialMedia').children('.main_chan');
                      var inputval = $(ele).val();
                      elem.attr('name',inputval+'_uname')
                      elem.attr('placeholder',inputval)
                    }


            $(".databindOnlyDelivery").hide();


</script>
