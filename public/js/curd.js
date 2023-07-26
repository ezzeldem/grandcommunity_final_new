$(".form-control")
    .focusout(function () {
        if ($(this).val() != "" && $(this).hasClass("is-invalid")) {
            $(this).removeClass("is-invalid");
            input.hasClass("datepicker")
                ? $(input)
                      .parent("div")
                      .find("div.input-group-append")
                      .next("span")
                      .remove()
                : $(this).next("span").remove();
        }
    })
    .trigger("focusout");

$("body").on("submit", "#createUpdate", function (e) {
    e.preventDefault();
    $('.invalid-feedback').remove()
    var form = $(this);
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    var formUrl = $(this).attr("action");
    var request = $.ajax({
        type: "POST",
        url: formUrl,
        mimeType: "application/json",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.status == true) {
                window.location.href = data.route;
            }
            // crud_handle_server_errors(data,form);
        },
        error: function (data) {
            crud_handle_server_errors(data, form);
        },
    });
});

window.crud_handle_server_errors = function (data, form = null) {
    var statusCode = data.status;

    switch (statusCode) {
        case 422: // validation error.
            crud_handle_validation_errors(data, form);
            break;

        case 401: // Authentication error.
        case 500:
            $.notify({ message: "server error" }, { type: "danger" });
            break;
        case 419: // .
            $.notify({ message: "CSRF Token mismatch" }, { type: "danger" });
            break;
        default: // unknown error
            $.notify({ message: "server error" }, { type: "danger" });
    }
};

window.crud_handle_validation_errors = function (data, form = null) {
    var keys = $.map(data.responseJSON.errors, function (value, key) {
        return value;
    });

    var errors = data.responseJSON.errors;

    $("input", "select").removeClass("is-invalid");

    $.each(errors, function (key, value) {
        var input =
            form != null
                ? form.find(':input[name="' + key + '"]')
                : $(':input[name="' + key + '"]');
        var select =
            form != null
                ? form.find(
                      'select[name="' + key + '"], select[name="' + key + '[]"]'
                  )
                : $('select[name="' + key + '"]');

        let isArrayInput = false;

         if (input.length == 0 && key.indexOf(".") != -1) {
             isArrayInput = true;

             // for multiple inputs nested names
            var nestedNames = key.split(".");
            var inputName = "";
            for (var i = 0; i < nestedNames.length; i++) {
                if (i != 0) {
                    inputName += "[" + nestedNames[i] + "]";
                } else {
                    inputName += nestedNames[i];
                }
            }
            inputName = inputName == "social[0]" ? "social[]" : inputName;
            for (i=0; i <= 5; i++){
                inputName = inputName.replace("social["+i+"]", "social[]")
            }

            input =
                form != null
                    ? form.find(':input[name^="' + inputName + '"]')
                    : $(':input[name="' + inputName + '"]');

        }else if(input.length == 0){
             let inputName = key+"[]";
             input =
                 form != null
                     ? form.find(':input[name="' + inputName + '"]')
                     : $(':input[name="' + inputName + '"]');
        }
        if (input.length > 0) {
            if (input.hasClass("datepicker")) {
                input.addClass("is-invalid");
                $(input)
                    .parent("div")
                    .find("div.input-group-append")
                    .next("span")
                    .remove();
                input
                    .parent("div")
                    .find("div.input-group-append")
                    .after(
                        "<span class='invalid-feedback' role='alert'><strong>" +
                            value[0] +
                            "</strong></span>"
                    );
            } else if (input.attr("type") == "number") {
                input.addClass("is-invalid");
                $(input).next("span").remove();
                input.after(
                    "<span class='invalid-feedback' role='alert'><strong>" +
                    value[0] +
                    "</strong></span>"
                );
            }else if(input.attr("type") === "checkbox" && isArrayInput){
                input.addClass("is-invalid");
                input.parents('.group-checkbox-inputs').find('.invalid-feedback').remove();
                input.closest('.group-checkbox-inputs').append(
                    "<span class='invalid-feedback' role='alert' style='display: unset;'><strong>" +
                    value[0] +
                    "</strong></span>"
                );
            }else if(input.attr("type") === "file" && input.hasClass('custom-upload-files-input')){
                input.addClass("is-invalid");
                input.closest('.custom-upload-files-container').append(
                    "<span class='invalid-feedback' role='alert' style='display: unset;'><strong>" +
                    value[0] +
                    "</strong></span>"
                );
            } else {
                input.addClass("is-invalid");
                $(input).next("span").remove();
                input.after(
                    "<span class='invalid-feedback' role='alert'><strong>" +
                        value[0] +
                        "</strong></span>"
                );
            }
        }
        if (select.length > 0) {
            $('select[name="' + key + '"]').removeClass(
                "select2-hidden-accessible"
            );
            select.addClass("is-invalid");
            $(select)
                .parent("div")
                .find("span.invalid-feedback")
                .not("input + span.invalid-feedback")
                .remove();
            select.after(
                "<span class='invalid-feedback' role='alert'><strong>" +
                    value[0] +
                    "</strong></span>"
            );
            $(select).select2();
        }
        window.scroll({ top: 0, left: 0, behavior: "smooth" });
    });
};
