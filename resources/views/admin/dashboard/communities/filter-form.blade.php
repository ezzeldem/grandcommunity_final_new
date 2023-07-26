@include('admin.dashboard.influencers.models.import_excel')

@if(\App\Models\Admin::where('role','community')->count())
<section class="btn_sec text-center mb-4 ">
    @can('delete operations')
    <button type="button" class="btn mt-3" id="del-All"><i class="fas fa-trash-alt"></i> Delete </button>
    @endcan
    @can('update community')
    <button type="button" class="btn mt-3" id="btn_edit_all">
        <i class="icon-edit-3"></i> Edit Selected
    </button>
    @endcan

    @can('read community')
    <a href="{{route('dashboard.community.export')}}" class="btn mt-3  export">
        <i class="icon-file-plus"></i> Export
    </a>
    @endcan
</section>
@endif
