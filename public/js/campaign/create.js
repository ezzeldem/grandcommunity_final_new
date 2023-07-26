
function deleteBranch(e) {
    $(e).parents(".inputs").remove();
}

function toggleSecretsAndCompliments(){
    let type = $('#campaign_type').val()
    let secretContainer = $('#brand-secrets');
    let allComplimentInputsContainer = $('#all_compliment_inputs_container');
    if(type === "0" || type === "1" || type === "2"){
        secretContainer.show();
        allComplimentInputsContainer.show();
    }else{
        secretContainer.hide();
        allComplimentInputsContainer.hide();
    }
}

$(document).ready(function () {
    toggleSecretsAndCompliments();
    if(!$("#has_guest").val() || $("#has_guest").val() === "0"){
        $('#guest_numbers_dev').hide();
        $('#guest_numbers').val('');
    }

    $('body').on('change', '#has_guest', function (){
        if($("#has_guest").val() === "1"){
            $('#guest_numbers_dev').show();
        }else{
            $('#guest_numbers_dev').hide();
            $('#guest_numbers').val('');
        }
    })

    if (window.location.href.includes("brand")) {
        getsubBrands(window.location.href.split('?brand=')[1])
    }
    let camp_id = $('#campaign-form').data('camp-id')
    let brand_id = '', country_ids = [], sub_brand_id = '';
    let campaignCountries = $('#campaign-form').data('campaign-countries');
    var brandObject = $('.branchedList ').html();

    // get sub_brand and branches by brand id
    $(document).on('change', '#brand_id', function (event) {
        brand_id = event.target.value;
        getsubBrands(brand_id)
        getFavouritesList()
    })

    // get branches by sub_brand
    $(document).on('change', '#sub_brand_id', function (event) {
        sub_brand_id = event.target.value;
        var camp_sub_brand_id = $('#camp_sub_brand_id').val();
        let url = `/dashboard/get-sub-brands-branches/${sub_brand_id}`
        $.ajax({
            url: url,
            type: 'GET',
            data: { country_ids, camp_id },
            success: function (response) {
                if (response.status) {
                    let branches = response.data.branches;
                    if (sub_brand_id === camp_sub_brand_id) {
                        // $(".branchedList").html("").append(brandObject)
                        updateBranches(branches)
                    } else {
                        updateBranches(branches)
                    }

                }
            }
        })
        getFavouritesList();
    });
    $(document).ready(function () {
        $(".setup-content").hide();
        $("#step-1").show();
        if($('#compliment_type').val()){
            $('#compliment_branches_container').show();
        }else{
            $('#compliment_branches_container').hide();
        }
        toggleComplementInputs();

        // var navListItems = $('div.setup-panel div a'),
        //     allWells = $('.setup-content');
        //     allWells.hide();
        //
        // navListItems.click(function (e) {
        //     e.preventDefault();
        //     var $target = $($(this).attr('href')),
        //         $item = $(this);
        //     if (!$item.hasClass('disabled')) {
        //         navListItems.removeClass('btn-primary').addClass('btn-default');
        //         $item.addClass('btn-primary');
        //         allWells.hide();
        //         $target.show();
        //         $target.find('input:eq(0)').focus();
        //     }
        // });
        //
        //     $('div.setup-panel div a.btn-primary').trigger('click');
        });

    // get states by country id
    $(document).on('change', '#country_id', function (event) {
        $('[id^="state_id_"],[id^="city_id_"],[id^="list_id_"]').each((i, e) => {
            $(e.closest('[class^="col-"]')).css('display', 'none')
        })
        country_ids = $('#country_id').val();
        // $('#countries_list').parent().hide()
        $("#list_ids_select").html("");
        $("#list_ids_select").val('').trigger('change')
        if (!country_ids.length) {
            $('#brand-secrets').css('display', 'none')

        } else {
            let countries = $('#country_id').select2('data')
            //append secret campaigns temp
            // stop
            appendSecretsCampaignTemp(countries);
            brandSecretPermissions($('#campaign_type').val(), brand_id)
            //get stated and favourite list by ajax
        }
        getFavouritesList()
        getsubBrands(brand_id, false)
    })

    // update subBrand select
    function updateSubBrands(subBrands) {
        let sub = $("#sub_brand_id").val()
        // set branches
        $("#sub_brand_id").find('option').remove().end().append('<option label="Choose one" disabled selected></option>')
        $.each(subBrands, function (index, sub_brand) {
            $("#sub_brand_id").append(`<option value="${sub_brand.id}">${sub_brand.name}</option> `)
        });
        $(`#sub_brand_id`).select2({
            placeholder: "Select",
            allowClear: true,
        })
        if (sub && subBrands.findIndex(x => x.id == sub) > -1) {
            $("#sub_brand_id").val(sub)
            $("#sub_brand_id").trigger('change')
        }
        $("#sub_brand_id").parent().parent().show()
    }

    // update branches select
    function updateBranches(branches) {
        let bran = $("#branch_ids").val()
        // set branches
        $("#branch_ids").find('option').remove()//.end().append('<option label="Choose one" disabled selected></option>')
        $.each(branches, function (index, branch) {
            $("#branch_ids").append(`<option value="${branch.id}" data-voucher="${branch.has_voucher}">${branch.name}</option> `)
        });
        $(`#branch_ids`).select2({
            placeholder: "Select",
            allowClear: true,
        })
        if (bran.length) {
            $("#branch_ids").val(bran)
            $("#branch_ids").trigger('change')
        }
        $("#branch_ids").parent().parent().show()
        updateComplimentBranches();
        toggleComplementInputs();
    }
    // branches voucher

    $(document).on('change', '#has_voucher', function () {
        if ($(this).is(":checked")) {
            $(this).attr('value', 1);
            let branches = $('#branch_ids').select2('data')
            appendVoucherTemp(branches)
        } else {
            $('#voucher_block').hide();
            $('#voucher_block').children().remove();

        }
    })





    // $(document).on('change','#has_voucher',function (e){
    //     let branches = $('#branch_ids').select2('data')
    //     appendVoucherTemp(branches,$('#has_voucher').val())
    // })
    // branches voucher
    $(document).on('change', '#branch_ids', function (e) {
        // let branches = $('#branch_ids').select2('data')
        // if ($('#has_voucher').attr(':checked'))
        //     appendVoucherTemp(branches)
        updateComplimentBranches();
        toggleComplementInputs();
    })

    $(document).on('change', '#compliment_type', function (e) {
        updateComplimentBranches();
        toggleComplementInputs();
    })

    function toggleComplementInputs() {
        let complimentType = $('#compliment_type').val();
        if(complimentType === '1'){
           $('#voucher_inputs').show();
           $('#gift_inputs').hide();
        }else if(complimentType === '2'){
            $('#voucher_inputs').hide();
            $('#gift_inputs').show();
        }else if(complimentType === '3'){
            $('#voucher_inputs').show();
            $('#gift_inputs').show();
        }else{
            $('#voucher_inputs').hide();
            $('#gift_inputs').hide();
        }
    }

    function updateComplimentBranches() {
        let complimentBranches = $('#compliment_branches');
        complimentBranches.html('');
        if($('#compliment_type').val()){
            $('#compliment_branches_container').show();
        }else{
            $('#compliment_branches_container').hide();
        }
        let branches = $('#branch_ids').select2('data');
        let selectedBranchesWithCompliments = $('#selected_compliment_branches').val();
        let options = "";
        branches.forEach((item, i) => {
            let selectedAttr = selectedBranchesWithCompliments.includes(item.id)?"selected":"";
            options += `<option value=${item.id} ${selectedAttr}>${item.text}</option>`
        });

        complimentBranches.html(options);

        complimentBranches.select2({
             placeholder: "Select",
             allowClear: true,
        });
    }

    // append voucher temp
    function appendVoucherTemp(branches) {
        let has_voucher = $('#has_voucher').is(':checked');
        let temp = ``;
        let selectedListVouchers = $("#branches_has_vouchers_list").val()
        branches.forEach((item, i) => {
            let isVoucherChecked = selectedListVouchers.includes(item.id);
            temp += `
             <div class="col-lg-2 divvoucher_branches">
                        <div class="btn_container">
                            <span class="btn_label">${item.text}</span>
                            <div class="switch-container switch-ios">
                                <input type="checkbox" name="voucher_branches[]" id="voucher_branches_${i}" ${isVoucherChecked ? 'checked' : ''} class="voucher_switch" value="${item.id}"/>
                                <label for="voucher_branches_${i}" class="newchange"></label>
                            </div>
                        </div>

                    </div>`
        });
        if (Object.keys(branches).length && has_voucher == 1) {
            $('#voucher_block').show();
            $('#voucher_block').children().remove();
            $('#voucher_block').append(`
                <h5><i class="fas fa-link mt-3"></i> Branches voucher</h5>
                <hr>
                <div class="row ml-0">
                ${temp}
                 </div>
        `)
        } else {
            $('#voucher_block').hide();
            $('#voucher_block').children().remove();
        }
    }

    // append secrets campaign country
    function appendSecretsCampaignTemp(countries, storagedata = null) {
        console.log('the local storage is ready! ' + storagedata)
        let temp = ``;
        countries.forEach((item, i) => {

            if ($('#brand-secrets').children().find('.secret').data('id') == item.id) {
                temp += `
                <div class="row secrets card" style="border: 2px solid #06060642; padding:1rem">
                <div class="col-8 input-container _input__text">
                        <div class="form-group mg-b-0">
                            <label class="form-label">${item.text} secret: <span class="text-danger">*</span></label>
                            <input  type="text" name="secret[${item.id}]" class="form-control secret" data-id="${item.id}" value="${$('#brand-secrets').children().find('.secret').val()}" placeholder="Enter secret" id="secret_${item.id}" >
                        </div>
                    </div>
                    <div class="col-4 mt-4" >
                        <div class="form-group">
                            <button class="btn btn-success generate-secret"  type="button">generate secret</button>
                            <button class="btn btn-danger del-secret"  type="button" style="display: none"><i class="icon-trash-2"></i></button>
                        </div>
                    </div>

                    <div class="permissions group-checkbox-inputs mt-4">

                    </div>
                </div>
            `
            } else {
                temp += `
                <div class="row secrets card" style="border: 2px solid #06060642; padding:1rem">
                <div class="col-8 input-container _input__text">
                        <div class="form-group mg-b-0">
                            <label class="form-label">${item.text} secret: <span class="text-danger">*</span></label>
                            <input type="text" name="secret[${item.id}]" class="form-control secret" data-id="${item.id}" placeholder="Enter secret" id="secret_${item.id}" >
                        </div>
                    </div>
                    <div class="col-4 mt-4" >
                        <div class="form-group">
                            <button class="btn btn-success generate-secret"  type="button">generate secret</button>
                            <button class="btn btn-danger del-secret"  type="button" style="display: none"><i class="icon-trash-2"></i></button>
                        </div>
                    </div>
                    <div class="permissions group-checkbox-inputs mt-4">

                    </div>
                </div>
            `
            }

        });
        if (Object.keys(countries).length) {
            $('#brand-secrets').show();
            $('#brand-secrets').children().remove();
            $('#brand-secrets').append(`
                <h5><i class="fas fa-link"></i> campaign secrets</h5>
                <hr>
                <div class="clearfix"></div>
                ${temp}
            `)
            generateSecret();
        } else {
            $('#brand-secrets').hide();
            $('#brand-secrets').children().remove();
        }
    }

    //get stated and favourite list by ajax
    function getFavouritesList() {
        //country_ids, brand_id, campaignCountries = [], camp_id = null
        let country_ids = $('#country_id').val();
        let brand_id = $('#brand_id').val();
        let sub_brand_id = $('#sub_brand_id').val();
        let camp_id = $('#campaign-form').data('camp-id')
        let campaignCountries = $('#campaign-form').data('campaign-countries');
        $('#list_ids_select').html('')
        $('#countries_list').parent().hide()
        if (country_ids && country_ids.length && brand_id && sub_brand_id) {
            let url = `/dashboard/get-country-states`
            $.ajax({
                url: url,
                type: 'GET',
                data: { country_ids, brand_id, sub_brand_id, camp_id },
                success: function (response) {
                    if (response.status) {
                        select = document.getElementById('list_ids_select');
                        for (var i = 0; i< response.groups.length; i++){

                            var opt = document.createElement('option');
                            opt.value = response.groups[i].id;
                            opt.innerHTML = response.groups[i].name;
                            select.appendChild(opt);


                        }

                            // updateSubBrands(response.subbrands)
                            // updateBranches(response.branches)
                        // $('[id^="state_id_"]').select2();
                        $('#list_ids_select').val($('#list_ids_select').data("selected_ids"));
                        if (campaignCountries !== 'undefined' && campaignCountries && campaignCountries.length){
                            stateChangeEditMode(campaignCountries);
                        }
                        // stateChange();
                        $('[id^="list_id_"]').select2();
                        $('#countries_list').parent().show()
                    }
                }
            })
        }

    }

    // on campaign type changechange
    $(document).on('change', '#campaign_type', function (e) {
        let val = e.target.value;
        // clear and hide date inputs
        $('.date-input,.link-input').each((i, e) => {
            e.value = '';
            e.parentNode.parentNode.style.display = 'none';
        })
        toggleSecretsAndCompliments();
        // get brand secret permissions
        brandSecretPermissions(val, brand_id)
        // show date inputs
        showDates(val);
        // show  link coverage inputs
        showCoverageLinks(val);

        hideShowGuestsNumbers();
    })

    function hideShowGuestsNumbers(){
        let val = $("#campaign_type").val();
        if(val === "0" || val === "2"){
            $('#has_guest_container').show();
            $('#guest_numbers_container').show()
        }else{
            $('#has_guest_container').hide();
            $('#guest_numbers_container').hide();
        }
    }

    // get brand secret permissions
    function brandSecretPermissions(val, brand_id) {
        let inputsTemp = ``;
        $.ajax({
            url: '/dashboard/get-permission-by-type',
            type: 'GET',
            data: { type: val, camp_id },
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

    // show date inputs
    function showDates(val) {
        // let deliverInput = $('input[name^="deliver_"]');
            $('.campaign-dates-container').show();
        let visitContainer = $('.visit-dates-container');
        let deliverContainer = $('.deliver-dates-container');
        deliverContainer.children("div[class^='col-']").show()
        if (val === "0" || val === "3" || val === "4") {
            visitContainer.show();
            deliverContainer.hide();
        } else if (val === "1") {
            visitContainer.hide();
            deliverContainer.show();
        } else if (val === "2") {
            visitContainer.show();
            deliverContainer.show();
        }

        if(val === "2"){
            visitContainer.find('label:contains("Start Date")').text("Visit Start Date")
            visitContainer.find('label:contains("End Date")').text("Visit End Date")
            deliverContainer.find('label:contains("Start Date")').text("Delivery Start Date")
            deliverContainer.find('label:contains("End Date")').text("Delivery End Date")
        }else{
            visitContainer.find('label:contains("Start Date")').text("Start Date")
            visitContainer.find('label:contains("End Date")').text("End Date")
            deliverContainer.find('label:contains("Start Date")').text("Start Date")
            deliverContainer.find('label:contains("End Date")').text("End Date")
        }

    }

    // show link coverage inputs
    function showCoverageLinks(val) {
        if (val == 0) {
            $('input[name="visit_coverage"]').closest("div[class^='col-']").show();
            $('input[name="confirmation_link"]').closest("div[class^='col-']").show();
        } else if (val == 1) {
            $('input[name="delivery_coverage"]').closest("div[class^='col-']").show();
            $('input[name="confirmation_delivery_link"]').closest("div[class^='col-']").show();
        } else if (val == 2) {
            $('input[name="visit_coverage"]').closest("div[class^='col-']").show();
            $('input[name="delivery_coverage"]').closest("div[class^='col-']").show();
            $('input[name="confirmation_link"]').closest("div[class^='col-']").show();
            $('input[name="confirmation_delivery_link"]').closest("div[class^='col-']").show();

        }
    }

    //Add Data In LocalStorage For Create Campagin
    $("form").submit(function (e) {
        e.preventDefault();
        var values = $(this).serializeArray();
        values.forEach(function (item, index) {
            $("#submitted").append(item.name + "" + item.value + "<br>");
        })
        localStorage.setItem("form", JSON.stringify(values));
    })


    // var selected_country = []; //fixme::Whay this code that hide input values?
    // $(document).ready(function () {
    //     $('#brand_id').select2('destroy');
    //     // $('.check_list').prop('checked', true);
    //     var displayInfo = localStorage.getItem("form");
    //     var datainfo = JSON.parse(displayInfo);
    //     datainfo.forEach(function (item, index) {
    //         // console.log(item.name)
    //         if (item.name == 'country_id[]' && item.value != "") {
    //             selected_country.push(item.value);
    //         }
    //         if (item.name == 'chicklist[]' && item.value != "") {
    //             $("#campaign-form input[type ='checkbox'][value='" + item.value + "'][name='" + item.name + "']").prop('checked', true);
    //         }
    //
    //
    //         $("#campaign-form textarea[name='" + item.name + "']").val(item.value);
    //         $("#campaign-form input[type !='checkbox'][name='" + item.name + "']").val(item.value);
    //         $("#campaign-form select[name='" + item.name + "']").val(item.value);
    //         $("#campaign-form textarea[name='" + item.name + "']").val(item.value);
    //     })
    // }); //fixme::End Whay this code that hide input values?


    // // handle state change
    // function stateChange() {
    //     $('[id^="state_id_"]').on('change', function (event) {
    //         let state_id = event.target.value;
    //         let url = `/dashboard/get-state-city/${state_id}`
    //         let id_suffix = $(this).data('id-suffix')
    //         $.ajax({
    //             url: url,
    //             type: 'GET',
    //             success: function (response) {
    //                 if (response.status) {
    //                     let cities = response.cities;
    //                     $(`#city_id_${id_suffix}`).find('option').remove()
    //                     $.each(cities, function (index, city) {
    //                         $(`#city_id_${id_suffix}`).append(`
    //                                  <option value="${city.id}">${city.name}</option>
    //                             `)
    //                     });
    //                     $(`#city_id_${id_suffix}`).select2({
    //                         placeholder: "Select",
    //                         allowClear: true,
    //                     })
    //                     $(`#city_id_${id_suffix}`).parent().parent().show()
    //                 }
    //             }
    //         })

    //     });
    // }



    /////////////////////////////////////////////////////////////////////// edit mode /////////////////////////////

    // set brand_id in edit mode
    if ($('#brand_id').val()) {
        brand_id = $('#brand_id').val();
    }

    // when edit mode get campaign type
    if ($('#campaign_type').val()) {
        let val = $('#campaign_type').val();
        // get brand secret permissions
        brandSecretPermissions(val, brand_id);
        // show date inputs
        showDates(val);
        // show  link coverage inputs
        showCoverageLinks(val);
    }
    // set country_ids in edit mode
    if ($("#country_id").val()) {
        if ($('#campaign-form').attr('method') == 'put') {
            $("#country_id").closest('.col-lg-4').show()
        }
        let camp_id = $("#camp_id").val();
        // $("#country_id").show();
        country_ids = $("#country_id").val();
        $('#country_id').select2({
            // placeholder: "Select",
            width: '100px',
        });
        $('.select2-search__field').css('width', '100%');
        if ($('#campaign-form').attr('method') == 'post') {
            let countries = $('#country_id').select2('data')
            //append secret campaigns temp
            // stop
            appendSecretsCampaignTemp(countries);
        }
        //get stated and favourite list by ajax
    }

    $(function (){
        hideShowGuestsNumbers();
        getFavouritesList();
    });
    // reload states and cities and list_id in edit mode
    function stateChangeEditMode(campaignCountries) {
        $('[id^="state_id_"]').each((i, e) => {
            let state_id = campaignCountries[i].state_id;
            $(e).val(state_id).trigger('change');
            let url = `/dashboard/get-state-city/${state_id}`
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if (response.status) {
                        let city_id = campaignCountries[i].city_id;
                        let cities = response.cities;
                        $($(`[id^="city_id_"]`)[i]).find('option').remove()
                        $.each(cities, function (index, city) {
                            $($(`[id^="city_id_"]`)[i]).append(`
                                     <option value="${city.id}">${city.name}</option>
                                `)
                        });
                        $($(`[id^="city_id_"]`)[i]).select2({
                            placeholder: "Select",
                            allowClear: true,
                        })
                        $($(`[id^="city_id_"]`)[i]).parent().parent().show()
                        $($(`[id^="city_id_"]`)[i]).val(city_id).trigger('change');
                    }
                }
            })
        })

        $('[id^="list_id_"]').each((i, e) => {
            // var list_id = campaignCountries[i].list_id;
            // $(e).val(list_id).trigger('change');
            $(`#list_id_${campaignCountries[i].country_id}`).val(campaignCountries[i].list_id)
        })
    }

    //Generate Unique Password
    function generateSecret() {
        $('.generate-secret').click(function () {
            let self = this
            let url = '/dashboard/generate-unique-secret'
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if (response.status) {
                        let secret = response.secret;
                        $(self).closest('.row').find('.secret').val(secret);
                    }
                }
            })
        })
    }
    //Delete Unique Password
    function deleteSecret() {
        $('.del-secret').click(function () {
            if ($('.secrets').length > 1) {
                $(this).closest('.secrets').remove();
            }
        })
    }

    $(document).ready(function () {
        let cloneTimes = 0;
        $(`#brand_id,#campaign_type,#gender,#status, #objective_id`).select2({ placeholder: "Select", })
        generateSecret()
        $('.add-secret').click(function () {
            cloneTimes++;
            $('.secrets').first().clone()
                .find('input.secret').val('').end()
                .find('input.secret_permissions').attr('name', `permissions[${cloneTimes}][]`).end()
                .find('.del-secret').css('display', 'initial').end()
                .appendTo('#brand-secrets')
            generateSecret()
            deleteSecret()
        })
    })
    $(document).on('click', '#submit-campaign', function (e) {

        e.preventDefault();
        $(`.secrets`).each((index, e) => {
            $(e).find('input[name^="permissions"]').each((i, el) => {
                $(el).attr('name', `permissions[${index}][]`)
            })
        })
        $('#campaign-form').submit();
    })

    $('body').on('click', '.next-btn-step', function (e) {
        e.preventDefault();
        $('.invalid-feedback').remove();
        let btn = $(this);
        let step = btn.data('step');
        var form = $('#campaign-form');
        var formData = new FormData(form[0]);
        var url = form.attr('action')+"?step="+step;
        var method = form.attr('method');
        $.ajax({
            type: method,
            url: url,
            mimeType: 'application/json',
            dataType: 'json',
            data: formData,
            headers: {
                'X-CSRF-Token': $('[name=_token]').val(),
            },
            contentType: false,
            processData: false,
            success: function (data) {
                if(data.status === true && data.action === "submitted"){
                    window.location.href = data.url;
                }else{
                    toNextStep(Number(step))
                }
            }, error: function (data) {
                crud_handle_server_errors(data, form);
            }
        });
    });

    $('body').on('click', '.previous-btn-step', function (e) {
        let step = $(this).data('step');
        if(step > 1){
            $(".setup-content").hide();
            $("#step-"+(step-1)).show();
            $("#heading-step-"+step).removeClass("btn-primary");
            $("#heading-step-"+(step-1)).addClass("btn-primary");
            $('body, html, #heading-step-'+step).animate({scrollTop: 0}, 500);
        }
    });

    function toNextStep(step){
        if(step < 2){
            $(".setup-content").hide();
            $("#step-"+(step+1)).show();
            $("#heading-step-"+step).removeClass("btn-primary");
            $("#heading-step-"+(step+1)).addClass("btn-primary");
            $('body, html, #heading-step-'+step).animate({scrollTop: 0}, 500);
        }
    }

    // window.crud_handle_server_errors = function (data, form = null) {
    //     var statusCode = data.status;
    //     switch (statusCode) {
    //         case 422: // validation error.
    //             crud_handle_validation_errors(data, form);
    //             break;
    //         case 401: // Authentication error.
    //         case 500:
    //             alert('server error', 'danger');
    //             break;
    //         case 419: // .
    //             alert('CSRF Token mismatch', 'danger');
    //             break;
    //         case 419: // .
    //             alert('CSRF Token mismatch', 'danger');
    //             break;
    //         default: // unknown error
    //             alert('server error', 'danger');
    //     }
    // }
    //
    // window.crud_handle_validation_errors = function (data, form = null) {
    //     var keys = $.map(data.responseJSON.errors, function (value, key) {
    //         return value;
    //     });
    //     var errors = data.responseJSON.errors;
    //     $('input').removeClass('is-invalid');
    //     $('select').removeClass('is-invalid');
    //     $('.invalid-feedback').remove();
    //     $('.invalid-error').remove();
    //     $.each(errors, function (key, value) {
    //
    //         if (key == "coverage") {
    //             $(".customSwitch2").append(`
    //             <span style="color:#dc3545">The Coverage  field is required</span>
    //             `);
    //         }
    //
    //         if (key == 'voucher_branches') {
    //             $('.divvoucher_branches').append(`
    //                <span style="color:#dc3545">The voucher branches field is required</span>
    //                 ` )
    //
    //         }
    //
    //         if (key == 'influencer_per_day') {
    //             $('#influencer_per_day').after(`
    //             <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11"><li class="parsley-required">The daily Influencers must be less than Total influencers</li></ul>
    //             `)
    //         }
    //
    //
    //         if ($('[name="voucher_branches[]"]').checked == false) {
    //             alert(2);
    //         }
    //         else {
    //             if ($('[name="voucher_branches[]"]').checked == true) {
    //                 alert(1);
    //                 $('[name="voucher_branches[]"]').checked = false;
    //             }
    //         }
    //
    //
    //         ////////end added
    //
    //
    //
    //         var input = form != null ? form.find(':input[name="' + key + '"]') : $(':input[name="' + key + '"]');
    //         var select = form != null ? form.find('select[name="' + key + '"]') : $('select[name="' + key + '"]');
    //         if (input.length > 0) {
    //
    //
    //
    //             if (input.hasClass('datepicker')) {
    //                 input.addClass('is-invalid');
    //                 $(input).parent('div').find('div.input-group-append').next("span").remove();
    //                 input.parent('div').find('div.input-group-append').after("<span class='invalid-feedback' role='alert'><strong>" + value[0] + "</strong></span>");
    //             } else if (input.attr('type') == 'number') {
    //                 input.addClass('is-invalid');
    //                 $(input).next("span").remove();
    //                 input.after("<span class='invalid-feedback' role='alert'><strong>" + value[0] + "</strong></span>");
    //             } else {
    //                 input.addClass('is-invalid');
    //                 $(input).next("span").remove();
    //                 input.after("<span class='invalid-feedback' role='alert'><strong>" + value[0] + "</strong></span>");
    //             }
    //         } else {
    //             if (key.indexOf(".") > -1) {
    //                 var split_key = key.split(".");
    //                 var input_by_id = form.find('#' + split_key[0] + '_' + split_key[1]);
    //                 $("textarea[id='" + key + "']").addClass('is-invalid');
    //                 $("textarea[id='" + key + "']").parent('div').find('#invalid1').remove();
    //                 $("textarea[id='" + key + "']").after("<span class='invalid-feedback' id='invalid1' role='alert'><strong>" + value[0] + "</strong></span>");
    //
    //                 if (input_by_id.length > 0) {
    //
    //                     input_by_id.addClass('is-invalid');
    //                     $(input_by_id).parent('div').find('#invalid1').remove();
    //                     $(input_by_id).after("<span class='invalid-feedback' id='invalid1' role='alert'><strong>" + value[0] + "</strong></span>");
    //                 }
    //
    //
    //             } else {
    //                 console.log(3);
    //                 var input_by_id = form.find('#' + key);
    //                 if (input_by_id.length > 0) {
    //
    //                     // Secrets Inputs
    //                     input_by_id.addClass('is-invalid');
    //                     $(input_by_id).parent('div').find('#invalid1').remove();
    //                     //error countries
    //                     $(input_by_id).parent('div').find('span.select2').after("<span class='invalid-feedback' id='invalid_1' role='alert'><strong>" + value[0] + "</strong></span>");
    //                 } else {
    //
    //
    //
    //
    //
    //
    //
    //                     input_by_id.addClass('is-invalid');
    //                     $(input_by_id).parent('div').find('#invalid1').remove();
    //                     //error countries
    //                     $(input_by_id).parent('div').find('span.select2').after("<span class='invalid-feedback' id='invalid_1' role='alert'><strong>" + value[0] + "</strong></span>");
    //
    //
    //                     // Permissions && List_Ids
    //                     var input_by_id = form.find('[id^="' + key + '_"]');
    //                     if (input_by_id.length > 0) {
    //
    //                         $.each(input_by_id, function (index, item) {
    //                             //Countries List
    //                             if ($(item).val() == null) {
    //                                 $(item).parent('div').find('#invalid_list_' + (index + 1)).remove();
    //                                 $(item).after("<small><span class='text-danger invalid-error' id='invalid_list_" + (index + 1) + "' role='alert'><strong>" + value[0] + "</strong></span></small>");
    //                             } else {
    //                                 $(item).parent('div').find('#invalid_list_' + (index + 1)).remove();
    //                             }
    //                         })
    //                     } else {
    //                         var input_by_id = form.find('.permissions');
    //                         $.each(input_by_id, function (index, item) {
    //                             console.log(index, item)
    //                             //Countries List
    //                             if ($(item).find('[name^="permissions"]').is(':checked') == false) {
    //                                 $(item).parent('div').parent('div').find('#invalid_list_' + (index + 1)).remove();
    //                                 $(item).parent('div').after("<small><span class='text-danger invalid-error' id='invalid_list_" + (index + 1) + "' role='alert'><strong>" + value[0] + "</strong></span></small>");
    //                             } else {
    //
    //                                 $(item).parent('div').find('#invalid_list_' + (index + 1)).remove();
    //                             }
    //                         })
    //                     }
    //                     // $(input_by_id).each(function(item,i){
    //                     // });
    //                     // $(input_by_id).parent('div').find('#invalid1').remove();
    //                     // $(input_by_id).parent('div').after("<small><span class='text-danger' id='invalid1' role='alert'><strong>" + value[0] + "</strong></span></small>");
    //                 }
    //             }
    //         }
    //         if (select.length > 0) {
    //             $('select[name="' + key + '"]').removeClass('select2-hidden-accessible');
    //             select.addClass('is-invalid');
    //             $(select).next("span").remove();
    //             select.after("<span class='invalid-feedback' role='alert'><strong>" + value[0] + "</strong></span>");
    //         }
    //         window.scroll({ top: 0, left: 0, behavior: 'smooth' });
    //     });
    // }
    function getsubBrands(brand_id, loadCountry = true) {
        $('#sub_brand_id').html('');
        $('#branch_ids').html('');
        var countries_selected = []; //selected_country;
        if (countries_selected != "null") {
            var countss = countries_selected;

            $.map(countss, function (value, index) {
            });
        }

        let company_country_ids = $('#country_id').val();
        let company_sub_brand_id = $('#sub_brand_id').val();

        let url = `/dashboard/get-sub-brands/${brand_id}`
        $.ajax({
            url: url,
            type: 'GET',
            data: {company_country_ids, company_sub_brand_id},
            success: function (response) {
                if (response.status) {
                    // set sub brand
                    var camp_brand_id = $('#camp_brand_id').val();
                    let subBrands = response.data.subBrands;
                    let branches = response.data.branches
                    if (brand_id == camp_brand_id) {
                        $(".branchedList").html("").append(brandObject)
                        $("#sub_brand_id").find('option').remove().end().append('<option label="Select Sub brand" disabled selected></option>')
                        $.each(subBrands, function (index, subBrand) {
                            $("#sub_brand_id").append(`<option value="${subBrand.id}" >${subBrand.name}</option> `)
                        });

                        if(!loadCountry){
                            return true;
                        }
                        // set countries
                        let countries = response.data.countries;
                        $("#country_id").find('option').remove()//.end().append('<option label="Choose one" disabled selected></option>')

                            $.each(countries, function (index, country) {
                                $("#country_id").append(`<option value="${country.id}">${country.name}</option> `)
                            });

                    } else {

                        $("#sub_brand_id").find('option').remove().end().append('<option label="Select" disabled selected></option>')
                        $.each(subBrands, function (index, subBrand) {
                            $("#sub_brand_id").append(`<option value="${subBrand.id}" >${subBrand.name}</option> `)
                        });
                        $(`#sub_brand_id`).select2({ placeholder: "Select" })
                        $("#sub_brand_id").parent().parent().show()

                        // set baranch
                        updateBranches(branches)

                        if(!loadCountry){
                            return true;
                        }

                        // set countries
                        let countries = response.data.countries;
                        if (countries_selected) {
                            var countss = countries_selected;
                        }
                            $("#country_id").find('option').remove()//.end().append('<option label="Choose one" disabled selected></option>')

                            $.each(countries, function (index, country) {
                                $("#country_id").append(`<option  value="${country.id}"   ${(countss[index] == country.id) ? 'selected="selected"' : ""} >${country.name}</option> `)
                            });
                            $(`#country_id`).select2({
                                placeholder: "Select",
                                allowClear: true,
                            })
                        $("#country_id").parent().parent().show()
                    }
                }
                let countryie = $('#country_id').select2('data')
                appendSecretsCampaignTemp(countryie);
                brandSecretPermissions($('#campaign_type').val(), brand_id)
                country_ids = $('#country_id').val();
                if (!country_ids.length) {
                    $('#brand-secrets').css('display', 'none')
                    return 0;

                }
            }
        })
    }
})





