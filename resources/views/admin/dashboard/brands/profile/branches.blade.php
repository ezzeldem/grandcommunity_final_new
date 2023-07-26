@if (Request::segment(3) != 'groups')
@endif
<div class="filters text-center mb-3 row">
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
        <select id="status_id_search" class="form-control select2">
            <option selected disabled>Select Status</option>
            <option value="1">Active</option>
            <option value="0">InActive</option>
        </select>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
        <select id="branch_country_id_search" class="form-control select2">
            <option selected disabled>Select Country</option>
            @if (isset($brand))
                @foreach (getBrandCountries($brand) as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            @else
                @foreach ($subbrand->country_id as $country)
                    <option value="{{ country($country)->id }}">{{ country($country)->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
        <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="go_search_branch">
            <i class="fab fa-searchengin mr-1"></i>Search
        </button>
        <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="go_reset_branche_filters">
            <i class="fab fa-searchengin mr-1"></i>Reset
        </button>
    </div>
    <div class="col-md-12">
        <div class="search_reset_btns">
            <button type="button" class="btn mt-3 mr-1 add_branch_brand text-white hvr-sweep-to-right"
                data-toggle="modal" data-target="#add_branch">
                Add New Branch
            </button>
            <button type="button" class="btn mt-3 text-white hvr-sweep-to-right" id="btn_delete_all_branch">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
            <a onclick="exportBrandBranchExcel(event)" class="btn export ml-2 mt-3 text-white hvr-sweep-to-right">
                <i class="fas fa-file-download"></i> Export
            </a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <div class="zoom-container show_brands">
        <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
            <i class="fas fa-expand"></i>
        </button>
    </div>
    <table id="brand_branch_new" class="table table-loader custom-table dataTable display">
        <thead>
            <tr>
                <th class="border-bottom-0">
                    <input name="select_all" id="select_all" type="checkbox" />
                </th>
                <th class="border-bottom-0">Name</th>
                <th class="border-bottom-0">Brand</th>
                <th class="border-bottom-0">Country</th>
                <th class="border-bottom-0">State</th>
                <th class="border-bottom-0">City</th>
                <th class="border-bottom-0">Status</th>
                <th class="border-bottom-0">Created At</th>
                <th class="border-bottom-0">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@include('admin.dashboard.brands.models.bulk_delete_branch_modal')
@include('admin.dashboard.brands.models.add_branch_modal')

@push('js')
    <script>
        //DELETE BRAND
        $(document).on('click', '.delRowBranch', function() {
            swalDel_2($(this).attr('data-id'));
        });

        function swalDel_2(id) {
            Swal.fire({
                title: "Are you sure you want to delete?",
                text: "You won't be able to restore this data",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    var brand_id = $('#brand_me_id').val()

                    $.ajax({
                        url: `/dashboard/brands/deleteBrandBranch/${id}`,
                        data: {
                            brand_id
                        },
                        type: 'post',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (data) => {
                            if (data.status) {
                                branchtable.ajax.reload();
                                for (let statictic in data.stat) {
                                    let elId = data.stat[statictic].id;
                                    $(`#${elId}`).find('.counters').text(data.stat[statictic].count)
                                }
                                Swal.fire("Deleted!", "Deleted Successfully!", "success");
                            } else {
                                Swal.fire("Warning!", data.message, "warning");

                            }
                        },
                        error: () => {
                            Swal.fire("Error", "Something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Canceled", "Canceled Successfully!", "error");
                }
            })
        }


        //Switch
        $('#brand_branch_new tbody').on('change', '.switch_toggle', function(event) {
            let id = $(this).data('id');
            activeToggle_2(id);
        });

        //active toggle request
        function activeToggle_2(id) {
            $.ajax({
                url: `/dashboard/brands/toggle-brand-branch/${id}`,
                type: 'post',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    Swal.fire("Updated!", "Status Changed Successfully!", "success");
                    branchtable.ajax.reload();

                },
                error: () => {
                    Swal.fire("Error", "Something went wrong please reload page", "error");
                }
            })
        }

        // add branch saveBranch (script) in modal branch

        //// **hint script bulk delete in modal bulk //////

        let reload_branche = true;
        let branchtabl = '';


        $('#pills-branches-tab').on('click', function() {
            reloadBrancheDatatable();
        });
        $(document).on('click', '.add_branch_brand', function() {
            $('#branch_id').val('')
            $('#branch_country').val('');
            $('#branch_state').html(`<option value="">Select</option>`);
            $('#branch_city').html(`<option value="">Select</option>`);
            $('#address').val('');
            $('#branch_status').val(null).trigger('change');
            $('#subbrandss').val(null).trigger('change');
            $('#branch_name').val('');
            $('#save_branch').text('Save')
            $('#exampleModalLabel').text('Add Branch')
            $('#save_branch').removeClass('btn-warning').addClass('btn-primary')
        })



        //FUNCTION SWAL TO DELETE Branch


        //BRAND BRNACHES DATATABLE RENDER
        let reloadBrancheDatatable = function() {
            $('#brand_branch_new').dataTable().fnClearTable();
            $('#brand_branch_new').dataTable().fnDestroy();
            reload_branche = false;
            let brand_status = true;
            let subbrand_status = true;
            brand_status = '{{ isset($brand) }}';
            subbrand_status = '{{ $subbrand->id ?? 0 }}';
            if ($("#route_sub_brand_id").val() == 0) {
                route = "/dashboard/get-brand-branches/{{ $brand->id ?? 0 }}"
            } else {
                route = "/dashboard/get-sub-brand-branches/{{ $subbrand->id ?? 0 }}"
            }

            $('#brand_branch_new').on('processing.dt', function(e, settings, processing) {
                $('#processingIndicator').css('display', 'none');
                if (processing) {
                    $("#brand_branch_new").addClass('table-loader').show();
                } else {
                    $("#brand_branch_new").removeClass('table-loader').show();
                }
            })
            branchtable = $('#brand_branch_new').DataTable({
                lengthChange: true,
                "processing": true,
                "serverSide": true,
                responsive: true,
                searching: true,
                dom: 'Blfrtip',
                "buttons": [
                    'colvis',
                ],
                'columnDefs': [{
                    'orderable': false,
                    'targets': 0
                }],
                'aaSorting': [
                    [6, 'desc']
                ],
                "ajax": {
                    url: route,
                    data: function(d) {
                        console.log(d);
                        d.status_val = $('#status_id_search').val();
                        d.country_val = $('#branch_country_id_search').val();
                    }
                },
                "columns": [{
                        "data": "id",
                        "sortable": false,
                        "orderable": false,
                        render: function(data, type) {
                            return '<input type="checkbox"  value="' + data + '" class="box1" >';
                        }
                    },
                    {
                        "data": "name",
                        render: function(data) {
                            return `
                            <span class="_username_influncer">${data}</span>
                        `
                        }
                    },
                    {
                        "data": "sub_brand_name",
                        render: function(data) {
                            return `
                            <span class="_username_influncer">${data}</span>
                        `
                        }
                    },
                    {
                        "data": "country",
                        render: function(data) {
                            return `
                            <span class="_country_table">${data}</span>
                        `
                        }
                    },
                    {
                        "data": 'state',
                        render: function(data) {
                            return `
                            <span class="_country_table">${data}</span>
                        `
                        }
                    },
                    {
                        "data": "city",
                        render: function(data) {
                            return `
                            <span class="_country_table">${data}</span>
                        `
                        }
                    },
                    {
                        "data": 'active_data',
                        "className": 'switch_parent',
                        render: function(data, type) {
                            if (data.active == 1) {
                                return `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle" checked data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="active" ></label>`
                            } else {
                                return `<input type="checkbox" id="'switch-'${data.id}" class="switch_toggle"  data-id="${data.id}"><label class="switch" for="'switch-'${data.id}" title="inactive"></label>`
                            }
                        }
                    },
                    {
                        "data": "created_at",
                        render: function(data) {
                            return `
                            <span class="_createdAt_table"> <i class="fa-solid fa-calendar"></i> -  ${data} </span>
                        `
                        }
                    },
                    {
                        "data": "id",
                        'className': "actions",
                        render: function(data, type) {
                            let route_edit = 'branches/' + data + '/edit'
                            return `<td>
                        @can('update brands')
                        <button style="background:transparent !important;width:2px !important;" class="btn btn-success mt-2 mb-2 edit_branch_brand white-text" data-toggle="modal" data-target="#add_branch" data-id="${data}" >
                            <i class="far fa-edit text-success" style="font-size: 16px;"></i>
                            </button>
                        @endcan
                        @can('delete brands')
                        <button style="background:transparent !important;width:2px !important;" class="btn btn-danger mt-2 mb-2 delRowBranch white-text" id="del-${data}" data-id="${data}" >
                            <i class="far fa-trash-alt text-danger" style="font-size: 16px;"></i>
                        </button>
                        @endcan

                    </td>`;
                        }
                    },

                ],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            });
        }


        $(document).ready(function() {
            @if (isset($subbrand))
                reloadBrancheDatatable();
            @endif

            ////////////// start filter by status ///////////////////
            $('#go_search_branch').on('click', function() {
                console.log(3);
                branchtable.ajax.reload();
            })

            $(document).on('click', '#go_reset_branche_filters', function() {
                $('#status_id_search').val(null).trigger('change');
                $('#branch_country_id_search').val(null).trigger('change');
                branchtable.ajax.reload();
            })
        });


        //export
        function exportBrandBranchExcel(event) {
            event.preventDefault()
            let visibleColumns = []
            let selected_ids = [];
            let brand_id = $('#brand_id').val();
            console.log(brand_id)

            $("#brand_branch_new input[type=checkbox]:checked").each(function() {
                if (this.value != 'on')
                    selected_ids.push(this.value);
            });

            branchtable.columns().every(function() {
                var visible = this.visible();


                if (visible) {
                    if ((this.header().innerHTML != 'Actions')) {
                        var header = this.header().innerHTML.trim();
                        if ((header != '<input name="select_all" id="select_all" type="checkbox">')) {
                            let text = header.toLowerCase().split(' ').join('_')
                            visibleColumns.push(text)
                        }
                    }
                }
            });
            window.open(
                `/dashboard/brand/branches_export/${brand_id}?visibleColumns=${visibleColumns}&selected_ids=${selected_ids}`
            );
        }


        $(document).on('click', '.edit_branch_brand', function() {
            var id = $(this).data('id');
            $('#branch_id').val($(this).data('id'))
            $('#save_branch').text('Edit')
            $('#exampleModalLabel').text('Edit Branch')
            $('#save_branch').removeClass('btn-primary').addClass('btn-warning')
            if (id != null && id != '') {

                $.ajax({
                    url: `/dashboard/brands/get-brand-branch-data/${id}`,
                    type: 'get',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        var listItems = ""
                        var listItemscity = ""
                        var subBrandIems = ""
                        $.each(data.data.state_array, function(key, value) {
                            listItems += "<option value='" + key + "'>" + value + "</option>";
                        });
                        $.each(data.data.city_array, function(key, value) {
                            listItemscity += "<option value='" + key + "'>" + value +
                                "</option>";
                        });
                        if (data.data.sub_brands.length > 0) {
                            subBrandIems += '<option selected disabled>Select Sub-brand</option> ';

                            $.each(data.data.sub_brands, function(key, value) {
                                subBrandIems += (value.id == data.data.sub_brand_id) ?
                                    "<option value='" + value.id + "' selected>" + value.name +
                                    "</option>" :
                                    "" + "<option value='" + value.id + "'>" + value.name +
                                    "</option>";
                            });
                        }

                        // -----------------------------------------

                        getSubbrandCountriesData(data.data.sub_brand_id, "branch_country", data.data
                            .country_id)

                        // -----------------------------------------
                        $("#branch_state").html(listItems);
                        $("#branch_city").html(listItemscity);
                        $('#branch_name').val(data.data.name);
                        // $('#branch_country').val(data.data.country_id);
                        // $('#branch_city').val(data.data.city_id);
                        $('#branch_state').val(data.data.state_id);
                        $('#branch_status').val(data.data.status);
                        $('#address').val(data.data.address);
                        $('#subbrandss').html(subBrandIems);


                        let defaultOption =
                            `<option value='' selected disabled>Select</option>`;
                        $("#branch_city").prepend(defaultOption);

                        $('#branch_city option').each(function() {
                            if ($(this).val() == data.data.city_id) {
                                $(this).attr('selected', 'selected');
                            }
                        });
                    },
                    error: ({
                        data
                    }) => {
                        console.log(data, 2020)
                        Swal.fire("Error", "Something went wrong please reload page", "error");
                    }
                })
            }
        })
    </script>
@endpush
