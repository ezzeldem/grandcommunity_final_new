let influe_grouList_tabels = null;
let brand_id = $("#brand_id").val();
let groupId = 0;
let subbrandId = $("#route_sub_brand_id").val();

let influencerselectedIds = [];
let unfavo_influencerselectedIds = [];

let suspendedGroups = []

function updateDataTableSelectAllCtrl(table, rows_selected) {
    var $table = table.table().node();
    var $chkbox_all = $('tbody input[type="checkbox"]', $table);
    var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
    var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

    if ($chkbox_checked.length > 0)
        $("#bage-count-total").html(rows_selected.length + ' selected');
    else
        $("#bage-count-total").html('');
    // If none of the checkboxes are checked
    if ($chkbox_checked.length === 0) {
        chkbox_select_all.checked = false;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = false;
        }


        // If all of the checkboxes are checked
    } else if ($chkbox_checked.length === $chkbox_all.length) {
        chkbox_select_all.checked = true;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = false;
        }

        // If some of the checkboxes are checked
    } else {
        chkbox_select_all.checked = true;
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = true;
        }
    }
}

function getSelectedCheckboxesValues() {
    influencerselectedIds = [];
    $('.box2:checked').each(function () {
        influencerselectedIds.push($(this).val())
    });

    return influencerselectedIds;
}

$(document).ready(function () {
    // initgroups(brand_id,0,'fav');
    //influencerselectedIds= [];
    //$("#influe_group_list").DataTable().ajax.reload();;
});

function resetFavouritesFilter(){
    console.log(1111)
    $("#country_id_unfavorite_search").val("").trigger('change');
    $("#custom").val("");
    $("#country_id_wish_search").val("").trigger('change');
    $("#visited_campaign_search").val("").trigger('change');
}

$('#pills-unfavorite-tab').on('click',function (){
    resetFavouritesFilter();
	initgroups(brand_id,subbrandId,'unfav');
	initunfavoriteInfluencersList();
 });


 $('#pills-influs-tab').on('click',function (){
     resetFavouritesFilter();
 	initgroups(brand_id,subbrandId,'fav');
	 initInfluencersList();
  });


let initgroups = function (brand_id, sub_brand_id, type, search = null) {
    $.ajax({
        type: "POST",
        url: "/dashboard/brand/groups/" + brand_id,
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            sub_brand_id: subbrandId,
            type: type,
            search: search
        },
        success: function (data) {
            console.log(data.groups);
            var favTableAllFavsLine = `<div class="group-details new-active"  attr-id="0" id="allll" attr-type=${type} attr-name="All Favorite List"><div class="row">
				           <span class="col fav_name"  >Favourites</span><span class="col fav_country">${data.totalFav}</span></div></div>`
            $('#favTableAllFavsLine').html(favTableAllFavsLine)
            var groupHtml = ``;
            data.groups.forEach((e, i) => {
                groupHtml += `<div class="group-details new_data"  attr-id=${e.id} id="item-${e.id}" attr-type=${type} attr-name='${e.name}'>
					  <div class="row"><span class="col"><input type="checkbox" id="inf-checkbox-${e.id}" value="" class="box1"></span>
						  <span class="col fav_name" >${e.name}</span>
						  <span class="col fav_symbol" attr-color="${e.color}"><span title="${e.name}" style="border-radius: 50%;display: block;height: 17px;width: 17px;background:${e.color}" title="${e.color}"></span></span>
						  <span class="col fav_country"></span>
						  <span class="col for_Group" style="font-size:14px;font-width: none;" >${e.sub_brands != null ? e.sub_brands.name : ''}</span>
						  <span class="col fav_created_at" style="font-size:14px;font-width: none;" >${e.created_at}</span>
						  <span class="col fav_count"> <span class="badge badge-pill badge-danger">${e.count_influe}</span></span>
						  <span class="col fav_options"><i class="fas fa-edit" attr-id=${e.id} id="edit_group_name"></i></span>
					  </div>
				  </div>`;
            });
            $("#" + type + "_brand_groups").html(groupHtml);
        }
    });
}

$(document).on('change', '#search_fav_table_list', function () {
    var search_fav_list = $("#search_fav_table_list").val()
    initgroups(brand_id, subbrandId, 'fav', search_fav_list);
})


$(document).on('change', '#search_unfav_table_list', function () {
    var search_unfav_list = $("#search_unfav_table_list").val()
    initgroups(brand_id, subbrandId, 'fav', search_unfav_list);
})

$(document).on('change', '#fav_brand_groups_select_all', function () {
    console.log('checkbox')
    let checkType = $(this).prop("checked")
    console.log(checkType)
    if (checkType) {
        $("#fav_brand_groups input[type=checkbox]:not(:checked)").each(function () {
            $(this).attr("checked", true);
        });
    }
    else {
        $("#fav_brand_groups input[type=checkbox]:checked").each(function () {
            $(this).attr("checked", false);
        });
    }
})

$(document).on("click", ".group-details", function () {
    groupId = $(this).attr("attr-id");
    groupName = $(this).attr("attr-name");
    var grouptype = $(this).attr("attr-type");

    let checkboxId = '#inf-checkbox-' + groupId
    if ($(checkboxId).prop("checked") === true) {
        $(checkboxId).attr("checked", false);
        groupId = 0;
        this.groupId = 0;
    } else {
        $(checkboxId).attr("checked", true);
    }
    console.log($(checkboxId).prop("checked"))

    if (groupId != 0 && groupId != "") {
        $("#influe_group_title").html("Group Name:" + groupName);
        $("#move_influ").show();
        $('#del_infl_from_group').show();
        $('#del_infl_from_group').attr('data-group', groupId)
    } else {
        $("#influe_group_title").html('All Favorite List');
        $("#move_influ").hide();
        $('#del_infl_from_group').hide();
        $('#del_infl_from_group').attr('data-group', 0)
    }

    if (grouptype == "unfav") {
        unfavo_influencerselectedIds = [];
        $("#unfavorite_influe_group_list").DataTable().ajax.reload();
    } else {
        influencerselectedIds = [];
        $("#influe_group_list").DataTable().ajax.reload();
    }
    $('#importgroupId').val(groupId);
});


let initInfluencersList = function () {

    $('#influe_group_list').DataTable().destroy();
    $('#influe_group_list').on('processing.dt', function (e, settings, processing) {
        $('#processingIndicator').css('display', 'none');
        if (processing) {
            $("#influe_group_list").addClass('table-loader').show();
        } else {
            $("#influe_group_list").removeClass('table-loader').show();
        }
    })

    let influe_grouList_tabels = $("#influe_group_list").DataTable({
        lengthChange: true,
        processing: true,
        serverSide: true,
        responsive: true,
        searching: true,
        destroy: true,
        ajax: {
            url: "/dashboard/get-fav-groupList",
            data: function (d) {
                d.groupId = groupId;
                d.brand_id = brand_id;
                d.sub_brand_id = $("#route_sub_brand_id").val();
                d.country_taps = $("#country_id_wish_search").val();
                d.country_id = $("#my_country").val();
                d.visited_campaign = $("#visited_campaign_search").val();
                d.custom = $("#custom").val();
                d.del = 0;
            },
        },
        columns: [
            {
                data: "id",
                sortable: false,
                render: function (data, type) {
                    // Getting groups for suspended groups
                    let groupsData = influe_grouList_tabels.row().data().groups
                    let arr = []
                    if (groupsData && groupsData.length > 0) {
                        let groups = JSON.parse(groupsData);
                        if (groups && groups.length > 0) {
                            groups.forEach(g => {
                                arr.push(g.id)
                            })
                        }
                    }
                    // End of getting groups for suspended groups
                    return (
                        '<input type="checkbox"  value="' +
                        data +
                        '" class="box2" attr-groups="' + arr + '">'
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
            {
                data: "insta_uname",
                render: function (data) {
                    return `
									<span class="_username_influncer">${data}</span>
								`
                }
            },

            {
                data: "created_at",
                render: function (data) {
                    return `
									<span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
								`
                }
            },
            {
                data: "country_id",
                className: "hover_country",
                render: function (data, type) {
                    return (data) ? `${data.code.toUpperCase()}` : '';
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
                    if (data && data.length > 0) {
                        var groups = JSON.parse(data);
                        if (Array.isArray(groups) && groups.length > 0) {
                            groups.forEach(function (e, array) {
                                var color = `<span style="border-radius: 50%;display: inline-block;height: 17px;width: 17px;background:${e.color}" title="${e.name}"></span>`;
                                arr.push(color);
                            });
                            return arr.join(" ");
                        }
                    }
                    return '<span class="_username_influncer">no groups</span>';
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
        ],
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
        language: {
            searchPlaceholder: "Search",
            sSearch: "",
        },
        rowCallback: function (row, data, dataIndex) {
            // Get row ID
            var rowId = data.id;
            // If row ID is in the list of selected row IDs
            if ($.inArray(rowId, influencerselectedIds) !== -1) {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }

        },
    });


    $('#influe_group_list tbody').on('click', 'input[type="checkbox"]', function (e) {
        var $row = $(this).closest('tr');

        // Get row data
        var data = influe_grouList_tabels.row($row).data();
        console.log(data);
        // Get row ID
        var rowId = data.id;
        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray(rowId, influencerselectedIds);

        // If checkbox is checked and row ID is not in list of selected row IDs
        if (this.checked && index === -1) {
            influencerselectedIds.push(rowId);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1) {
            influencerselectedIds.splice(index, 1);
        }

        if (this.checked) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(influe_grouList_tabels, influencerselectedIds);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });
    // Handle click on "Select all" control
    $('thead input[name="select_all"]', influe_grouList_tabels.table().container()).on('click', function (e) {
        if (this.checked) {
            $('#influe_group_list tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('#influe_group_list tbody input[type="checkbox"]:checked').trigger('click');
        }
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });


    // Handle table draw event
    influe_grouList_tabels.on('draw', function () {

        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(influe_grouList_tabels, influencerselectedIds);
    });
}


let getGroupsselect2 = function () {
    $('#choose_group_list').select2(
        {
            placeholder: "select groups",
            multiple: true,
            ajax: {
                url: "/dashboard/brand_groups/" + brand_id,
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) {
                    let termContent = term
                    if (!!term.term === false) {termContent.term = ''}
                    return {
                        q: termContent,
                        page_limit: 10,
                        page: page //you need to send page number or your script do not know witch results to skip
                    };
                },
                // Suspend checked rows groups from suspended groups
                processResults: function (data) {
                    let resultData = data.results
                    $("#influe_group_list tbody input[type=checkbox]:checked").each(function () {
                        let groups = $(this).attr("attr-groups").split(',');
                        suspendedGroups = suspendedGroups.concat(groups);
                        suspendedGroups = suspendedGroups.filter((item, pos) => suspendedGroups.indexOf(item) === pos)
                    });
                    resultData = resultData.filter( ( el ) => !suspendedGroups.includes( el.id.toString() ) );
                    return {results: resultData};
                },
                // End of suspend checked rows groups from suspended groups
                results: function (data, page) {
                    var more = (page * 10) < data.total;
                    return {results: data.results, more: more};
                }, formatResult: Repoformat,
                formatSelection: Repoformat,
                escapeMarkup: function (m) {
                    return m;
                },
                dropdownCssClass: "bigdrop"
            }
        });
}

// $(document).on("click", "#merge_brand_from_id", function () {
//     this.getBrandsSelect2()
// });

let getBrandsSelect2 = function () {

    $('#merge_brand_from').select2(
        {
            placeholder: "select brands",
            multiple: true,
            ajax: {
                url: "/dashboard/allbrands/" + brand_id,
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) {
                    console.log('select2 data')
                    let termContent = term
                    if (!!term.term === false) {termContent.term = ''}
                    return {
                        q: termContent,
                        page_limit: 10,
                        page: page //you need to send page number or your script do not know witch results to skip
                    };
                },
                results: function (data, page) {
                    console.log('select2 results')
                    var more = (page * 10) < data.total;
                    return {results: data.results, more: more};
                },
                formatResult: Repoformat,
                formatSelection: Repoformat,
                escapeMarkup: function (m) {
                    return m;
                },
                dropdownCssClass: "bigdrop"
            }
        });
}


let initbrandgroups = function (brand_id, sub_brand_id, type) {
    $.ajax({
        type: "POST",
        url: "/dashboard/brand/groups/" + brand_id,
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            sub_brand_id: subbrandId,
            type: type,
        },
        success: function (data) {
            var groupHtml = ``;
            data.groups.forEach((e, i) => {
                groupHtml += `<div class="form-check">
							<input class="form-check-input merge_box2" type="radio" name="to_group_id" id="merge_box2" value="${e.id}">
							<label class="form-check-label" for="inlineCheckbox6">${e.name}</label>
							<span style="float: right;color: #fff"> ${e.count_influe} </span>
						</div>`;
            });

            $("#brand_groups").html(groupHtml);
        }
    });
}

/*===========================================unfavorite list==============================*/
$('body').on('click', '#add_unfavourites_to_favourites', function () {
    let selected = getCheckedItemsInDataTableFromSession();
    if (selected.length > 0) {
        Swal.fire({
            title: 'Do you want to add selected influencers to favourite?',
            showCancelButton: true,
            confirmButtonText: 'Submit',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "/dashboard/brand-favourites/add",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {brand: $("#brand_id").val(), influencers: selected},
                    success: function (data) {
                        $("#unfavorite_influe_group_list").DataTable().ajax.reload();
                        Swal.fire('Saved!', '', 'success')
                    },
                    error: function (data) {
                        Swal.fire("Error", "something happened", "error");
                    },
                });
            }
        })
        console.log(getCheckedItemsInDataTableFromSession());
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
})
let initunfavoriteInfluencersList = function () {
    $('#unfavorite_influe_group_list').DataTable().destroy();
    $('#unfavorite_influe_group_list').on('processing.dt', function (e, settings, processing) {
        $('#processingIndicator').css('display', 'none');
        if (processing) {
            $("#unfavorite_influe_group_list").addClass('table-loader').show();
        } else {
            $("#unfavorite_influe_group_list").removeClass('table-loader').show();
        }
    })

    let unfavorite_influe_group_list = $("#unfavorite_influe_group_list").DataTable({
        lengthChange: true,
        processing: true,
        serverSide: true,
        responsive: true,
        searching: true,
        destroy: true,
        ajax: {
            url: "/dashboard/get-fav-groupList",
            data: function (d) {
                d.groupId = groupId;
                d.brand_id = brand_id;
                d.sub_brand_id = 0;
                d.country_taps = $("#country_id_unfavorite_search").val();
                d.country_id = $("#my_country").val();
                d.custom = $("#custom").val();
                d.del = 1;
            },
        },
        columns: [
            {
                data: "id",
                sortable: false,
                render: function (data, type) {
                    return (
                        '<input type="checkbox"  value="' + data +
                        '" class="box2 check-item-in-dt">'
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
            {
                data: "insta_uname",
                render: function (data) {
                    return `
							<span class="_username_influncer">${data}</span>
						`
                }
            },

            {
                data: "created_at",
                render: function (data) {
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
            // {
            // 	data: "groups",
            // 	orderable: false,
            // 	render: function (data, type) {
            // 		var arr = [];
            // 		if (arr.length > 0) {
            //
            // 		data.forEach(function (e, array) {
            // 			var color = `<span style="border-radius: 50%;display: inline-block;height: 17px;width: 17px;background:${e.color}" title="${e.name}"></span>`;
            // 			arr.push(color);
            // 		});
            // 			return arr.join(" ");
            // 		} else {
            // 			return ' <span class="_username_influncer">no groups</span>';
            // 		}
            // 	},
            // },
            // {
            // 	data: "visited_camapaigns",
            // 	render: function (data, type, full) {
            // 		//Button To Open PopUp With Three Buttons Delete, Delete From All Groups, Cancel
            // 		if (
            // 			data != undefined &&
            // 			data != "undefined" &&
            // 			data != ""
            // 		) {
            // 			var text = "";
            // 			if (data.length > 0) {
            // 				for (var x = 0; x < data.length; x++) {
            // 					if (
            // 						data[x] != null &&
            // 						data[x] != "null" &&
            // 						data[x].length
            // 					) {
            // 						for (var i = 0; i < data[x].length; i++) {
            // 							text += data[x][i]["name"] + ",";
            // 						}
            // 						text += `<span class="morelink _username_influncer" class="toggle_visited_campaigns_modal" onClick="toggle_visited_campaigns_modal(${
            // 							full["id"]
            // 						})" data-visited-campaigns='${JSON.stringify(
            // 							data[0]
            // 						)}' id="influencer_${
            // 							full["id"]
            // 						}" data-influencer-id="${
            // 							full["id"]
            // 						}" style="cursor: pointer;">See More</span>`;
            // 						return text;
            // 					}
            // 				}
            // 			} else {
            // 				return "...";
            // 			}
            // 		} else {
            // 			return "...";
            // 		}
            // 	},
            // },
        ],
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
        language: {
            searchPlaceholder: "Search",
            sSearch: "",
        }, rowCallback: function (row, data, dataIndex) {
            // Get row ID
            var rowId = data.id;
            // If row ID is in the list of selected row IDs
            if ($.inArray(rowId, unfavo_influencerselectedIds) !== -1) {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }

        },
    });


    $('#unfavorite_influe_group_list tbody').on('click', 'input[type="checkbox"]', function (e) {
        var $row = $(this).closest('tr');
        // Get row data
        var data = unfavorite_influe_group_list.row($row).data();
        // Get row ID
        var rowId = data.id;
        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray(rowId, unfavo_influencerselectedIds);

        // If checkbox is checked and row ID is not in list of selected row IDs
        if (this.checked && index === -1) {
            unfavo_influencerselectedIds.push(rowId);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1) {
            unfavo_influencerselectedIds.splice(index, 1);
        }

        if (this.checked) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(unfavorite_influe_group_list, unfavo_influencerselectedIds);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });
    // Handle click on "Select all" control
    $('thead input[name="select_all"]', unfavorite_influe_group_list.table().container()).on('click', function (e) {
        if (this.checked) {
            $('#unfavorite_influe_group_list tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('#unfavorite_influe_group_list tbody input[type="checkbox"]:checked').trigger('click');
        }
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });
}
/*=============================copy influencers to group =============================*/

$('body').on('click', "#copy_influ", function (e) {
    e.preventDefault();
    influencerselectedIds = getSelectedCheckboxesValues();
    if (influencerselectedIds.length > 0) {
        getGroupsselect2();
        $("#choose_group_list").val('').trigger('change');
        $("#copy_influ_modal").modal("show");
        $('input[id="copy_all_id"]').val(influencerselectedIds);
        $("#from_group_id").val(0);
        $("#copy_move_type").val(0);
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
});


$('body').on('click', "#move_influ", function (e) {
    e.preventDefault();
    influencerselectedIds = getSelectedCheckboxesValues();
    if (influencerselectedIds.length > 0) {
        getGroupsselect2();
        $("#choose_group_list").val('').trigger('change');
        $("#copy_influ_modal").modal("show");
        $('input[id="copy_all_id"]').val(influencerselectedIds);
        $("#from_group_id").val(groupId);
        $("#copy_move_type").val(1);
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
});

$(".influencer_close").on('click', function () {
    $("#copy_influ_modal").modal("hide");
})

$("#addgroupfavadd").on("click", function () {
    if ($("#copy_influencer_modal_form").validate()) {

        $("#addgroupfavadd").addClass("spin");
        $("#addgroupfavadd").attr("disabled", true);
        var copy_all_id = $("#copy_all_id").val();
        var choose_group_list = $("#choose_group_list").val();
        var fav_user = $("#account_user_login_id").val();
        var from_group_id = $("#from_group_id").val();
        var copy_move_type = $("#copy_move_type").val();

        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/dashboard/copy_move_influe_group",
            dataType: "json",
            data: {
                copy_all_id: copy_all_id,
                choose_group_list: choose_group_list,
                created_by: fav_user,
                copy_move_type: copy_move_type,
                fromGroups: from_group_id,
                influeIds: copy_all_id,
                to_groups: choose_group_list,
                brand_id: brand_id

            },
            success: function (res) {
                $("#addgroupfavadd").removeClass("spin");
                $("#addgroupfavadd").attr("disabled", false);
                $("#copy_influ_modal").modal("hide");
                let name = [];
                var item = '';
                if (res.results.length > 0) {
                    res.results.map((msg) => name.push(msg.Name));
                    item = name
                        .map((i, key) => `<li>${key + 1} - ${i}</li>`)
                        .join("");
                }
                Swal.fire(
                    "Done",
                    `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${res.total_success}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${res.total_failed}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`,
                    "success"
                );

                name = [];
                initgroups(brand_id, subbrandId, 'fav');
                influencerselectedIds = [];
                $("#influe_group_list").DataTable().ajax.reload();
                ;
                ;
            },
        });
    }
});


$("#addgroupfav").on("click", function (e) {
    e.preventDefault()
    if ($("#brand_add_group_form").validate().form()) {
        $("#addgroupfav").addClass("spin");
        $("#addgroupfav").attr("disabled", true);
        $.ajax({
            type: "POST",
            url: "/dashboard/groups_create",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: $('#brand_add_group_form').serialize(),
            success: function (data) {
                $("#addgroupfav").removeClass("spin");
                $("#addgroupfav").attr("disabled", false);
                $('#favgrouplist_modal').modal('hide');
                initgroups(brand_id, subbrandId, 'fav');
                Swal.fire("Done", "Created Successfully !", "success");

            },
            error: function (data) {
                $("#addgroupfav").removeClass("spin");
                $("#addgroupfav").attr("disabled", false);
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error", value[0], "error");
                });
            },
        });
    }
});

$(document).on('click', '#btn_delete_all_groups', function () {
    var delselected = new Array();
    $("#fav_brand_groups input[type=checkbox]:checked").each(function () {
        if (this.value)
            delselected.push(this.value);
    });

    if (delselected.length > 0) {
        $('#delete_all_groups').modal('show')
        $('input[id="delete_all_id"]').val(delselected);
    } else {
        Swal.fire("Error", "Please select a group first", "warning");
    }
});

//SUBMIT DELETE ALL TO SELECTED GROUPS
$(document).on('click', '#submit_delete_all_groups', function () {
    let selected_ids = $('input[id="delete_all_id"]').val();
    let brand_id = $("#brand_me_id").val();
    $.ajax({
        type: 'POST',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        url: "/dashboard/groups_delete-all",
        data: {selected_ids: selected_ids, brand_id: brand_id},
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                console.log(data)
                $('#delete_all_groups').modal('hide')
                Swal.fire("Success", "Deleted Successfully", "success");
                location.reload();
            } else {
                Swal.fire("Error", "Error in deleting", "warning");
            }
        },
        error: function (reject) {
        }
    });
});

/*====================================end=================================*/
$('#go_search_wish_brands').on('click', function () {
    influencerselectedIds = [];
    $("#influe_group_list").DataTable().ajax.reload();
    ;
    ;
})

$('#go_reset_wish_brands').on('click', function () {
    $("#country_id_wish_search").val('').trigger('change');
    $("#visited_campaign_search").val('').trigger('change');
    $("#custom").val('');
    influencerselectedIds = [];
    $("#influe_group_list").DataTable().ajax.reload();
    ;
    ;
})

$('#go_search_unfavorite_brands').on('click', function () {
    unfavo_influencerselectedIds = [];
    $("#unfavorite_influe_group_list").DataTable().ajax.reload();
})

$('#go_reset_unfavorite_brands').on('click', function () {
    $("#country_id_unfavorite_search").val('').trigger('change');
    unfavo_influencerselectedIds = [];
    $("#unfavorite_influe_group_list").DataTable().ajax.reload();
})


$(document).on("click", ".close-group-modal", function () {
    $("#delete_all_groups").modal("hide");
});


/*=============================unfavorite list======================================*/
$(document).on("click", "#delete_influe", function () {
    influencerselectedIds = getSelectedCheckboxesValues();
    if (influencerselectedIds.length > 0) {
        $("#delete_fav_influe_id").modal("show");
        $('input[id="delete_fav_all_influe_id"]').val(influencerselectedIds);
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
});

$(".close-unfavorite-modal").on('click', function () {
    $("#delete_fav_influe_id").modal("hide");
})
$(document).on("click", "#submit_delete_fav_influe_all", function () {
    let selected_ids = $('input[id="delete_fav_all_influe_id"]').val();
    var brand_id = $("#brand_id").val();
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/dashboard/influencer_delete_fav_all",
        data: {selected_ids: selected_ids, brand_id: brand_id},
        dataType: "json",
        success: function (data) {
            if (data.status) {
                $("#delete_fav_influe_id").modal("hide");
                Swal.fire("Done", "Deleted Successfully !", "success");
                initgroups(brand_id, subbrandId, 'fav');
                influencerselectedIds = [];
                $("#influe_group_list").DataTable().ajax.reload();
                ;
                ;

            }
        },
        error: function (data) {
            console.log(data);
        },
    });
});


/*=================================dislike==========================*/
$('body').on('click', "#delete_influ_from_group", function (e) {
    influencerselectedIds = getSelectedCheckboxesValues();
    if (influencerselectedIds.length > 0) {
        $("#delete_influ_option").val(1);
        $("#delInfluencerLabel").text('Move To Dislike');
        $("#dlete_influ_group_modal").modal("show");
        $('input[id="remove_all_iddss"]').val(influencerselectedIds);
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
});

$('body').on('click', "#del_infl_from_group", function (e) {
    influencerselectedIds = getSelectedCheckboxesValues();
    if (influencerselectedIds.length > 0) {
        $("#delete_influ_option").val(2);
        $("#delInfluencerLabel").text('Delete');
        $("#groupId").val(groupId);
        $("#dlete_influ_group_modal").modal("show");
        $('input[id="remove_all_iddss"]').val(influencerselectedIds);
    } else {
        Swal.fire("Error", "Please select an influencer first", "error");
    }
});

$('body').on('click', ".close_dislike_influencer", function (e) {
    $("#dlete_influ_group_modal").modal('hide');
});


$('body').on('click', "#deletegroupss_influencers", "click", function () {
    var created_by = $("#account_user_login_id").val();
    var getGroupID = $('#del_infl_from_group').data('group');
    var influencer_ids = $("#remove_all_iddss").val();
    var brand_id = $("#brand_id").val();
    var delete_influ_option = $("#delete_influ_option").val();

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
            delete_influ_option: delete_influ_option
        },
        success: function (data) {
            if (data.status) {
                Swal.fire("Done", "Removed Successfully !", "success");
                $("#dlete_influ_group_modal").modal("hide");
                initgroups(brand_id, subbrandId, 'fav');
                influencerselectedIds = [];
                $("#influe_group_list").DataTable().ajax.reload();
                ;
                ;
            }
        },
    });
});


$(document).on("click", "#import_excel_btn", function (e) {
    let import_excel = $("#import_influe_to_group").val();
    let url = $('#submit_import_form').attr('action');
	if (import_excel == "" || import_excel == null) {
		e.preventDefault();
		Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
	} else {
        var formData = new FormData();
        var file_data = $('#import_influe_to_group').prop('files')[0];
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('file', file_data);
        formData.append('groupId', $('#importgroupId').val());
        formData.append('brand_id', $('#importBrandId').val());

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $('#import_excel_modal').modal('hide');
                if(data.status){
                    let countSuccess=0
                    let countFaild=0
                    let name=[];
                    data.message.map((msg)=> (msg.status=='success')?(countSuccess = countSuccess+1):(countFaild=countFaild+1 ,name.push(msg.Name+'---'+msg.message)));
                    let item=name.map((i,key)=> `<li>${key+1} - ${i}  <small></small> </li>`).join('');
                    Swal.fire("Done", `<ul><li class="m-b2">Success : <span class="badge badge-pill badge-success ">${countSuccess}</span></li> <li class="m-b-2">Faild : <span class="badge badge-pill badge-danger">${countFaild}</span></li> Influencers Failed <div class="mb-2 mt-2 styled-scrollbars" style="overflow-y: scroll; max-height: 99px"> ${item}</div></ul>`, "success").then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                }
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            },
        });
        // $("#submit_import_form").submit();
	}
});

$(document).on("click", "#import_excel", function () {
    $("#import_excel_modal").modal("show");
});

$('.close_import_excel_modal').on('click', function () {
    $("#import_excel_modal").modal("hide");
})

$("#my_create").click(function () {
	$("#hidden_name").val("");
	$("#hidden_id").val("");
	$("#editlabelmodal").text("Create Group");
	$("#groupname").val("");
	$("#sub_brand_id").val("").trigger("change");
	$("#symbol").val("");
	$("#flag").val("");
	$("#name_error").text("");
	$("#country_error").text("");
	$("#sub_brand_id").val("").trigger("change");
	$("#favgrouplist_modal").modal("show");
});

$(document).on("click", ".close_addgroup_model", function () {
    $("#favgrouplist").modal("hide");
});

$(document).on("click", "#edit_group_name", function () {
    groupId = $(this).attr("attr-id");
    if (groupId != 0) {
        $.ajax({
            type: "GET",
            headers: {
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/dashboard/groups/" + groupId,
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    $("#groupname").val(data.data.name);
                    $("#symbol").val(data.data.color);
                    $("#sub_brand_id").val(data.data.sub_brand_id);
                    $("#hidden_id").val(data.data.id);
                    $("#flag").val("0");
                }
                $("#editlabelmodal").text("Edit Group");
                $("#favgrouplist_modal").modal("show");
            },
            error: function (data) {
                console.log(data);
            },
        });
    } else {
        Swal.fire("Cancelled", "Please Choose Group", "warning");
    }
});


$(document).on('click', '#merge_group', function () {
    getBrandsSelect2();
    initbrandgroups(brand_id, subbrandId, 'fav');
    $("#merge_group_modal").modal("show");

});

$(document).on('click', '.close-mergegroup-modal', function () {
    $("#merge_group_modal").modal("hide");
});


function Repoformat(state) {
    return state.text;
}


function exportWishListExcel(event) {
    event.preventDefault();
    let dataObj = {
        custom: $("#custom").val(),
        country_taps: $("#country_id_wish_search").val(),
        visited_campaign: $("#visited_campaign_search").val(),
        brand_id: $("#brand_id").val(),
        sub_brand_id: $("#route_sub_brand_id").val(),
        del: 0
    };

    let query = `/dashboard/wishlist/export?groupId=` + groupId + `&del=0&v=` + (Math.floor(Math.random() * 1000));
    for (let key in dataObj) {
        if (dataObj[key]) {
            query += `&${key}=${dataObj[key]}`;
        }
    }

    window.open(query);
}




