@include('admin.dashboard.influencers.models.import_excel')
@if(\App\Models\Subbrand::count())
<section class="btn_sec">
{{--    @can('delete sub_brands')--}}
{{--    <button type="button" class="btn delete_all mt-3" id="btn_delete_all"><i class="fas fa-trash-alt"></i> Delete</button>--}}
{{--    @endcan--}}

{{--    @can('update sub_brands')--}}
{{--    <button type="button" class="btn btn_edit_all mt-3" id="btn_edit_all">--}}
{{--        <i class="fas fa-edit"></i> Edit Selected--}}
{{--    </button>--}}
{{--    @endcan--}}

    @can('read sub-brands')
        <a id="exportSubBrandExcel" class="btn hvr-sweep-to-right mt-3" onclick="exportSubBrandExcel(event)" style="background: #292828;"><i class="fas fa-file-download"></i> Export</a>
    @endcan
</section>
@endif
@push('js')
    <script>
        function exportSubBrandExcel(event){
            event.preventDefault()
            let visibleColumns = []
            let selected_ids = getCheckedItemsInDataTableFromSession();


            subBrandTbl.columns().every( function () {
                var visible = this.visible();


                if (visible){
                    if((this.header().innerHTML != 'Actions')){
                        let text = this.header().getAttribute('data-tablehead');
                        if(text !=null){
                            visibleColumns.push(text)
                        }
                    }
                }
            });
            window.open(`/dashboard/sub-brand/export?visibleColumns=${visibleColumns}&selected_ids=${selected_ids}`);
        }
    </script>
@endpush
