
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- <div class="create_import">
                            <button type="button" class="btn  " id="imports" data-brand-id="{{$brand->id}}"  data-toggle="modal" data-target="#dislikes_import_excel">
                                <i class="icon-share-alternitive"></i> import
                            </button>
                        </div> -->
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <section class="btn_sec mb-4">
                        @can('delete brands')
                            <button type="button" class="btn hvr-sweep-to-right mt-3" id="btn_delete_all_dislikes">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        @endcan

                        <!-- @can('update brands')
                            <button type="button" class="btn hvr-sweep-to-right mt-3" id="btn_restore_all_dislikes">
                                <i class="fas fa-trash-restore"></i> Restore
                            </button>
                        @endcan

                        @can('update brands')
                            <button type="button" class="btn hvr-sweep-to-right mt-3 btn_edit_all" id="btn_edit_all">
                                <i class="icon-edit-3"></i> Edit Brand
                            </button>
                        @endcan -->

                        @can('read brands')
                            <a id="exportBrandExcel" onclick="exportBrandExcel(event)" class="btn hvr-sweep-to-right mt-3  export">
                                <i class="icon-file-plus"></i> Export
                            </a>
                        @endcan
                    </section>
                </div>
                <div class="card-body">
                    <div class="table-container">
                            <table id="exampleTbldislike" class="table table-loader custom-table">
                                <thead>
                                <tr>
                                    <th> <input type="checkbox" id="select_all_dislike"  name="select_all" data-brand-id="{{$brand->id}}" /></th>
                                    <th class="border-bottom-0">name</th>
                                    <th class="border-bottom-0">country</th>
                                 </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                Remove From Dislike
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 style="color: #fff;"> Are You Sure ? </h6>
                            <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                            <input class="text" type="hidden" id="brand_id" name="brand_id" value=''>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn hvr-sweep-to-right Delete"
                                    data-dismiss="modal">Close</button>
                            <button type="button" id="submit_delete_all" class="btn hvr-sweep-to-right Active">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="modal fade" id="restore_influencers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                Restore Influencers
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 style="color: #fff;"> Are You Sure you want to restore influencer ? </h6>
                            <input class="text" type="hidden" id="restore_all_id" name="restore_all_id" value=''>
                            <input class="text" type="hidden" id="brand_id" name="brand_id" value=''>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="submit_restore_influe_all" class="btn hvr-sweep-to-right Active">Restore</button>
                        </div>
                    </div>
                </div>
            </div> -->

@push('js')
<script>


    let disliketable = null;

        $(document).ready(function (){
            let disLikeReload=true;
            $('#pills-deslike-tab').on('click',function (){
            let selectedIdsDisLike = [];
            if(disLikeReload==true){
				$('#exampleTbldislike').on('processing.dt', function (e, settings, processing) {
					$('#processingIndicator').css('display', 'none');
						if (processing) {$("#exampleTbldislike").addClass('table-loader').show();}
						else {$("#exampleTbldislike").removeClass('table-loader').show();}
				})
				
                disliketable = $('#exampleTbldislike').DataTable({
                    fixedHeader: {
                        header: true,
                    },
                    lengthChange: true,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'colvis',
                            columns: 'th:nth-child(n+2)'
                        }
                    ],
                    'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                    // 'aaSorting': [[1, 'asc']],
                    ajax: {
                        url :'/dashboard/dislike/{{$brand->id}}',
                        headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                        data: function (d) {
                            //console.log(d);
                            d.status_val = $('#status_id_search').val();
                            d.start_date = $('#startDateSearch').val();
                            d.end_date = $('#endDateSearch').val();
                        }
                    },
                    columns: [
                        {
                            "data": "ids",
                            sortable:false,
                            render:function (data){
                                return `<input type="checkbox" class="boxDislike"  name="ids[]" value="${data.influencer_id}" data-brand-id="${data.brand_id}" />`;
                            }
                        },
                        {
                            data: 'name',
                            render: function(data){
                                return `
                                    <span class="_username_influncer">${data}</span>
                                `
                            }
                        },
                        {
                            data: 'country',
                            render: function(data){
                                return `
                                    <span class="_username_influncer">${data}</span>
                                `
                            }
                        },
                    ],
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    language: {
                        searchPlaceholder: 'Search',
                        sSearch: '',
                    }
                });
                disLikeReload=false
            }

            $('#pills-deslike-tab').on('click', function(){
                disliketable.ajax.reload();
            });


            $('#exampleTbldislike input[id="select_all_dislike"]').click(function () {
                $('#exampleTbldislike td input.boxDislike').prop('checked', this.checked);
            });

            // $('.restore_dis').click(function (){

            //     selectedIdsDisLike = $("#exampleTbldislike td input.boxDislike:checkbox:checked").map(function(){
            //         return $(this).val();
            //     }).toArray();
            //     if(selectedIdsDisLike.length){
            //         swalFavourite(selectedIdsDisLike)
            //     }
            //     else{
            //         Swal.fire("error", "Please select Influncer to restore", "error");
            //     }
            // })

            })

            $('#btn_delete_all_dislikes').click(function (){
                console.log("btn delete all dislikes");
                selectedIds = $("#exampleTbldislike td input.boxDislike:checkbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                if(selectedIds.length)
                    swalDelsub(selectedIds)
                else
                    Swal.fire("error", "please select brands first", "error");
            })

            function swalDelsub(id){
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
                }).then(function(result){
                    if (result.isConfirmed){
                        let reqUrl = ``;
                        if(typeof id == "number")
                            reqUrl = `/dashboard/sub-brands/${id}`;
                        else if(typeof id == "object")
                            reqUrl = `/dashboard/addtofavourite/bulk/delete`;
                    let brand_id=$('#brand_me_id').val();
                        $.ajax({
                            url:reqUrl,
                            type:'delete',
                            data:{id,brand_id},
                            headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                            success:(data)=>{
                                if(data.status){
                                    disliketable.ajax.reload()
                                    for (let statictic in data.stat){
                                        let elId = data.stat[statictic].id;
                                        $(`#${elId}`).find('.counters').text(data.stat[statictic].count)
                                    }
                                    let list = data.message.map((msg)=>`<li>${msg}</li>`).toString();

                                    Swal.fire("warning!",`<ul>${list}</ul>`, "warning");
                                }

                            },
                            error:()=>{
                                Swal.fire("error", "something went wrong please reload page", "error");
                            }
                        })
                    } else {
                        Swal.fire("Canceled", "Canceled Successfully!", "error");
                    }
            })
        }
});

//     function swalFavourite(id, redirect=""){
//         Swal.fire({
//             title: "Are you sure?",
//             text: "Restore Influencer To Favourite List",
//             type: "warning",
//             showCancelButton: true,
//             confirmButtonColor: '#DD6B55',
//             confirmButtonText: 'Yes, I am sure!',
//             cancelButtonText: "No, cancel it!",
//             closeOnConfirm: false,
//             closeOnCancel: false
//         }).then((result)=>{
//         if (result.isConfirmed){
//             let reqUrl = ``;
//             if(typeof id == "number")
//                 reqUrl = `/dashboard/addtofavourite/${id}`;
//             else if(typeof id == "object")
//                 reqUrl = `/dashboard/addtofavourite/bulk/delete`;

//             $.ajax({
//                 url:reqUrl,
//                 type:'delete',
//                 data:{id},
//                 headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
//                 success:()=>{
//                     if(redirect !== ''){
//                         window.location.href = redirect;
//                     }
//                     if(typeof id == "number"){

//                         let row = $(`#del-${id}`).parents('tr');
//                         let child = row.next('.child');
//                         row.remove();
//                         child.remove();
//                         return "done";
//                     } else if(typeof id == "object"){

//                         for (let i of id){
//                             let row = $(`#del-${i}`).parents('tr');
//                             let child = row.next('.child');
//                             row.remove();
//                             child.remove();
//                             disliketable.ajax.reload();
//                         }
//                     }
//                     Swal.fire("Add To Favourite!", "Add To Favourite Successfully!", "success");
//                 },
//                 error:()=>{
//                     Swal.fire("error", "Something went wrong please reload page", "error");
//                 }
//             })
//         } else {
//             Swal.fire("Cancelled", "Cancelled successfully!", "error");
//         }
//     })
// }
    </script>
@endpush
