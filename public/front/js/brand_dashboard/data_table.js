$("#table_id").DataTable({
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true,
    bInfo: false,
    scrollResize: true,
    searching: false,
    fixedColumns: {
        leftColumns: 1,
        rightColumns: 1,
    },
    columnDefs: [
        {
            orderable: false,
            className: "select-checkbox",
            targets: 0,
            checkboxes: {
                selectRow: true,
            },
        },
    ],
    select: {
        style: "multi",
    },
    order: [[1, "asc"]],
});
$(".data_table .dataTables_length label").append($(".delete_div"));
$(".data_table .dataTables_length ").append($(".add_campaign"));

$("#table_campaign_list").DataTable({
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true,
    bInfo: true,
    scrollResize: true,
    searching: true,
    fixedColumns: {
        leftColumns: 1,
        rightColumns: 1,
    },
    columnDefs: [
        {
            orderable: false,
            className: "select-checkbox",
            targets: 0,
            checkboxes: {
                selectRow: true,
            },
        },
    ],
    select: {
        style: "multi",
    },
    order: [[1, "asc"]],
});

$(".data_table_campaign_list .search_numEntry ").append(
    $(".dataTables_filter")
);
$(".data_table_campaign_list .search_numEntry ").append(
    $(".dataTables_length label")
);
$(".data_table_campaign_list .dataTables_length ").append(
    $(".search_numEntry ")
);
$(".data_table_campaign_list .dataTables_length ").append(
    $(".delete_add_campaign ")
);

$("#table_campaign_list2").DataTable({
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true,
    bInfo: true,
    scrollResize: true,
    searching: true,
    fixedColumns: {
        leftColumns: 1,
        rightColumns: 1,
    },
    columnDefs: [
        {
            orderable: false,
            className: "select-checkbox",
            targets: 0,
            checkboxes: {
                selectRow: true,
            },
        },
    ],
    select: {
        style: "multi",
    },
    order: [[1, "asc"]],
});

$(".data_table_campaign_list2 .search_numEntry2 ").append(
    $("#table_campaign_list2_filter")
);
$(".data_table_campaign_list2 .search_numEntry2 ").append(
    $("#table_campaign_list2_length label")
);
$(".data_table_campaign_list2 .dataTables_length ").append(
    $(".search_numEntry2 ")
);
$(".data_table_campaign_list2 .dataTables_length").append(
    $(".delete_add_campaign2 ")
);

$("#table_edit_campaign").DataTable({
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true,
    bInfo: false,
    scrollResize: true,
    searching: false,
    dom: "rtip",
    fixedColumns: {
        leftColumns: 1,
        rightColumns: 1,
    },
    columnDefs: [
        {
            orderable: false,
            className: "select-checkbox",
            targets: 0,
            checkboxes: {
                selectRow: true,
            },
        },
    ],
    select: {
        style: "multi",
    },
    order: [[1, "asc"]],
});
