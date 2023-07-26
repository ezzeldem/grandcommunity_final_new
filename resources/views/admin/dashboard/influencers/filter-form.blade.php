@if(\App\Models\Influencer::count())
<style>
.select2-dropdown.select2-dropdown--above,
.select2-dropdown.select2-dropdown--below {
  width: 270px !important;
}

.select2-container--default .select2-results>.select2-results__options {
  width: 100% !important;
}

</style>
<section class="btn_sec mb-6">
  @can('delete influencers')
  <button type="button" class="btn hvr-sweep-to-right delete_all mt-3" id="btn_delete_all">
    <i class="icon-trash-2"></i> Delete
  </button>
  @endcan

  @can('create influencers')
  <button type="button" class="btn hvr-sweep-to-right mt-3 add_to_list" id="add_to_list">
    <i class="icon-feather"></i> Add to Brand Favourite
  </button>
  @endcan

  @can('update influencers')
  <button type="button" class="btn hvr-sweep-to-right  btn_edit_all mt-3" id="btn_edit_all">
    <i class="icon-edit-3"></i> Edit Selected
  </button>
  @endcan

  @can('read influencers')
  <a href="javascript:void(0)" class="btn hvr-sweep-to-right mt-3  export" id="exportInfluencerExcel"
    onclick="exportInfluencerExcel(event)">
    <i class="icon-attach_file"></i> Export
  </a>
  <input type="hidden" id="export_influe_all_id">
  @endcan
</section>
@endif
