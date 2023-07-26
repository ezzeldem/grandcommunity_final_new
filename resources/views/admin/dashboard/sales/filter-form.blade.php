
@include('admin.dashboard.influencers.models.import_excel')

@if(\App\Models\Admin::where('role','sales')->count())
<section class="btn_sec text-center mb-4">
    @can('delete sales')
    <button type="button" class="btn delete_all mt-3" id="del-All"><i class="icon-trash-2"></i> Delete</button>
    @endcan

    @can('update sales')
    <button type="button" class="btn btn_edit_all mt-3" id="btn_edit_all">
        <i class="icon-edit-3"></i> Edit Selected
    </button>
    @endcan

    @can('read sales')
    <a href="{{route('dashboard.sales.export')}}" class="btn mt-3 export">
        <span class="icon-attach_file"></span> Export
    </a>
    @endcan

</section>
@endif
