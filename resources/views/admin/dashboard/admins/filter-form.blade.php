

@include('admin.dashboard.influencers.models.import_excel')

@if(\App\Models\Admin::where('role','admin')->count())
<section class="btn_sec text-center mb-6 card-body">
{{--    @can('delete admins')--}}
{{--        <button type="button" class="btn delete_all mt-3" id="del-All"><i class="fas fa-trash-alt"></i> Delete </button>--}}
{{--    @endcan--}}

{{--    @can('update admins')--}}
{{--        <button type="button" class="btn btn_edit_all mt-3" id="btn_edit_all">--}}
{{--            <i class="fas fa-edit"></i> Edit Selected--}}
{{--        </button>--}}
{{--    @endcan--}}

{{--    @can('read admins')--}}
{{--        <a href="{{route('dashboard.admins.export')}}" class="btn export mt-3">--}}
{{--            <i class="fas fa-file-download"></i> Export--}}
{{--        </a>--}}
{{--    @endcan--}}

    @can('delete admins')
        <button type="button" class="btn mt-3" id="del-All"><i class="fas fa-trash-alt"></i> Delete </button>
    @endcan

    @can('update admins')
        <button type="button" class="btn mt-3" id="btn_edit_all">
            <i class="icon-edit-3"></i> Edit Selected
        </button>
    @endcan

    @can('read admins')
        <a href="{{route('dashboard.admins.export')}}" class="btn mt-3  export">
            <i class="icon-file-plus"></i> Export
        </a>
    @endcan

</section>
@endif
