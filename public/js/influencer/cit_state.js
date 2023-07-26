function getStatesData(val, idselect) {
    $.ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        url: "/dashboard/state/" + val,
        corssDomain: true,
        dataType: "json",
        success: function (data) {
            var listItems = "";
            listItems = "<option value=''>Select</option>";
            $.each(data.data, function (key, value) {
                listItems +=
                    "<option value='" +
                    value.id +
                    "' >" +
                    value.name +
                    "</option>";
            });
            $("#" + idselect).html(listItems);
        },
        error: function (data) {},
    });
}

function getCityData(val, idselect) {
    $.ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        url: "/dashboard/city/" + val,
        corssDomain: true,
        dataType: "json",
        success: function (data) {
            var listItems = "";

            listItems = "<option value=''>Select</option>";

            $.each(data.data, function (key, value) {
                listItems +=
                    "<option value='" + key + "'>" + value + "</option>";
            });
            $("#" + idselect).html(listItems);
        },

        error: function (data) {},
    });
}

// function getSubBrandCountryData(val, brandId, subBrandId = null, url = null){
//     $("#subbrandss").val('')
//     console.log('brandId', brandId);
//     $.ajax({
//         type: "POST",
//         contentType: "application/json; charset=utf-8",
//         url:  "/dashboard/get-subbrand-by-brand/"+val+"/"+brandId+"?sub_brand_id="+subBrandId+'&url='+url,
//         corssDomain: true,
//         dataType: "json",
//         headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
//         data:{'subBrandId':subBrandId, 'url': url},
//         success: function (data) {
//             console.log('country data response', data);
//             var listItems = "";

//             listItems = "<option value=''>Choose One</option>";

//             $.each(data.data,function(key,value){

//                 listItems+= "<option value='" + value.id + "'>" + value.name + "</option>";

//             });
//             $("#subbrandss").html(listItems);
//         },

//         error : function(data) {

//         }
//     });
// }

function getSubbrandCountriesData(val, idselect, selectedCountryID = 0) {
    $.ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        url: "/dashboard/get-subbrand-countries/" + val,
        corssDomain: true,
        dataType: "json",
        success: function (data) {
            var listItems = "";
            listItems = "<option value=''>Select</option>";

            $.each(data?.countries, function (indx, country) {
                listItems += `<option value='${country.id}' ${
                    selectedCountryID == country.id ? "selected" : ""
                }>${country.name}</option>`;
            });

            $("#" + idselect).html(listItems);
        },

        error: function (data) {},
    });
}
