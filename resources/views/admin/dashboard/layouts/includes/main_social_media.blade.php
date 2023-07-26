<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let button = document.getElementById('#add_social_input');
    let $socialMedia = <?php echo json_encode($socialMedia); ?>;

    let socialMediaMap = {};
    $socialMedia.forEach((social) => {
        socialMediaMap[social.key] = social[`${social.key}_value`];
    });

    const container = $(".social_media_container");
    const AddSelect = $("#add_social_media");
    const socialMedias = ["instagram", "facebook", "twitter", "snapchat", "tiktok"];
    let remainingSocialMedias = socialMedias.slice();
    let prevSelect = null;
    let oldSocials = $socialMedia.map((social) => social.key);

    function addSocialMediaSelect(editPage = false) {
        let currentSocialName = "";
        let currentSocialValue = "";
        if (!remainingSocialMedias.length) {
            return;
        }

        if (editPage) {
            currentSocialName = remainingSocialMedias[0];
            currentSocialValue = socialMediaMap[currentSocialName];
        }
        const colDiv = $(`<div class="col-12"></div>`);
        const selectContainer = $(`
            <div class="form formgroupsocialMedia" style=" display: flex; align-items: stretch; position: relative; "></div>
         `);

        const select = $(`
                <select onChange='changeSelect(this);' name="platforms[]" class="form-control parsley-error #social_media selectappend"
                            name="social_media" data-parsley-class-handler="#slWrapper2"
                            data-parsley-errors-container="#slErrorContainer2">
                </select>
        `);
        $('.allSocails').append(colDiv);
        let visiblity = "";
        if (socialMedias.length === remainingSocialMedias.length) {
            visiblity = "visible";
        } else {
            visiblity = "invisible";
        }
        colDiv.append(`<label class="form-label ${visiblity}">Social Media <span class="text-danger">*</span></label>`);
        colDiv.append(selectContainer);
        selectContainer.append(select);


        for (let i = 0; i < remainingSocialMedias.length; i++) {
            const option = $(`<option value=${remainingSocialMedias[i]}></option>`);
            option.text(remainingSocialMedias[i]);
            select.append(option);
        }
        remainingSocialMedias.splice(0, 1);
        const inputSocial = $(
            `<input type="text" style=" flex: 1 1 auto; min-width: 70%; background: aliceblue; "
                    class="form-control inputsocial" name="social[][${select.val()}]" value = ${currentSocialValue}>`
        );
        selectContainer.append(inputSocial)
        if (prevSelect) {
            selectContainer.append(`
                <a href="javascript:void(0)" onClick='removeSelect(this.previousElementSibling.previousElementSibling);' class="deleterr btn btn-danger mb-2" style="position:relative; right: -30px;"><i class="fas fa-trash-alt"></i></a>
            `);
        }
        select.attr("data-oldValue", select.val() || "");
        prevSelect = select;
    }

    function removeSelect(select) {
        prevSelect = $(select.parentElement.parentElement).prev("div").find("select");
        addSocialNameToRemainingArray(select.value || select.options[1].value);
        select.parentElement.parentElement.remove();
    }

    function addSocialNameToRemainingArray(name) {
        if (!name || !socialMedias.includes(name) || remainingSocialMedias.includes(name)) {
            return;
        }
        remainingSocialMedias.splice(0, 0, name);
    }

    function changeSelect(select) {
        const previousSelected = select.getAttribute("data-oldValue");
        const selectedValue = select.value;
        const Input = $(select).parent('div').find('input');
        Input.attr('name', 'social[][' + select.value + ']');
        select.setAttribute("data-oldValue", selectedValue);
        if (!previousSelected) {
            return;
        }
        replaceSelectedOptionWithPreviousSelectedInRemainingArray(
            selectedValue,
            previousSelected
        );
        replaceSelectedOptionInAllSelects(select, selectedValue, previousSelected);
    }

    function replaceSelectedOptionWithPreviousSelectedInRemainingArray(
        removedValue,
        addedValue
    ) {
        if (
            !remainingSocialMedias.length ||
            !remainingSocialMedias.includes(removedValue)
        ) {
            return;
        }
        const index = remainingSocialMedias.indexOf(removedValue);
        remainingSocialMedias.splice(index, 1, addedValue);
    }

    function replaceSelectedOptionInAllSelects(
        selectChanged,
        removedValue,
        addedValue
    ) {
        const selects = $(selectChanged.parentElement.parentElement).nextAll("div").find("select");
        for (let select of selects) {
            const options = select.options;
            for (let option of options) {
                if (option.value == removedValue) {
                    option.value = addedValue;
                    option.text = addedValue;
                }
            }
        }
    }

    function sortRemainingArrayBasedOnOldSocialsArray() {
        const newRemainingSocials = [];
        for (let social of remainingSocialMedias) {
            if (!oldSocials.includes(social)) {
                newRemainingSocials.push(social);
            }
        }
        remainingSocialMedias = [...oldSocials, ...newRemainingSocials];
    }

    if (oldSocials.length) {
        sortRemainingArrayBasedOnOldSocialsArray();
        for (let social of oldSocials) {
            addSocialMediaSelect(true);
        }
    } else {
        addSocialMediaSelect();
    }
</script>
