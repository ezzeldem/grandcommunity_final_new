function exportInfluencerExcel(event) {
    event.preventDefault();
    let visibleColumns = [];
    let selected_ids = getCheckedItemsInDataTableFromSession();

    // $("#influe input[type=checkbox]:checked").each(function () {
    //     if (this.value != "on") selected_ids.push(this.value);
    // });
    influe_tabels.columns().every(function () {
        var visible = this.visible();
        if (visible) {
            if (this.header().innerHTML != "Actions") {
                if (
                    this.header().innerHTML !=
                    '<input type="checkbox" name="select_all" id="select_all">'
                ) {
                    let text = this.header().getAttribute("data-tablehead");
                    if (text != null) {
                        visibleColumns.push(text);
                    }
                }
            }
        }
    });



    let dataObj = {
        selected_ids: selected_ids.length > 0 ? selected_ids : null,
        country_filter: $("#country_filter").val(),
        country_id_search: $("#country_id_search").val(),
        gender: $("#gender").val(),
    };

    let query = `/dashboard/influe/export?visibleColumns=${visibleColumns}`;
    for (let key in dataObj) {
        if (dataObj[key]) {
            query += `&${key}=${dataObj[key]}`;
        }
    }

    window.open(query);

    // window.open(
    //         `/dashboard/influe/export?visibleColumns=${visibleColumns}&selected_ids=${selected_ids}&status=${$(
    //             "#status"
    //         ).val()}&country_filter=${$(
    //             "#country_id_search"
    //         ).val()}&nationality_id_search=${$(
    //             "#nationality_id_search"
    //         ).val()}&startDateSearch=${$(
    //             "#startDateSearch"
    //         ).val()}&endDateSearch=${$(
    //             "#endDateSearch"
    //         ).val()}&campaign_id_search=${$(
    //             "#campaign_id_search"
    //         ).val()}&gender=${$("#gender").val()
    //     }`
    // );
}

$(document).ready(function () {
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;
        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }
    $(document).on("click", "#select_all_dt_items", function () {
        if(!$(this).is(":checked")){
            sessionStorage.setItem("selectedItemsInDatatable", JSON.stringify([]));
        }
        CheckAll("box1", this);
    });

    /////////////btn delete/////////////////////////
    $(document).on("click", "#btn_delete_all", function () {
        // var selected = new Array();
        // $("#influe input[type=checkbox]:checked").each(function () {
        //     if (this.value != "on") {
        //         selected.push(this.value);
        //     }
        // });
        let selected = getCheckedItemsInDataTableFromSession();

        if (selected.length > 0) {
            $("#delete_all").modal("show");
            $('input[id="delete_all_id"]').val(selected);
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });
    /////////////btn Edit/////////////////////////
    $(document).on("click", "#btn_edit_all", function () {
        // var selected = new Array();
        // $("#influe input[type=checkbox]:checked").each(function () {
        //     if (this.value != "on") {
        //         selected.push(this.value);
        //     }
        // });

        let selected = getCheckedItemsInDataTableFromSession();

        if (selected.length > 0) {
            $("#edit_all").modal("show");
            $('input[id="influe_all_id"]').val(selected);
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });

    $(document).on("click", "#add_to_list", function () {
        // var selected = new Array();
        // $("#influe input[type=checkbox]:checked").each(function () {
        //     if (this.value != "on") {
        //         selected.push(this.value);
        //     }
        // });
        let selected = getCheckedItemsInDataTableFromSession();
        if (selected.length > 0) {
          //  console.log(selected);
            $("#favListBrand").modal("show");
			$("#select_brands_groups").val('').change();
			$("#select_brands").val('').change();
            $('input[id="influe_all_id"]').val(selected);
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });

    function isValidDate(d) {
        return !isNaN(Date.parse(d));
    }
    var start = "";
    var end = "";
    function cb(start, end) {
        $("#reportrange span").html(
            isValidDate(start) && isValidDate(end)
                ? start.format("MMMM D, YYYY") +
                      " - " +
                      end.format("MMMM D, YYYY")
                : ""
        );
        $("#startDateSearch").val(
            isValidDate(start) ? start.format("YYYY-MM-DD") : ""
        );
        $("#endDateSearch").val(
            isValidDate(end) ? end.format("YYYY-MM-DD") : ""
        );
    }

    $("#reportrange").daterangepicker(
        {
            autoUpdateInput: false,
            locale: {
                cancelLabel: "Clear",
                format: "YYYY/MM/DD",
            },
            minYear: 2000,
            maxYear: 2030,
            startDate: moment().subtract(29, "days"),
            endDate: moment(),
            ranges: {
                All: ["", ""],
                Today: [moment(), moment().add(1, "years")],
                Yesterday: [
                    moment().subtract(1, "days"),
                    moment().subtract(1, "days"),
                ],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        },
        cb
    );
    cb(start, end);
    $("#reportrange").on("click", function () {
        start = moment().subtract(29, "days");
        end = moment();
        $("#reportrange span").html(
            start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
        );
        $("#startDateSearch").val(
            isValidDate(start) ? start.format("YYYY-MM-DD") : ""
        );
        $("#endDateSearch").val(
            isValidDate(end) ? end.format("YYYY-MM-DD") : ""
        );
    });

    $("#reportrange").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
    });

    $("#country_id_search").select2({
        placeholder: "Select",
        allowClear: true,
    });
    $("#nationality_id_search").select2({
        placeholder: "Select",
        allowClear: false,
    });
    $("#check_status").select2({
        placeholder: "Select",
        allowClear: false,
    });
    $("#status").select2({
        placeholder: "Select",
        allowClear: false,
    });

    $("#bulk_status").select2({
        placeholder: "Select",
        allowClear: true,
    });

    $("#bulk_nationality").select2({
        placeholder: "select",
        closeOnSelect: false,
        allowClear: true,
    });
    $("#bulk_nationality").val("");
    $("#bulk_nationality").trigger("change");

    $("#bulk_gender").select2({
        placeholder: "Select",
        allowClear: true,
    });
    $("#bulk_gender").val("");
    $("#bulk_gender").trigger("change");
    $("#bulk_active").select2({
        placeholder: "Select Status",
        allowClear: true,
    });
    $("#bulk_active").val("");
    $("#bulk_active").trigger("change");
    $("#bulk_country_id").select2({
        placeholder: "select",
        allowClear: true,
        closeOnSelect: false,
    });
    $("#bulk_country_id").val("");
    $("#bulk_country_id").trigger("change");

    $("#gender").select2({
        placeholder: "Select",
        allowClear: false,
    });
    $("#campaign_id_search").select2({
        placeholder: "Select",
        allowClear: true,
    });

    // filter form toggle
    $("#filters").click(function () {
        if ($("#filter-form").css("display") == "flex") {
            $("#filter-form").css({ display: "none", height: 0 });
        } else {
            $("#filter-form").css({ display: "flex", height: "auto" });
        }
    });
    // import form toggle
    // $('#import').click(function (){
    //     if($('#import-form').css('display') == 'flex'){
    //         $('#import-form').css({'display':'none', 'height':0})
    //     }else{
    //         $('#import-form').css({'display':'flex', 'height':'auto'})
    //     }
    // })
});

// $('body').on("click", "#submit_addGroup", function (e) {
//     e.preventDefault();
//     var name = $("#groupname").val();
//     var created_by = $("#account_user_login_id").val();
//     var brand_id = $("#brand_id").val();
//     var country_id = $("#country_id_group").val();
//     var color = $("#symbol").val();
//     var flag = $("#flag").val();
//     $.ajax({
//         type: "POST",
//         url: "/dashboard/influe/groups_create",
//         dataType: "json",
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//         data: {
//             name: name,
//             created_by: created_by,
//             brand_id: brand_id,
//             country_id: country_id,
//             color: color,
//             flag: flag,
//         },
//         success: function (data) {
//             // $("#brands_groups").append(
//             //     `<option value="${data.data.id}" selected> ${data.data.name}</option>`
//             // );
//             $("#card_add").hide();
//             $("#card_edit").show();
//             $("#submit_addInflueToGroup").show();
//             let select = $("#select_brands");
//             let selectData = {};
//             let related = select.attr('data-other-name');
//             selectData[related] = select.val();
//             selectToGetOtherRequest(select, data);
//             select.val(data.data.id).trigger("change")
//         },
//         error: function (data) {
//             $("#name_error").text("");
//             $("#country_error").text("");
//             if (data.responseJSON.errors.name) {
//                 $("#name_error").text(data.responseJSON.errors.name[0]);
//             }
//             if (data.responseJSON.errors.country_id) {
//                 $("#country_error").text(
//                     data.responseJSON.errors.country_id[0]
//                 );
//             }
//         },
//     });
// });
$("#submit_addInflueToGroup").on("click", function (e) {
    e.preventDefault();
    var brand_id = $("#select_brands").val();
    // var sub_brand_id = $("#select_sub_brands").val();
    var copy_all_id = $("#influe_all_id").val();
    var brands_groups = $("#select_brands_groups").val();
    $.ajax({
        type: "POST",
        url: "/dashboard/influe/AddInflue_to_group",
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            brand_id: brand_id,
            // sub_brand_id: sub_brand_id,
            copy_all_id: copy_all_id,
            brands_groups: brands_groups,
        },
        success: function (data) {
            $("#favListBrand").modal("hide");
            let countSuccess=data.total_success;
            let countFaild=data.total_failed;
            let name=[];
			if(data.results.length > 0){
				data.results.map((msg)=> name.push(msg.Name+'<br/> Reason : '+msg.Resaon));
			}
			let item=name.map((i,key)=> `<li>${key+1} - ${i}  <small></small> </li>`).join('');
            Swal.fire("Done", `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`, "success").then(function() {
                //location.reload(true);
            });
        },
        error: function (data) {
			$("#error_msg").html(data.message)
             if("brand_id" in data.responseJSON.errors){
               $('#brand_id_error').text('The company field is required.');
             }
            if("sub_brand_id" in data.responseJSON.errors){
                $('#sub_brand_id_error').text('The brand field is required.');
            }
            if("brands_groups" in data.responseJSON.errors){
                $('#brands_groups_error').text('The group list field is required.');
            }
        },
    });
});

$(document).on("click", "#my_create", function () {
    $("#card_add").show();
    $("#card_edit").hide();
});
$(document).on("click", "#card_edit", function () {
    $("#card_add").hide();
    $("#card_edit").show();
});
$("#brands_groups").select2({
    placeholder: "Select",
    allowClear: true,
});
