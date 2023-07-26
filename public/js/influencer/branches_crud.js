let id = 1;
let payload = {};

// delete modal
function swalModal(
    message = "You will not be able to recover this record!",
    successFun
) {
    new swal({
        title: "Are you sure?",
        text: message,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, I am sure!",
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: true,
        closeOnCancel: false,
    }).then((isConfirm) => {
        successFun(isConfirm);
    });
}

// render template
function temp(payload) {
    let statusSpan =
        payload.status == 1
            ? `<span class="badge badge-success">Active</span>`
            : `<span class="badge badge-danger">InActive</span>`;
    let temp = `
                <td><input type="checkbox"  name="ids[]" value='${payload._id}' /></td>
                <td>${payload.name}</td>
                <td>${payload.city}</td>
                <td>${payload.country_name}</td>
                <td>${statusSpan}</td>
                <td>
                    <button type="button" data-toggle="modal" data-target="#branchModal" class="btn btn-warning edit_branch" onclick="editBranch(${payload._id})">
                         <i class="fas fa-edit"></i>
                    </button>
                    <button type="button"  class="btn btn-danger delete_branch" onclick="deleteBranch(${payload._id})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
                `;
    return temp;
}

// add and edit action
$("#save_branch").on("click", function () {
    let error = false;
    $(".js-error").remove();
    $(`#branchModal .modal-body input,
                #branchModal .modal-body select`).each((i, e) => {
        let name = e.getAttribute("name");
        if (e.value == "") {
            let errorEl = document.createElement("span");
            errorEl.className = "js-error";
            errorEl.style.color = "#f00";
            errorEl.innerHTML = `${name} required`;
            e.parentNode.insertBefore(errorEl, e.nextSibling);
            error = true;
        } else {
            if (!payload.hasOwnProperty("_id")) payload._id = id;
            payload[name] = e.value;
            if (name == "branch_country_id") {
                payload.country_name = $(
                    "#branch_country_id  option:selected"
                ).text();
            }
        }
    });
    if (error) return;
    else {
        let checkItemExists = branches.findIndex(
            (item) => item._id == payload._id
        );
        if (checkItemExists > -1) {
            branches[checkItemExists] = payload;
            $(`#table_branches tbody #row-${payload._id}`).children().remove();
            $(`#table_branches tbody #row-${payload._id}`).append(
                temp(payload)
            );
            payload = {};
        } else {
            branches.push(payload);
            $("#table_branches tbody").append(
                `<tr id='row-${id}' data-temp=true>${temp(payload)}</tr>`
            );
            id++;
            payload = {};
        }
        $("#branchModal").modal("hide");
        localStorage.setItem("branches", JSON.stringify(branches));
        $("#mydeletebtn").show();
        $("#table_branches").show();
    }
    // console.log(branches);
});

// load data in edit branch
function editBranch(id) {
    payload = branches.find((item) => item._id == id);
    $(`#branchModal .modal-body input,
                #branchModal .modal-body select`).each((i, e) => {
        // console.log(payload,e.getAttribute('getAttribute'));
        e.value = payload[e.getAttribute("name")];
    });
    $("#branchModalLabel").text("edit branch");
    $("#save_branch").text("edit");
}

// delete branch
function deleteBranch(id) {
    swalModal(undefined, function (isConfirm) {
        if (isConfirm) {
            let delIndex = branches.findIndex((item) => item._id == id);
            branches.splice(delIndex, 1);
            $(`#table_branches tbody #row-${id}`).remove();
            localStorage.setItem("branches", JSON.stringify(branches));
            if (branches.length == 0) {
                $("#mydeletebtn").hide();
                $("#table_branches").hide();
            }
            $.ajax({
                url: `dashboard/branches/${id}`,
                type: "DELETE",
                success: function (result) {
                    console.log(result);
                },
            });
        } else {
            swal("Cancelled", "canceled successfully!", "error");
        }
    });
}

// select all
$('#table_branches input[name="select_all"]').click(function () {
    $("#table_branches td input:checkbox").prop("checked", this.checked);
});

// delete all
$("#mydeletebtn").click(function () {
    var selected1 = new Array();
    let isDelete = null;
    $("#table_branches td input[type=checkbox]:checked").each(function () {
        // get data-id attribute of the checked checkbox
        isDelete = true;
        if (!$(this).parent().parent().attr("data-temp"))
            selected1.push(this.value);
    });
    if (isDelete) {
        swalModal(undefined, function (isConfirm) {
            if (isConfirm) {
                branches = [];
                // $(`#table_branches tbody`).children().remove();
                $("#table_branches td input[type=checkbox]:checked").each(
                    function () {
                        $(this).parent().parent().remove();
                    }
                );
                $('#table_branches input[name="select_all"]').prop(
                    "checked",
                    false
                );
                localStorage.setItem("branches", JSON.stringify(branches));
                if (selected1.length > 0) {
                    $.ajax({
                        url: "/dashboard/del-all/branches",
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            ids: selected1,
                        },
                        success: function (result) {
                            console.log(result);
                        },
                    });
                }
            } else {
                swal("Cancelled", "canceled successfully!", "error");
            }
        });
    }
});

// reset modal
$("#branchModal").on("hidden.bs.modal", function () {
    $("#branchModalLabel").text("add branch");
    $("#save_branch").text("save");
    $(`#branchModal .modal-body input,
               #branchModal .modal-body select`).each((i, e) => (e.value = ""));
    $(".js-error").remove();
    payload = {};
});
