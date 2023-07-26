let influe_grouList_tabels = null;
$(document).ready(function () {

    $("#addgroupfav").on("click", function (e) {
        e.preventDefault();
        var name = $("#groupname").val();
        var created_by = $("#account_user_login_id").val();
        var brand_id = $("#brand_id").val();
        var country_id = $("#country_id_group").val();
        var sub_brand_id = $("#favgrouplist").find("#sub_brand_id").val();
        var color = $("#symbol").val();
        var flag = $("#flag").val();
        var list_id = $("#hidden_id").val();
        $.ajax({
            type: "POST",
            url: "/dashboard/groups_create",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                name: name,
                created_by: created_by,
                brand_id: brand_id,
                country_id: country_id,
                sub_brand_id: sub_brand_id,
                color: color,
                flag: flag,
                id: list_id,
            },
            success: function (data) {
                $("#favgrouplist").modal("hide");
                Swal.fire("Done", "Created Successfully !", "success");
                if (data) {
                    var trHTML = "";
                    var imgTemp = "";
                    data.data.country_id.forEach((e, i) => {
                        imgTemp += `<img style="display: inline-block; width:22px !important;height:22px !important;" src="https://hatscripts.github.io/circle-flags/flags/${e.code.toLowerCase()}.svg" width="26" class="img-flag" />`;
                    });
                    let newData = `
                        <div class="row" >
                            <span class="col"><input type="checkbox" value="${data.data.id}" class="box1"></span>
                            <span class="col fav_name">${data.data.name}</span>
                            <span class="col fav_symbol"> <span style="border-radius: 50%;display: block;height: 17px;width: 17px;background:${data.data.color}"></span></span>
                            <span class="col fav_country">${imgTemp}</span>
                            <span class="col fav_created_at">${data.data.created_at}</span>
                            <span class="col fav_count"><span class="badge badge-pill badge-danger">0</span></span>
                        </div>
                        `;
                    if (data.flag == 0) {
                        $(`#item-${data.data.id}`)
                            .children()
                            .remove()
                            .end()
                            .append(newData);
                    } else {
                        trHTML = `
                                <div class="group-details" attr-id="${data.data.id}" id="item-${data.data.id}">
                                       ${newData}
                                 </div>
                                `;
                        $("#append").append(trHTML);
                    }
                }
                location.reload();
            },
            error: function (data) {
                $("#name_error").val("");
                $("#country_error").val("");
                $("#sub_brand_id").val("").trigger("change");
                if (data.responseJSON.errors.name) {
                    $("#name_error").text(data.responseJSON.errors.name[0]);
                }
                if (data.responseJSON.errors.country_id) {
                    $("#country_error").text(
                        data.responseJSON.errors.country_id[0]
                    );
                }
                if (data.responseJSON.errors.sub_brand_id) {
                    // $('#sub_brand_id').text(data.responseJSON.errors.sub_brand_id[0])
                }
            },
        });
    });

    $(document).on("click", "#allll", function () {
        var brand_country = $("#my_countrys").val();
        $("#hidden_name").val("");
        $("#hidden_id").val("");
        $("#country_id").val("");
        $("#my_country").val(brand_country);
    });

    ///////////////////////////////////////////////delete group////////////////////////////////////////
    $(document).on("click", "#btn_delete_all", function () {
        var selected = new Array();
        $("#append input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });

        if (selected.length > 0) {
            $("#delete_all").modal("show");
            $('input[id="delete_all_id"]').val(selected);
        } else {
            Swal.fire(
                "Cancelled",
                "Please select one Group at least!",
                "warning"
            );
        }
    });

    ///////////////////////////////////////////////delete influencers////////////////////////////////////////
    // $(document).on("click", "#btn_delete_all_dislikes", function () {
    //     var selected = new Array();
    //     $("#exampleTbldislike input[type=checkbox]:checked").each(function (
    //         i,
    //         v
    //     ) {
    //         if (this.value != "on") {
    //             selected.push(this.value);
    //         }
    //     });
    //     var brand_id = $(
    //         $("#exampleTbldislike input[type=checkbox]:checked")[0]
    //     ).data("brand-id");

    //     if (selected.length > 0) {
    //         $("#delete_all").modal("show");
    //         $('input[id="delete_all_id"]').val(selected);
    //         $('#delete_all input[id="brand_id"]').val(brand_id);
    //     } else {
    //         Swal.fire(
    //             "Error",
    //             "Please select one influencer at least!",
    //             "error"
    //         );
    //     }
    // });

    ///////////////////////////////////////////////Restore influencers////////////////////////////////////////
    $(document).on("click", "#btn_restore_all_dislikes", function () {
        var selected = new Array();
        //console.log($("#exampleTbldislike input[type=checkbox]:checked"));
        $("#exampleTbldislike input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                //console.log(this.value);
                selected.push(this.value);
            }
        });

        if (selected.length > 0) {
            $("#restore_influencers").modal("show");
            $('input[id="restore_all_id"]').val(selected);
        } else {
            Swal.fire(
                "Error",
                "Please select one influencer at least!",
                "error"
            );
        }
    });

    $(document).on("click", "#btn_delete_all_sub_brands", function () {
        var selected = new Array();
        $("#append input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });

        if (selected.length > 0) {
            $("#delete_all_sub_brands").modal("show");
            $('input[id="delete_all_id"]').val(selected);
        } else {
            Swal.fire(
                "Cancelled",
                "Please select one Group at least!",
                "warning"
            );
        }
    });

    $(document).on("click", "#submit_delete_all", function () {
        let selected_ids = $('input[id="delete_all_id"]').val();
        var brand_id = $(this).parent().parent().find("#brand_id").val();
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/dashboard/groups_delete-all",
            data: { selected_ids: selected_ids, brand_id: brand_id },
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    $(".group-details input[type=checkbox]:checked")
                        .parent()
                        .parent()
                        .parent()
                        .remove();
                    $("#delete_all").modal("hide");
                    Swal.fire("Done", "Removed Successfully !", "success");
                    location.reload();
                }
            },
            error: function (data) {
                Swal.fire("Bad", "Error! Please Reload Page", "error");
            },
        });
    });
    ///////////////////////////////////////////////end delete group////////////////////////////////////////

    /////////////////////////////////////////////// restore group////////////////////////////////////////
    $(document).on("click", "#restore", function () {
        var selected = new Array();
        $(".group-details-restore input[type=checkbox]:checked").each(
            function () {
                if (this.value != "on") {
                    selected.push(this.value);
                }
            }
        );
        console.log("selected", selected);
        if (selected.length > 0) {
            $("#restore_id").modal("show");
            $('input[id="restore_all_id"]').val(selected);
        } else {
            Swal.fire("Cancelled", "Please select Groups!", "warning");
        }
    });
    $(document).on("click", "#submit_restore_all", function () {
        let selected_ids = $('input[id="restore_all_id"]').val();
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/dashboard/groups_restore-all",
            data: { selected_ids: selected_ids },
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    $(".group-details input[type=checkbox]:checked")
                        .parent()
                        .parent()
                        .parent()
                        .remove();
                    $("#restore_id").modal("hide");
                    Swal.fire("Done", "Created Successfully !", "success");
                    location.reload();
                }
            },
            error: function (data) {
                console.log(data);
            },
        });
    });

    $(document).on("click", ".group-details-restore", function () {
        var group_id = $(this).attr("attr-id");
        if (group_id == -1) {
            $("#restore_influe").show("");
            // $('#influe_table').text('Un Favorite Influencer Table')
            $("#delete_influe").hide();
        } else {
            $("#restore_influe").hide();
            // $('#influe_table').text('Favorite Influencer Table')
            $("#delete_influe").show();
        }
        let myID = $("#groupId").val(group_id);
        let id_import = $("#importgroupId").val(group_id);
        var country = $(this)
            .children(".row")
            .children(".fav_country")
            .attr("attr-code");
        var countryID = new Array();
        var myObject = eval("(" + country + ")");

        $(".nav-tabs").children().remove();
        $(".nav-tabs").append(
            `  <li class="all_tap tapsli active_now active" attr-id="0" id="country_tap"><a href="#all" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs"> All</span></a></li>`
        );
        for (i in myObject) {
            $(".nav-tabs").append(
                `<li class="tapsli" attr-id="${myObject[i]["id"]}" id="country_tap"> <a href="#${myObject[i]["id"]}" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs"> ${myObject[i]["name"]}</span> </a></li>`
            );
            countryID.push(myObject[i]["id"]);
        }
        $("#country_id").val(countryID);

        $("#my_country").val(countryID.toString());
        $(this).addClass("new-active");
        $(this).siblings().removeClass("new-active");
        if (group_id != 0 && group_id != "") {
            $("#move_influ").hide();
            //$('#delete_influ_from_group').hide();
            $("#import_excel").hide();
        }
        $("#influe_group_list").DataTable().ajax.reload();
    });

    ///////////////////////////////////////////////end restore group////////////////////////////////////////

    $("#edit_group_name").click(function () {
        $("#name_error").val("");
        $("#country_error").val("");
        $("#sub_brand_id").val("").trigger("change");
        if ($(".group-details").attr("attr-id") == "0") {
            Swal.fire("Cancelled", "Please Choose Group", "warning");
        }
    });

    /////////////////////////// when Group Click tap////////////////////////////////////
    $(document).on("click", ".group-details", function () {
        var myID = $(this).attr("attr-id");
        var name = $(this).children(".row").children(".fav_name").text();
        $("#hidden_name").val(name);
        var country = $(this)
            .children(".row")
            .children(".fav_country")
            .attr("attr-code");
        var countryID = new Array();
        var myObject = eval("(" + country + ")");
        $(".nav-tabs").children().remove();
        $(".nav-tabs").append(
            `  <li class="all_tap tapsli active_now active" attr-id="0" id="country_tap"><a href="#all" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs"> All</span></a></li>`
        );
        for (i in myObject) {
            $(".nav-tabs").append(
                `<li class="tapsli" attr-id="${myObject[i]["id"]}" id="country_tap"> <a href="#${myObject[i]["id"]}" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs"> ${myObject[i]["name"]}</span> </a></li>`
            );
            countryID.push(myObject[i]["id"]);
        }
        $("#country_id").val(countryID);
        $("#my_country").val(countryID.toString());
        var string_symbol = $(this)
            .children(".row")
            .children(".fav_symbol")
            .attr("attr-color");
        $("#hidden_symbol").val(string_symbol);

        /////////////////////////edit group ///////////////////////////////////////////////
      
        ///////////////////////// end edit group ///////////////////////////////////////////////
    });

	$("#edit_group_name")
	.off()
	.click(function () {
		var hidden_name = $("#hidden_name").val();
		var hidden_symbol = $("#hidden_symbol").val();
		var hidden_country = $("#country_id").val();
		var hidden_sub_brand_id = $("#sub_brand_id").val();
		$("#name_error").text("");
		$("#country_error").text("");
		$("#sub_brand_id").val("").trigger("change");

		if (myID != "0" && hidden_name != "") {
			$("#flag").val(0);
			$("#hidden_id").val(myID);
			$("#editlabelmodal").text("Edit Group");
			$("#addgroupfav")
				.text("Edit")
				.removeClass("btn-primary")
				.addClass("");
			$("#groupname").val(hidden_name);
			$("#symbol").val(hidden_symbol);
			$("#sub_brand_id").val(hidden_sub_brand_id);
			// $('#country_id_group').val(hidden_country.split(",")).trigger('change')
			$("#favgrouplist").modal("show");
		} else {
			Swal.fire("Cancelled", "Please Choose Group", "warning");
		}
	});
$("#my_create").click(function () {
	$("#hidden_name").val("");
	$("#hidden_id").val("");
	$("#editlabelmodal").text("Create Group");
	$("#addgroupfav").text("Add").removeClass("btn-warning").addClass("");
	$("#groupname").val("");
	// $('#country_id_group').val('').trigger('change');
	$("#sub_brand_id").val("").trigger("change");
	$("#symbol").val("");
	$("#flag").val("");
	$("#name_error").text("");
	$("#country_error").text("");
	$("#sub_brand_id").val("").trigger("change");
});
    ////////////////////////// import ///////////////////////////////////////////
    $(document).on("click", "#import_excel_btn", function (e) {
        let import_excel = $("#import_influe_to_group").val();
        if (import_excel == "" || import_excel == null) {
            e.preventDefault();
            Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
        } else {
            $("#submit_import_form").submit();
        }
    });

    $(document).on("click", "#import_excel", function () {
        $("#import_excel_modal").modal("show");
    });
    ////////////////////Edn import///////////////////////////////////////

    $(document).on("click", "#country_tap", function () {
        var country_id = $(this).attr("attr-id");
        //console.log(country_id)
        $("#country_taps").val(country_id);
        if (country_id == 0) {
            $(".all_tap").addClass("active_now");
        } else {
            $(".all_tap").removeClass("active_now");
        }
        $("#influe_group_list").DataTable().ajax.reload();

        $("#country_taps").val("");
    });
   
    $(document).on("click", "#group_taps", function () {
        $(".group-details input[type=checkbox]:checked").prop("checked", false);
        $("#influe_group_list input[type=checkbox]:checked").prop(
            "checked",
            false
        );
        $(".tap_camp_fav").addClass("active");
        $(".tap_camp_unfav").removeClass("active");
        $("#add_to_campaign").show();
        $("#copy_influ").show();
        $("#import_excel").show();
        $("#restore_influe").hide();
        $("#delete_influe").show();
        $("#move_influ").hide();
        $("#groupId").val("0");
        //tap_camp_unfav
        $("#influe_table").text("FAVORITE INFLUENCER TABLE");
        $("#influe_group_list").DataTable().ajax.reload();
    });

    $(document).on("click", ".group-details", function () {
        var group_id = $(this).attr("attr-id");
        let MyID = $("#groupId").val(group_id);
        let id_import = $("#importgroupId").val(group_id);
        $(this).addClass("new-active");
        $(this).siblings().removeClass("new-active");
        if (group_id != 0 && group_id != "") {
            $("#move_influ").show();
            //$('#delete_influ_from_group').show();
        } else {
            $("#move_influ").hide();
            //$('#delete_influ_from_group').hide();
        }
        $("#influe_group_list").DataTable().ajax.reload();
    });

    /////////////////check  all/////////////////////////////
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
    $(document).on("click", "#select_all", function () {
        CheckAll("box1", this);
    });
    /*   $(document).on('click','.box1',function (e){
        console.log($(this))
   e.stopPropagation()
});
*/

    $(document).on("click", ".box1", function (e) {
        var selected = [];
        $(".group-details input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });
    });

    $(document).on("click", "#select_all_influe", function () {
        CheckAll("box2", this);
    });
    //////////////////////end check all/////////////////////////////////

    var country_arrayList = [];
    $("#choose_group_list,#choose_group_list1").change(function () {
        // $('option:selected').attr('attr-country');
        var value = $(this).children("option:selected").attr("attr-country");

        country_arrayList.push(value);
        $(
            "#choose_group_list option:selected,#choose_group_list1 option:selected"
        ).each(function () {
            var value = $(this).attr("attr-country");
            country_arrayList.push(value);
        });
    });

    //////////////////add influ group list///////////////////////
    $("#copy_influ").click(function (e) {
        e.preventDefault();
        var selected = new Array();
        var selected = new Array();

        $("#influe_group_list input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });
        if (selected.length > 0) {
            $("#copy_influ_modal").modal("show");
            $('input[id="copy_all_id"]').val(selected);
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });

    $("#addgroupfavadd").on("click", function () {
        var copy_all_id = $("#copy_all_id").val();
        var choose_group_list = $("#choose_group_list").val();
        var fav_user = $("#account_user_login_id").val();
        var countries = country_arrayList;

        // var countryis = $('#choose_group_list').find('option:selected').attr('attr-country');
        // console.log(countryis)
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/dashboard/copy_influe_group",
            dataType: "json",
            data: {
                copy_all_id: copy_all_id,
                choose_group_list: choose_group_list,
                created_by: fav_user,
                country: countries,
            },
            success: function (res) {
                res.groupsCount.forEach((item, key) => {
                    $('[attr-id="' + item.group_id + '"]')
                        .children(".row")
                        .children(".fav_count")
                        .children("span")
                        .html(item.count);
                });
                country_arrayList = [];
                $("#copy_influ_modal").modal("hide");
                let countSuccess = 0;
                let countFaild = 0;
                let name = [];
                res.message.map((msg) =>
                    msg.status == "success"
                        ? (countSuccess = countSuccess + 1)
                        : ((countFaild = countFaild + 1), name.push(msg.Name))
                );
                let item = name
                    .map((i, key) => `<li>${key + 1} - ${i}</li>`)
                    .join("");

                Swal.fire(
                    "Done",
                    `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`,
                    "success"
                );
                name = [];
                $("#influe_group_list").DataTable().ajax.reload();
            },
        });
    });
    //////////////////end copyinflue///////////////////////////

    /////////////////////////move influencer/////////////////////////////////////
    $("#move_influ").click(function (e) {
        e.preventDefault();
        var getGroupID = $("#groupId").val();

        var all_options = document.getElementsByClassName("myoptionvalues");
        for (let index = 0; index < all_options.length; index++) {
            if (all_options[index].value == getGroupID) {
                all_options[index].style.display = "none";
            } else {
                all_options[index].style.display = "block";
            }
        }
        var selected = new Array();
        $("#influe_group_list input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });
        if (selected.length > 0) {
            $("#move_influ_modal").modal("show");
            var t = $('input[id="remove_all_id"]').val(selected);
            // console.log(selected)
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });

    /////////////////////////add influencer to camp/////////////////////////////////////
    $("#add_to_campaign").click(function (e) {
        e.preventDefault();
        var selected = new Array();
        $("#influe_group_list input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });
        if (selected.length > 0) {
            $("#add_to_campaign_modal").modal("show");
            var t = $('input[id="add_all_id"]').val(selected);
            // console.log(selected)
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });
    /////////////////save add to camp////////////////////////

    $("#add_to_camp").on("click", function () {
        var influeIds = $("#add_all_id").val();
        var created_by = $("#account_user_login_id").val();
        var camps_types = $("#camps_ids").find(":selected");

        var arr = [];
        camps_types.map((cell, val) => {
            arr.push({ id: val.value, type: val.getAttribute("data-type") });
        });

        $.ajax({
            type: "POST",
            url: "/dashboard/brand/add_to_camp",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            data: {
                influeIds: influeIds,
                camps_ids: arr,
                created_by: created_by,
                brand_id: $("#brand_id").val(),
            },
            success: function (res) {
                $("#add_to_campaign_modal").modal("hide");
                $("#camps_ids").val("");
                Swal.fire("Done", "Added Successfully !", "success");
            },
        });
    });

    /////////////////////////////////////////end add to camp///////////////////////////
    $("#moveInfluetogroupfav").on("click", function () {
        var influeIds = $("#remove_all_id").val();
        var to_groups = $("#choose_group_list1").val();
        var created_by = $("#account_user_login_id").val();
        var fromGroups = $("#groupId").val();
        var country = country_arrayList;

        $.ajax({
            type: "POST",
            url: "/dashboard/move_influe_to_Group",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            data: {
                fromGroups: fromGroups,
                influeIds: influeIds,
                to_groups: to_groups,
                created_by: created_by,
                country: country_arrayList,
            },
            success: function (res) {
                res.groupsCount.forEach((item, key) => {
                    $('[attr-id="' + item.group_id + '"]')
                        .children(".row")
                        .children(".fav_count")
                        .children("span")
                        .html(item.count);
                });
                $("#move_influ_modal").modal("hide");
                let countSuccess = 0;
                let countFaild = 0;
                let name = [];
                res.message.map((msg) =>
                    msg.status == "success"
                        ? (countSuccess = countSuccess + 1)
                        : ((countFaild = countFaild + 1),
                          name.push(msg.Name + "Group : " + msg.group_name))
                );
                let item = name
                    .map((i, key) => `<li>${key + 1} - ${i}</li>`)
                    .join("");

                Swal.fire(
                    "Done",
                    `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`,
                    "success"
                );
                name = [];
                $("#influe_group_list").DataTable().ajax.reload();
            },
        });
    });
    /////////////////////////end move influencer/////////////////////////////////////

    ////////////////delete influencers from group/////////////////
    $("#delete_influ_from_group").click(function (e) {
        e.preventDefault();
        var selected = new Array();
        $("#influe_group_list input[type=checkbox]:checked").each(function () {
            if (this.value != "on") {
                selected.push(this.value);
            }
        });
        if (selected.length > 0) {
            $("#dlete_influ_group_modal").modal("show");
            var t = $('input[id="remove_all_iddss"]').val(selected);
        } else {
            Swal.fire("Error", "Please select an influencer first", "error");
        }
    });
    $("#deletegroupss_influencers").on("click", function () {
        var created_by = $("#account_user_login_id").val();
        var getGroupID = $("#groupId").val();
        var influencer_ids = $("#remove_all_iddss").val();
        var brand_id = $("#brand_id").val();

        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/dashboard/delete_dislike_influencer_fromGroup",
            dataType: "json",
            data: {
                getGroupID: getGroupID,
                created_by: created_by,
                influencer_ids: influencer_ids,
                brand_id: brand_id,
            },
            success: function (data) {
                if (data.status) {
                    Swal.fire("Done", "Removed Successfully !", "success");
                    $("#dlete_influ_group_modal").modal("hide");
                    $("#influe_group_list").DataTable().ajax.reload();
                }
            },
        });
    });

    influe_grouList_tabels = $("#influe_group_list").DataTable({
        lengthChange: true,
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/dashboard/get-fav-groupList",
            data: function (d) {
                d.groupId = $("#groupId").val();
                d.brand_id = $("#brand_id").val();
                d.sub_brand_id = $("#sub_brand_id").val();
                d.country_taps = $("#country_taps").val();
                d.country_id = $("#my_country").val();
                d.custom = $("#custom").val();
            },
        },
        columns: [
            {
                data: "id",
                sortable: false,
                render: function (data, type) {
                    return (
                        '<input type="checkbox"  value="' +
                        data +
                        '" class="box2" >'
                    );
                },
            },
            {
                data: "name",
                render: function (data, type, full) {
                    return `
                    <span class="_username_influncer">${data}</span>`;
                },
            },
            { data: "insta_uname" ,
                render: function(data){
                    return `
                        <span class="_username_influncer">${data}</span>
                    `
                }
            },

            { data: "created_at",
                render: function(data){
                    return `
                        <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                    `
                }
            },
            {
                data: "country_id",
                className: "hover_country",
                render: function (data, type) {
                    return `${data.code.toUpperCase()}`;
                },
            },
            {
                data: "social",
                render: function (data, type) {
                    console.log(data);
                    let temp = "";
                    temp +=
                        "<div style='display: flex;gap: 8px;font-size: 15px;'>";
                    temp += data.insta_uname
                        ? `<a target="_blank" class="_username_influncer" title="Instagram" href='https://www.instagram.com/${data.insta_uname}'><i style="color: #bf1c6a;" class="fab fa-instagram"></i></a>`
                        : "";
                    temp += data.facebook_uname
                        ? `<a target="_blank" class="_username_influncer" title="Facebook" href='https://www.facebook.com/${data.facebook_uname}'><i class="fab fa-facebook"></i></a> `
                        : "";
                    temp += data.tiktok_uname
                        ? `<a target="_blank" class="_username_influncer" title="Tiktok" href='https://www.tiktok.com/@${data.tiktok_uname}'><i style="color: #000;" class="fab fa-tiktok"></i></a> `
                        : "";
                    temp += data.twitter_uname
                        ? `<a target="_blank" class="_username_influncer" title="Twitter" href='https://twitter.com/${data.twitter_uname}'><i style="color: rgb(29, 155, 240);" class="fab fa-twitter"></i></a> `
                        : "";
                    temp += data.snapchat_uname
                        ? `<a target="_blank" class="_username_influncer" title="Snapchat" href='https://story.snapchat.com/@${data.snapchat_uname}'><i style="color:#fffc00;" class="fab fa-snapchat"></i></a> `
                        : "";
                    temp += "</div>";
                    return temp;
                },
            },
            {
                data: "groups",
                orderable: false,
                render: function (data, type) {
                    var arr = [];

                    data.forEach(function (e, array) {
                        var color = `<span style="border-radius: 50%;display: inline-block;height: 17px;width: 17px;background:${e.color}" title="${e.name}"></span>`;
                        arr.push(color);
                    });
                    if (arr.length > 0) {
                        return arr.join(" ");
                    } else {
                        return ' <span class="_username_influncer">no groups</span>';
                    }
                },
            },
            {
                data: "visited_camapaigns",
                render: function (data, type, full) {
                    //Button To Open PopUp With Three Buttons Delete, Delete From All Groups, Cancel
                    if (
                        data != undefined &&
                        data != "undefined" &&
                        data != ""
                    ) {
                        var text = "";
                        if (data.length > 0) {
                            for (var x = 0; x < data.length; x++) {
                                if (
                                    data[x] != null &&
                                    data[x] != "null" &&
                                    data[x].length
                                ) {
                                    for (var i = 0; i < data[x].length; i++) {
                                        text += data[x][i]["name"] + ",";
                                    }
                                    text += `<span class="morelink _username_influncer" class="toggle_visited_campaigns_modal" onClick="toggle_visited_campaigns_modal(${
                                        full["id"]
                                    })" data-visited-campaigns='${JSON.stringify(
                                        data[0]
                                    )}' id="influencer_${
                                        full["id"]
                                    }" data-influencer-id="${
                                        full["id"]
                                    }" style="cursor: pointer;">See More</span>`;
                                    return text;
                                }
                            }
                        } else {
                            return "...";
                        }
                    } else {
                        return "...";
                    }
                },
            },
            {
                data: "actions",
                render: function (data, type) {
                    // Button To Open PopUp With Three Buttons Delete, Delete From All Groups, Cancel
                    return `<span style="background:transparent !important;width:2px !important;" data-toggle="tooltip" id="influencer_id_${data.id}" onClick="DeleteInflu(${data.id}, ${data.group_id})" data-placement="top" title="remove" data-group-id="${data.group_id}" data-id="${data.id}" class="btn btn-info mt-2 mb-2 pb-2 delete_influ_from_group">
                                <i class="far fa-trash-alt text-dange"></i>
                            </span>`;
                },
            },
        ],
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
        language: {
            searchPlaceholder: "Search",
            sSearch: "",
        },
    });

    ////////////// table  ///////////////////
    let relodpage_groups = true;
    $("#pills-influs-tab").on("click", function () {
        if (relodpage_groups == true) {
            relodpage_groups = false;
            $("#influe_group_list").DataTable().ajax.reload();
            $("#influe_group_list").prepend(
                '<input type="text" id="custom" placeholder="Search"/>'
            );
        }
    });
});

function DeleteInflu(id, group_id = null) {
    var buttons = "";
    buttons += `<a href="#!" id="deleteFromAll" onClick="deleteInfluePath(${id}, null, 1)" class="btn btn-danger deleteFromAll">Delete from all groups</a>`;
    if (group_id != 0 && group_id != null) {
        buttons += `<a href="#!" id="deleteFromOne" onClick="deleteInfluePath(${id}, ${group_id}, 0)" class="btn btn-danger deleteFromOne">Delete from selected group</a>`;
    }
    Swal.fire({
        icon: "warning",
        title: "Are you sure?",
        text: "You won't be able to undo this!",
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        footer: buttons,
    }).then((result) => {
        console.log(result);
    });
}

function toggle_visited_campaigns_modal(id) {
    var campaigns = $("#influencer_" + id).data("visited-campaigns");
    var table = $("#visited_campaigns_datatable").DataTable();
    $("#visited_campaigns_datatable").empty();
    table.destroy();
    $("#visited_campaigns_datatable").dataTable({
        data: campaigns,
        columns: [{ data: "name" }, { data: "visit_date" }],
    });
    $("#visit_campaigns_modal").modal("show");
}

function deleteInfluePath(id, group_id = null, type) {
    var influencer_id = id;
    var delete_type = type;
    var group_id = group_id;
    $.ajax({
        url: "/dashboard/remove-influe-groupList",
        type: "get",
        data: {
            influencer_id: influencer_id,
            group_id: group_id,
            type: delete_type,
        },
        success: function (res) {
            $(".swal2-modal").modal("hide");
            if (res.status) {
                influe_grouList_tabels.ajax.reload();
                Swal.fire("Done", "Removed Successfully !", "success");
            } else {
                Swal.fire("Error!", "Failed!", "error");
            }
        },
    });
}

$("#deleteFromAll").on("click", function () {
    console.log("deleteFromAll");
});

$("#deleteFromOne").on("click", function () {
    console.log("deleteFromOne");
});

/*
$("#search_fav_table_list").on("input", function () {
    $("#search_input").val($(this).val());
    loadMoreData((page = 1), $("#search_input").val());
});

function loadMoreData(page, search) {
    $("#influe_group_list").DataTable().ajax.reload();({
        url: "?page=" + page + "&search=" + search,
        type: "get",
        beforeSend: function () {
            $(".ajax-load").show();
        },
    })
        .done(function (data) {
            console.log("finish filter", data.newData);
            if (data.flag == 2) {
                $(".append").find(".new_data").remove();
                $(".append").find(".group-details").append(data.newData);
                $(".ajax-load").hide();
            } else if (data.flag == 3) {
                $(".append").find(".new_data").remove();
                $(".append").append(data.newData);
                $(".ajax-load").hide();
            } else if (data.flag == 1) {
                if (data.newData == "") {
                    $(".ajax-load").html("No More Record Found");
                    return;
                } else {
                    $(".ajax-load").hide();
                    $(".append").append(data.newData);
                    $("#choose_group_list").append(data.selectData);
                    $("#choose_group_list1").append(data.selectData);
                }
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log("Server error occured", thrownError);
        });
}
var page = 1;
var search = $("#search_input").val();

$(".main-profile-social-list").on("scroll", function () {
    if (
        $(this).scrollTop() + $(this).innerHeight() >=
        $(this)[0].scrollHeight
    ) {
        page++;
        loadMoreData(page, search);
    }
});
*/
$("#camps_ids,#choose_group_list,#choose_group_list1").select2({
    placeholder: "Select",
    allowClear: true,
});

///////

/////////////////////////////////////////////// restore influencer Un Fav////////////////////////////////////////
$(document).on("click", "#restore_influe", function () {
    var selected = new Array();
    $("#influe_group_list input[type=checkbox]:checked").each(function () {
        if (this.value != "on") {
            selected.push(this.value);
        }
    });
    console.log(selected);
    //if (selected.length > 0) {
    //    $('#restore_influe_id').modal('show')
    //    $('input[id="restore_all_id"]').val(selected);
    //}else{
    //    Swal.fire("Error", "Please select an influencer first", "error");
    //}
});

$(document).on("click", "#submit_restore_influe_all", function () {
    let selected_ids = $('input[id="restore_all_id"]').val();
    var brand_id = $("#brand_id").val();
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/dashboard/influencer-restore-disliked-all",
        data: { selected_ids: selected_ids, brand_id: brand_id },
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.status) {
                $("#influe_group_list input[type=checkbox]:checked")
                    .parent()
                    .parent()
                    .parent()
                    .remove();
                $("#restore_influencers").modal("hide");
                Swal.fire("Done", "Created Successfully !", "success");
                disliketable.ajax.reload();
                influe_grouList_tabels.ajax.reload();
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
});

//////////////////////////////////////////end restore un fav ///////////////////////////////////
$(document).on("input", "#custom", function () {
    influe_grouList_tabels.ajax.reload();
});

/////////////////////////////////////////////// restore influencer Un Fav////////////////////////////////////////
$(document).on("click", "#delete_influe", function () {
    var selected = new Array();
    $("#influe_group_list input[type=checkbox]:checked").each(function () {
        if (this.value != "on") {
            selected.push(this.value);
        }
    });
    if (selected.length > 0) {
        $("#delete_fav_influe_id").modal("show");
        $('input[id="delete_fav_all_influe_id"]').val(selected);
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
});

$(document).on("click", "#submit_delete_fav_influe_all", function () {
    let selected_ids = $('input[id="delete_fav_all_influe_id"]').val();
    var brand_id = $("#brand_id").val();
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/dashboard/influencer_delete_fav_all",
        data: { selected_ids: selected_ids, brand_id: brand_id },
        dataType: "json",
        success: function (data) {
            if (data.status) {
                $("#delete_fav_influe_id").modal("hide");
                Swal.fire("Done", "Deleted Successfully !", "success");
                influe_grouList_tabels.ajax.reload();

                data.groupsCount.forEach((item, key) => {
                    $('[attr-id="' + item.group_id + '"]')
                        .children(".row")
                        .children(".fav_count")
                        .children("span")
                        .html(item.count);
                });
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
});

$(document).on("click", ".custom_nav .tapsli", function () {
    $(this).addClass("active_now");
    $(this).siblings().removeClass("active_now");
    // $(this).removeClass('active')
});

$(".custom_nav .tapsli a").on("click", function () {
    // alert('new')
    $(this).parent().removeClass("active_now");
    $(this).removeClass("active_now");
});

$("#closeCopy").on("click", function () {}); //stop

