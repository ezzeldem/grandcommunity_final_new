@if(\App\Models\Brand::count())
    <section class="btn_sec mb-4" style="display: none">
        @can('delete brands')
            <button type="button" class="btn hvr-sweep-to-right mt-3 " id="btn_delete_all">
                <i class="fas fa-trash-alt"></i> Delete
            </button>

        @endcan
{{--        <button type="button" class="btn hvr-sweep-to-right mt-3 restore_dis" id="restore_dis">--}}
{{--            <i class="fa-solid fa-trash-can-arrow-up"></i> favourite--}}
{{--            </button>--}}

       @can('update brands')
            <button type="button" class="btn hvr-sweep-to-right mt-3 btn_edit_all" id="btn_edit_all">
                <i class="icon-edit-3"></i> Edit Company
            </button>
        @endcan

        @can('read brands')
            <a id="exportBrandExcel" onclick="exportBrandExcel(event)" class="btn mt-3  export">
                <i class="icon-file-plus"></i> Export
            </a>
            <!-- <a href="{{route('dashboard.brands.export')}}" class="btn hvr-sweep-to-right mt-3  export">
                <i class="icon-file-plus"></i> Export
            </a> -->
        @endcan
    </section>
@endif
