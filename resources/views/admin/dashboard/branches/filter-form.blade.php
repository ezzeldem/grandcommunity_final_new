
@include('admin.dashboard.influencers.models.import_excel')

{{--</section>--}}
@if(\App\Models\Branch::count())
<section class="btn_sec ">
{{--    @can('delete branches')--}}
{{--    <button type="button" class="btn delete_all mt-3" id="btn_delete_all"><i class="fas fa-trash-alt"></i> Delete </button>--}}
{{--    @endif--}}

{{--    @can('update branches')--}}
{{--        <button type="button" class="btn btn_edit_all mt-3" id="btn_edit_all">--}}
{{--            <i class="fas fa-edit"></i> Edit Selected--}}
{{--        </button>--}}
{{--    @endif--}}

    @can('read branches')
        <a onclick="exportBranchExcel(event)" class="btn mt-3">
            <i class="fas fa-file-download"></i> Export
        </a>
    @endif
</section>
@push('js')
    <script>
        //export
        function exportBranchExcel(event){
          
            event.preventDefault()
            let visibleColumns = []
            let selected_ids = [];

            $("#exampleTbl input[type=checkbox]:checked").each(function() {
                if(this.value!='on')
                    selected_ids.push(this.value);
            });
            subBrandTbl.columns().every( function () {
                var visible = this.visible();

                if (visible){
                    if((this.header().innerHTML != 'Actions')){
                        var header=this.header().innerHTML.trim();
                        if((header != '<input type="checkbox" id="select_all" name="select_all">' )){
                            let text = header.toLowerCase().split(' ').join('_')
                            visibleColumns.push(text)
                        }
                    }

                }
            });
            window.open(`/dashboard/branches.export?visibleColumns=${visibleColumns}&selected_ids=${selected_ids}`);
        }
    </script>
@endpush
@endif


