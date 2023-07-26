// jQuery.
$(function() {
    // Reference the tab links.
    const tabLinks = $('#tab-links li a');

    // Handle link clicks.
    tabLinks.click(function(event) {
        var $this = $(this);

        // Prevent default click behaviour.
        event.preventDefault();

        // Remove the active class from the active link and section.
        $('#tab-links a.active, section.active').removeClass('active');

        // Add the active class to the current link and corresponding section.
        $this.addClass('active');
        $($this.attr('href')).addClass('active');
    });
});

function campaignInfluencerStatus(status){
    switch (status.value) {
        case 0 :
            return `<span class="badge badge-pill badge-danger">${status.name}</span>`;
        case 1 :
            return `<span class="badge badge-pill badge-primary">${status.name}</span>`;
        case 2 :
            return `<span class="badge badge-pill badge-success">${status.name}</span>`;
        case 3 :
            return `<span class="badge badge-pill badge-secondary">${status.name}</span>`;
        case 4 :
            return `<span class="badge badge-pill badge-info">${status.name}</span>`;
        case 5 :
            return `<span class="badge badge-pill badge-pink">${status.name}</span>`;
        case 6 :
            return `<span class="badge badge-pill badge-teal">${status.name}</span>`;
        case 7 :
            return `<span class="badge badge-pill badge-warning">${status.name}</span>`;
        case 8 :
            return `<span class="badge badge-pill badge-purple">${status.name}</span>`;
    }
}



let selectedIds = [];
function swalDel(id, redirect=""){
    // alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result)=>{
        if (result.isConfirmed){
            let reqUrl = ``;
            if(typeof id == "number")
                reqUrl = `/dashboard/campaign-influ/${id}`;
            else if(typeof id == "object")
                reqUrl = `/dashboard/campaign-influ/bulk/delete`;

            $.ajax({
                url:reqUrl,
                type:'delete',
                data:{id},
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:()=>{
                    if(redirect !== ''){
                        window.location.href = redirect;
                    }
                    $('#exampleTbl').DataTable().ajax.reload();
                    Swal.fire("Deleted!", "Deleted Successfully!", "success");
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        } else {
            Swal.fire("Cancelled", "canceled successfully!", "error");
        }
    })
}

function swalaupd(id, redirect=""){
    Swal.fire({
        title: "Are you sure?",
        text: "You will Move influncer From binding Status!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result)=>{
        if (result.isConfirmed){
            let reqUrl = ``;
            if(typeof id == "number")
                reqUrl = `/dashboard/campaignupdate-influ/${id}`;
            else if(typeof id == "object")
                reqUrl = `/dashboard/campaignupdate-influ/bulk/update`;

            $.ajax({
                url:reqUrl,
                type:'put',
                data:{id},
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:()=>{
                    if(redirect !== ''){
                        window.location.href = redirect;
                    }
                    if(typeof id == "number"){
                        let row = $(`#del-${id}`).parents('tr');
                        let child = row.next('.child');
                        row.remove();
                        child.remove();
                        return "done";
                    } else if(typeof id == "object"){
                        for (let i of id){
                            let row = $(`#del-${i}`).parents('tr');
                            let child = row.next('.child');
                            row.remove();
                            child.remove();
                        }
                    }
                    Swal.fire("Updated!", "Deleted Successfully!", "success");
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        } else {
            Swal.fire("Cancelled", "canceled successfully!", "error");
        }
    })
}



function updateusertoconfirm(id, redirect=""){

    Swal.fire({
        title: "Are you sure?",
        text: "You will Move influncer From binding Status!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result)=>{
        if (result.isConfirmed){
            let reqUrl = ``;
            if(typeof id == "number")
                reqUrl = `/dashboard/campaignupdate-influncer/${id}`;
            else if(typeof id == "object")
                reqUrl =`/dashboard/campaignupdate-influncer/bulk_update`;

            $.ajax({
                url:reqUrl,
                type:'POST',
                data:{id},
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:()=>{
                    if(redirect !== ''){
                        window.location.href = redirect;
                    }
                    if(typeof id == "number"){
                        let row = $(`#del-${id}`).parents('tr');
                        let child = row.next('.child');
                        row.remove();
                        child.remove();
                        return "done";
                    } else if(typeof id == "object"){
                        for (let i of id){
                            let row = $(`#del-${i}`).parents('tr');
                            let child = row.next('.child');
                            row.remove();
                            child.remove();
                        }
                    }
                    Swal.fire("Updated!", "Deleted Successfully!", "success");
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        } else {
            Swal.fire("Cancelled", "canceled successfully!", "error");
        }
    })
}
//
// delete row
$(document).on('click','.delRow',function (){
    swalDel($(this).data('id'));
});

$(document).on('click','.uprow',function (){
    swalaupd($(this).data('id'));
});
$(document).on('click','.updatebulkconfirm',function (){
    updateusertoconfirm($(this).data('id'));
});





// select all
$('#exampleTbl input[name="select_all"]').click(function () {
    $('#exampleTbl td .check-box1').prop('checked', this.checked);
});

//Clear check all after change page
$('body').on('click', '.pagination a', function(e) {
    if($('#exampleTbl td input:checkbox').prop('checked') == true){
        $('#select_all').prop('checked',false);
    }
});


// delete selected
$('#dele-All').click(function (){
    selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
        return $(this).val();
    }).toArray();
    if(selectedIds.length){
        swalDel(selectedIds)
    }else{
        Swal.fire("warning", "please select ids", "warning");

    }

})

$(document).on('click','#updatebulkconfirm',function (){
    selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
        return $(this).val();
    }).toArray();
    if(selectedIds.length)
    updateusertoconfirm(selectedIds)
    else
        Swal.fire("warning", "please select ids", "warning");
})

// when generate code modal pen
$('.check-modal').click(function (){
    selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
        return $(this).val();
    }).toArray();
    if(!selectedIds.length){
        $('#generate_qr').modal('hide');
        Swal.fire("warning", "please select at least one item", "warning");
    }else{
        $('#generate_qr').find('.influ-count').text(selectedIds.length)
        $('#generate_qr').modal('show');
    }
})

// submit qr
$(document).on('click','#submit-qr_form',function (){
    selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
        return $(this).val();
    }).toArray();
    let generate_types = $("#generate_qr .modal-body input[name='generator']:checkbox:checked").map(function (){
        return $(this).val();
    }).toArray();

    let is_test = $("#generate_qr .modal-body input[name='is_test']:checkbox:checked").val()
    let qrcode_valid_times = $('#qrcode_valid_times').val();
    let visit_or_delivery_date = $('#visit_or_delivery_date').val();
    let reqUrl = `/dashboard/campaign-influ/generate-codes`;

    if(generate_types.length == 0){
        Swal.fire("warning", "please enter Type", "warning");
    }else{
        $.ajax({
            url:reqUrl,
            type:'post',
            data:{users_list:selectedIds,generate_types,qrcode_valid_times,visit_or_delivery_date,is_test},
            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success:()=>{
                window.location.reload();
                Swal.fire("Codes Generated", "Generated Successfully!", "success");
            },
            error:()=>{
                Swal.fire("error", "something went wrong please reload page", "error");
            }
        })
    }

})


//Copy Action

function copyElementToClipboard(element){
    document.execCommand('copy', false, $(element).select());
}
//Delete Secrete
function deleteSecretKey(element, elementId){
    Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result)=>{
        if (result.isConfirmed){
            $.ajax({
                url:`/dashboard/delete-brand-secret/${elementId}`,
                type:'delete',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:()=>{
                    $(element).parent().remove()
                    Swal.fire("Deleted!", "Deleted Successfully!", "success").then(function (){
                        window.location.reload();
                    });
                },
                error:()=>{
                    Swal.fire("error", "something went wrong please reload page", "error");
                }
            })
        } else {
            Swal.fire("Cancelled", "canceled successfully!", "error");
        }
    })
}

//update Secrete
function updateSecret(secret_id){
     let is_active = $(`#active_secret_${secret_id}`).is(':checked') ? 1 : 0;
    let reqUrl = `/dashboard/update_secret_status`;
    $.ajax({
        url:reqUrl,
        type:'post',
        data:{is_active:is_active,id:secret_id},
        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        success:()=>{
           // window.location.reload();
            Swal.fire("Secrete Key ", "Updated Successfully!", "success");
        },
        error:()=>{
            Swal.fire("error", "something went wrong please reload page", "error");
        }
    })
}

//Change Campaign Status

$("#changeStatus").on('click', function (e) {
    e.preventDefault()
    let camp_status_val = $("#camp_status_val").val()
    if (camp_status_val == null){
        Swal.fire("warning", "please select Campaign Status", "warning");
    }else{
        let reqUrl = `/dashboard/update_campaign_status`;
        let status=$("#camp_status_val").val()
        let id= $("#campaign_status_is").val()
        $.ajax({
            url:reqUrl,
            type:'post',
            data:{id:id, status:status},
            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success:()=>{
                Swal.fire("Campaign Status", "Updated Successfully!", "success");
            },
            error:()=>{
                Swal.fire("error", "something went wrong please reload page", "error");
            }
        })
    }
})
