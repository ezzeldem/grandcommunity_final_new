@extends('admin.dashboard.layouts.app')
@section('title','Influencers')
@section('style')
@include('admin.dashboard.layouts.includes.general.styles.index')
<style>
.dataTables_filter {
  display: none;
}

.morelink {
  color: blue !important;
}

.show_influencer {
  color: #bcd0f7;
}

#influe_length {
  display: contents;
  justify-content: space-between;
  margin-bottom: 20px;
  position: relative;
}


#custom {
  border-radius: 2px;
  font-size: .825rem;
  background: #1A233A;
  color: #bcd0f7;
  border: none;
  padding: 5px;
  /*float:right;*/
}

.btn-group,
.btn-group-vertical {
  display: flex !important;
  margin-bottom: 10px !important;
  width: fit-content !important;
}

#influe i {
  font-size: 23px;
}

#influe .actions a i,
#influe .actions button i {
  font-size: 14px;
}

#influe .actions a,
#influe .actions button {
  padding: 4px 12px !important;
}

.my_create {
  display: flex;
  align-items: self-end;
  justify-content: flex-end;
  margin-bottom: -16px;
  gap: 6px;
}

.add_influe {
  display: flex;
  align-items: self-end;
  justify-content: flex-end;
  margin-bottom: -16px;
  gap: 6px;
}

.add_group {
  display: flex;
  align-items: self-end;
  justify-content: flex-end;
  margin-bottom: -16px;
  gap: 6px;
}

.col_change {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0;
  gap: 10px;
}

.select2 {
  width: 100% !important;
}

.hover_country {
  line-height: unset !important;
}

.typeIcons .fa {
  font-size: 14px !important;
  cursor: pointer;
}

.typeIcons .fa.fa-car {
  color: #d93562;
}

.typeIcons .fa.fa-star {
  color: #d9b035;
}

.typeIcons .fa.fa-plane {
  color: #2f8953;
}

.typeIcons .fa.fa-globe {
  color: #9a35d9;
}

.custom-table>tbody td {
  text-align: center !important;
}

td.typeIcons img {
  width: 23px;
  height: 35px;
  object-fit: contain;
}

td.typeIcons {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  flex-direction: row;
  gap: 5px;
}


.item {
  display: inline-block;
  font-size: 85%;
  font-weight: 600;
  line-height: 1;
  white-space: nowrap;
  vertical-align: baseline;
  text-transform: lowercase;
  padding: 1px 0px 1px 6px;
  border-radius: 37px;
  box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px rgb(0 0 0 / 14%), 0 1px 5px rgb(0 0 0 / 12%);
  margin: 0px 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 29px;
  gap: 10px;
  color: #fff;
  background: #202020;
  text-transform: capitalize;
}

.badges_container_text {
  /* display: flex; */
  justify-content: center;
  align-items: center;
  gap: 10px;
}


.badge-item-btn_text {
  height: auto;
  background: inherit;
  padding: 0px 11px;
  border-radius: 50% !important;
  line-height: inherit;
  border: 0;
  border-color: #9B7029;
  color: #fff;
}

.filterFormInfluence-sidebar {
  /*display: unset !important;*/
  padding: 30px 15px 30px 30px !important;

}

</style>
@endsection
@section('page-header')
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Influencers'])
@stop
@section('content')
<div class="card p-3">
  <div class="card-header pb-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h4 class="card-title mg-b-0">Influencers Table</h4>
      @can('create influencers')
      <div class="create_import">
        <a href="{{route('dashboard.influences.create')}}" class="btn "> <i class="icon-plus-circle"></i> Create </a>
        <button type="button" class="btn  " id="imports" data-toggle="modal" data-target="#import_excels">
          <i class="icon-share-alternitive"></i> Import
        </button>
        <button class="btn" id="filterFormInfluencer">
          <i class="fas fa-filter"></i> Show Filter
        </button>
        <div class="badge badge-secondary counterselector"></div>
      </div>
      <!-- <div class="create_import">
            <button style="background:transparent !important;width:2px !important;border:none !important;"  data-toggle="tooltip" data-placement="top" title="Change Influencer"  class=" btn-sm mt-2 mb-2"  id="change_details_influencer_one_or_more">
                <i class="fa-solid fa-user-pen" style="font-size:16px;"></i>
            </button>
        </div> 
      -->
      @endcan
    </div>
    <div class="row pt-4 align-items-end">
      <div class="col-md-6">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul>
            @foreach ($errors->all() as $value)
            <li>{{$value}}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @include('admin.dashboard.influencers.filter-form')
      </div>
      <div class="col-md-6">
        <div class="grand-view-changer">
          <div class="box-icon">
            <span class="icon active" data-show="box-view">
              <i class="fa-solid fa-table-cells-large"></i>
            </span>
            <span class="icon " data-show="box-table">
              <i class="fa-solid fa-list"></i>
            </span>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="card-body px-0">
    <div class="grand-view-show ">
      <div class="view-box " id="box-table">
        <div class="table-container px-0">
          <div class="zoom-container influncer_zoom">
            <button onclick="$('.table-container').fullScreenHelper('toggle');" class="zoom-button">
              <i class="fas fa-expand"></i>
            </button>
          </div>
          <div>
            <div class="badges_container badges_container_text">
            </div>
            <div class="badges_container_multiple badges_container_text" style="">
            </div>
          </div>
          <div class="table-responsive influncers_table">
            <table id="influe" class="table custom-table">
              <thead>
                <tr>
                  <th class="border-bottom-0"><input type="checkbox" name="select_all" id="select_all_dt_items"></th>
                  <th data-tablehead="insta_uname" data-name="user_name" class="border-bottom-0">Username</th>
                  <th data-tablehead="name" data-name="name" class="border-bottom-0">Name</th>
                  <th data-tablehead="image" class="border-bottom-0">Image</th>
                  <th data-tablehead="bio" class="border-bottom-0">bio</th>
                  <th data-tablehead="status" class="border-bottom-0">Status</th>
                  <th data-tablehead="country" class="border-bottom-0">Country</th>
                  <th data-tablehead="gender" class="border-bottom-0">Gender</th>
                  <th data-tablehead="Followers" class="border-bottom-0">Platform</th>
                  <th data-tablehead="completed" class="border-bottom-0">Completed</th>
                  <th data-tablehead="interest" class="border-bottom-0">Interest</th>
                  <th data-tablehead="category_ids" class="border-bottom-0">Category</th>
                  <th data-tablehead="created_at" data-name="created_at" class="border-bottom-0">Created at</th>
                  @if(user_can_control('influencers'))
                  <th>Actions</th>
                  @endif
                </tr>

              </thead>
              <tbody>
              </tbody>

            </table>
          </div>
        </div>
      </div>
      <div class="view-box active" id="box-view">
        <div class="row">
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARMAAAC3CAMAAAAGjUrGAAAAjVBMVEUAAADOESb////KAAC8jAC+jwC9jQDAkwC6hwC7igC+kADl1K3o2bnSs27w59Pu48z17+L59ezj0afu5M3gy5zl1bC4gwDz69rp2779/PjRsmjWun3eyJXUt3T48+nz69nZwIfOrFzGnjHJo0LClxnYvoTKpkzdxpbHnzfPrmDFmyfMqVPUt3fgy6DIoj7XPX04AAAHJ0lEQVR4nO2ba3PjqBJAZ7kgg8GAsLDAlmX5GT9C/v/PWyRnM5nhVs2Hu3M7VdMnVbIejqt1ClqNhL79hfzMN+gAviDopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlHz7D/Iz3wjyM1/CSdQ2uhChw/iHL+FkY84rUa2OPXQgT76CE7tdDbvFxpkNdCRPvoKT2JLDhdRZjoYOZeIrOMm0w9RvPHQcE1/ESTTThwQO48kXcVKjkwLda9PW6OQzMgbvJTr5jNS9Uv4Pd2KcdPZjqzYyGh/idyc2HzcQgREwJ7LNi2UT3jcTccva11q9b4dmmZctULOBcRLfCxHbTVVaH3JDyR3HxUmS7t5bkIcZAsE4MfX5/bR3yaldQ7qxqYx/O+XS7nnInnuY3gPjJDBurx9b28bJJhnX7Nbd8LH3YDkL/+2ffzswTnwlLD/90zMisSlnl9xpvmfdeOJWVDC1PowTyWgvRPw85Os7+2lLRyF6ymCSLIyTxKilgtCPczbSaSc/HElKRP4GSyDRwTjpqmp0Uh1rZa1RQXodSdReBrW0VtVvbHRSsQ4kOhgnA5uNTsTers5dMxzFetq9po+u6c4ruxejkzkbfvE7vwcYJxt20nRO+LrlacbYfL6Ydi/mc8ZmibdrThjVJwZz4w3GyZZdDT0R/qrF8DabzT6c5PXjIPQrJydqrmwLEh2MkzU7BnqI/GzEej3/wcl8sRbmzOOBhiNbg0QH4+TB9ooea95lMy/sByesyTYGXh+p2rMHSHQwTi5sLem+540SW1f94KRyW6Ea3j+oXLMLSHQwTnKmSPSWE6wTXv7kRHohE7c3mnLWAYkOxsmdnTu61dwnbtxl/snJ/OIMT5LrLX05sztIdDBOZqwb6Nlw1XF9zZ3nuxPmrpq/KG42dMhVDEh0ME4q1uRzDjwnU3tyP7QTd2r5dIRuGlaBRAfjRFRuTZuxNfB+dujYhxPWHWY93+QW9EIXrhIg0QE5YT7nUMf1gtci+U91rE+i5gvNXc7Bnv1BTqJg4UJzgm1vPK5ql8S7E5FcvYp8vCJ5eglMgNx8BHFSiypcaU6w/UNERrzcv48B99KTKoqHzWmWXkMlaojwQJxYUS3vNJx5/SbiloRleg72Ns0ykG0UbzU/B3o3lbC/+KXfApATupvR5Wse1VR1IHrYqfHkrWqHHQl1lUdCG0Nnmv5BTjSlbUX1mpPZbGnqYUnOWYr1Z7IcarOczQhfa1q1lIJMSAFxYrITSu2ek+oeOkeUskEZH6xSxHXhXhG+t9N3QB5mwDip6I6K/sKJeBsf/W1k2PGO74Ic84p6E4Rf+ty/aPXnOFGTk/pAiZjbfLkNRDrGmJN5jUQ7F0Qc6smJ+vWP/fuAOPGTk3iaE36q96SXRN1yWX9TRPbkUR9WZH6KkxOQBzwgThwbnRB2qhedJ6rxxIjT7CQM8Y0ivnNt1jU6YQ4iPBAnzdROiJg5khPIgkiyYZf5hZ3zWq5oNyRXa5OTqoEID8TJSzXPtQdZJWKmJzihC+LGbiJ/jpudIWaVneg5e4EID8TJmZ3GkiwnC+9Jn0gwA32tNnQwgaR+3El0mFEzyy0HABAnG3YItBqn3UhrG0lSOLKOduwYEpFNa8dHpvnqE+4wD3hAnCzYm5rK9l6TR9TbnHSZE45Vjmx1fJDlOIG4ZuqNLSDCA3FyY4/ufd50nUfENifdQxLpkFNqNrWon/OpY3dhN4jwQJw8qnuu1LQLjjQ5g+xI4utOdGueyC5nl4bkI3mkE68VyAMeECeHY15IZRrVONe5NGXV05RxU952eb9RY1K5HCDCg7nujIuma0wMS3XWg/c+122yyZ+DPqtliCYf/fjm/xuwOcMxt4s6SOnbFKLPfWWf+5KPIbVeSpO71gnsvS8oJ/XdEDdOL0mNXYZgkpIqmbxiu1zPD/mIuUNJAXLS0jjWqzmR1pb48Y5Ayn9xvP1a23ztGevXSFuY4KDayS0SPW/0YqkvJnXk2SS66RrcX2utOkUiyIWYwDmxB0KW/hxeG6FS8t3QGKON687tZbG/vr0O4wRZoNjAcux27Cd9G2LcOz08hu52l4vFYOSl9dMlp4aZpEQAnfSHhXo2hEisymPjsd84Ep7dyKrtAezNWsD3d2o1PI6X9ZBkMGa5a/XS5EqtGdaX42NQIE+7noC/0xStNsq71DRNcl4ZbcHfRwd38gX5hiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgvzP/A0aCjKLRldwRAAAAABJRU5ErkJggg=="
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARMAAAC3CAMAAAAGjUrGAAAAjVBMVEUAAADOESb////KAAC8jAC+jwC9jQDAkwC6hwC7igC+kADl1K3o2bnSs27w59Pu48z17+L59ezj0afu5M3gy5zl1bC4gwDz69rp2779/PjRsmjWun3eyJXUt3T48+nz69nZwIfOrFzGnjHJo0LClxnYvoTKpkzdxpbHnzfPrmDFmyfMqVPUt3fgy6DIoj7XPX04AAAHJ0lEQVR4nO2ba3PjqBJAZ7kgg8GAsLDAlmX5GT9C/v/PWyRnM5nhVs2Hu3M7VdMnVbIejqt1ClqNhL79hfzMN+gAviDopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlHz7D/Iz3wjyM1/CSdQ2uhChw/iHL+FkY84rUa2OPXQgT76CE7tdDbvFxpkNdCRPvoKT2JLDhdRZjoYOZeIrOMm0w9RvPHQcE1/ESTTThwQO48kXcVKjkwLda9PW6OQzMgbvJTr5jNS9Uv4Pd2KcdPZjqzYyGh/idyc2HzcQgREwJ7LNi2UT3jcTccva11q9b4dmmZctULOBcRLfCxHbTVVaH3JDyR3HxUmS7t5bkIcZAsE4MfX5/bR3yaldQ7qxqYx/O+XS7nnInnuY3gPjJDBurx9b28bJJhnX7Nbd8LH3YDkL/+2ffzswTnwlLD/90zMisSlnl9xpvmfdeOJWVDC1PowTyWgvRPw85Os7+2lLRyF6ymCSLIyTxKilgtCPczbSaSc/HElKRP4GSyDRwTjpqmp0Uh1rZa1RQXodSdReBrW0VtVvbHRSsQ4kOhgnA5uNTsTers5dMxzFetq9po+u6c4ruxejkzkbfvE7vwcYJxt20nRO+LrlacbYfL6Ydi/mc8ZmibdrThjVJwZz4w3GyZZdDT0R/qrF8DabzT6c5PXjIPQrJydqrmwLEh2MkzU7BnqI/GzEej3/wcl8sRbmzOOBhiNbg0QH4+TB9ooea95lMy/sByesyTYGXh+p2rMHSHQwTi5sLem+540SW1f94KRyW6Ea3j+oXLMLSHQwTnKmSPSWE6wTXv7kRHohE7c3mnLWAYkOxsmdnTu61dwnbtxl/snJ/OIMT5LrLX05sztIdDBOZqwb6Nlw1XF9zZ3nuxPmrpq/KG42dMhVDEh0ME4q1uRzDjwnU3tyP7QTd2r5dIRuGlaBRAfjRFRuTZuxNfB+dujYhxPWHWY93+QW9EIXrhIg0QE5YT7nUMf1gtci+U91rE+i5gvNXc7Bnv1BTqJg4UJzgm1vPK5ql8S7E5FcvYp8vCJ5eglMgNx8BHFSiypcaU6w/UNERrzcv48B99KTKoqHzWmWXkMlaojwQJxYUS3vNJx5/SbiloRleg72Ns0ykG0UbzU/B3o3lbC/+KXfApATupvR5Wse1VR1IHrYqfHkrWqHHQl1lUdCG0Nnmv5BTjSlbUX1mpPZbGnqYUnOWYr1Z7IcarOczQhfa1q1lIJMSAFxYrITSu2ek+oeOkeUskEZH6xSxHXhXhG+t9N3QB5mwDip6I6K/sKJeBsf/W1k2PGO74Ic84p6E4Rf+ty/aPXnOFGTk/pAiZjbfLkNRDrGmJN5jUQ7F0Qc6smJ+vWP/fuAOPGTk3iaE36q96SXRN1yWX9TRPbkUR9WZH6KkxOQBzwgThwbnRB2qhedJ6rxxIjT7CQM8Y0ivnNt1jU6YQ4iPBAnzdROiJg5khPIgkiyYZf5hZ3zWq5oNyRXa5OTqoEID8TJSzXPtQdZJWKmJzihC+LGbiJ/jpudIWaVneg5e4EID8TJmZ3GkiwnC+9Jn0gwA32tNnQwgaR+3El0mFEzyy0HABAnG3YItBqn3UhrG0lSOLKOduwYEpFNa8dHpvnqE+4wD3hAnCzYm5rK9l6TR9TbnHSZE45Vjmx1fJDlOIG4ZuqNLSDCA3FyY4/ufd50nUfENifdQxLpkFNqNrWon/OpY3dhN4jwQJw8qnuu1LQLjjQ5g+xI4utOdGueyC5nl4bkI3mkE68VyAMeECeHY15IZRrVONe5NGXV05RxU952eb9RY1K5HCDCg7nujIuma0wMS3XWg/c+122yyZ+DPqtliCYf/fjm/xuwOcMxt4s6SOnbFKLPfWWf+5KPIbVeSpO71gnsvS8oJ/XdEDdOL0mNXYZgkpIqmbxiu1zPD/mIuUNJAXLS0jjWqzmR1pb48Y5Ayn9xvP1a23ztGevXSFuY4KDayS0SPW/0YqkvJnXk2SS66RrcX2utOkUiyIWYwDmxB0KW/hxeG6FS8t3QGKON687tZbG/vr0O4wRZoNjAcux27Cd9G2LcOz08hu52l4vFYOSl9dMlp4aZpEQAnfSHhXo2hEisymPjsd84Ep7dyKrtAezNWsD3d2o1PI6X9ZBkMGa5a/XS5EqtGdaX42NQIE+7noC/0xStNsq71DRNcl4ZbcHfRwd38gX5hiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgvzP/A0aCjKLRldwRAAAAABJRU5ErkJggg=="
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
          <div class="col-xl-4 col-lg-6 mb-4">
            <div class="influencers-box-view">
              <div class="check-box-influencers">
                <div class="pretty p-default">
                  <input type="checkbox" name="has_voucher" class="form-contr">
                  <div class="state">
                    <label class="form-check-label " for="defaultCheck1">
                    </label>
                  </div>
                </div>
              </div>
              <div class="icon-box-view">
                <a href="#">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a href="#">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <button>
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>


              <div class="top-box">
                <div class="influe-img-box">
                  <img
                    src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                    alt="" class="img-fluid influe-img">
                  <img
                    src="data:image/png;base64,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"
                    alt="" class="img-fluid flag-item">
                </div>
                <div class="name-box">
                  <div class="text-box">
                    <h3 class="name">
                      Amr Rady
                    </h3>
                    <h4 class="account-name">
                      amr361
                    </h4>
                    <h5 class="gender">
                      Male
                    </h5>

                  </div>
                  <div class="states" style="background: #3B7F34;">
                    Active
                  </div>
                </div>
              </div>
              <div class="socile-box">
                <a href="#">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                  <i class="fa-brands fa-twitter"></i>
                </a>
              </div>

              <div class="content-box">
                <ul class="list-unstyled">
                  <li>
                    <h3 class="content">
                      12/9/2022
                    </h3>
                    <h3 class="title">
                      Created at
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Non talker
                    </h3>
                    <h3 class="title">
                      Bio
                    </h3>
                  </li>
                  <li>
                    <h3 class="content">
                      Teacher <span> +6 </span>
                    </h3>
                    <h3 class="title">
                      Category
                    </h3>
                  </li>
                </ul>
              </div>
              <div class="seemore">
                <a href="#">see more <i class="fa-solid fa-chevron-down"></i></a>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
@can('delete influencers')
@include('admin.dashboard.influencers.models.confirm_delete')
@include('admin.dashboard.influencers.models.influ_details')
@endcan

@can('update influencers')
@include('admin.dashboard.influencers.models.bulck_edit_influencers')
@endcan
@can('create influencers')
@include('admin.dashboard.influencers.models.add_infuencer_group')
@include('admin.dashboard.influencers.models.create_group')
@endcan

{{-- change_details
@include('admin.dashboard.influencers.models.change_influe_details')
@include('admin.dashboard.influencers.models.change_influenceroneandmore')
--}}


@include('admin.dashboard.influencers.models.import_excel')
@endsection
@section('js')
@include('admin.dashboard.layouts.includes.general.scripts.index')

<script src="{{asset('js/influencer/index.js')}}"></script>
<script type="text/javascript" src="https://www.viralpatel.net/demo/jquery/jquery.shorten.1.0.js"></script>
<script>
let influe_tabels = null;

$(document).ready(function() {
  $(document).on('click', '#submit_delete_all', function() {
    let selected_ids = $('input[id="delete_all_id"]').val();
    let reason = $('#reasonall').val();
    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('dashboard.influe_delete_all')}}",
      data: {
        selected_ids: selected_ids,
        reason: reason
      },
      dataType: 'json',
      success: function(data) {
        console.log(data);
        if (data.status) {
          $('#delete_all').modal('hide')
          Swal.fire("Deleted!", "Deleted Successfully!", "success");
          influe_tabels.ajax.reload();

          for (let statictic in data.data) {
            let elId = data.data[statictic].id;
            $(`#${elId}`).find('.counter-value').text(data.data[statictic].count)
          }

          $('#reasonall').val('');
        }
      },
      error: function(data) {
        let error = data.responseJSON.errors;
        let error_message = data.responseJSON.message;
        if (error) {
          for (let key in error) {
            $(`#${key}`).text(error[key][0]);
          }
        }
        if (error_message) {
          $('#reason_error').text(error_message);
          $('#reasonall').css('border-color', 'red');
        }

      }
    });
  });


  // $('.badges_container').append(`
  // <span>
  //         <span class="spn-val" id ="span_${[i]}"> ${ $(this).html()} </span>
  //         <button class="badge-item-btn" id ="${i}"  name="${arr[i]}">
  //         <i class="fas fa-times"></i></button>
  // </span>`)
  ////////////// start filter by status ///////////////////
  $(document).on('click', '#filter', function() {
    $('.badges_container_multiple').html('');
    $('#influencer_filter_form select,#influencer_filter_form input').each(function(index) {
      var ctrl = $(this).find(':input:visible:first');
      var input = $(this);
      var inputId = $(this).attr('id');
      var inputName = $(this).attr('data-name');
      if ($("#" + inputId).is("input") && input.val().length > 0) {
        var value = input.val();
        drawSearchResult(inputName, value, inputId);
      } else {
        if ($('#' + inputId + ' option').is(':selected') && input.val().length > 0) {
          if ($('#' + inputId).prop('multiple')) {
            var value = input.val();
            for (var i = 0; i < input.val().length; i++) {
              drawSearchResult(inputName, value[i], inputId);
            }

          } else {
            var value = $('#' + inputId + ' option').filter(':selected').text();
            drawSearchResult(inputName, value, inputId);
          }
        }
      }
    })
    influe_tabels.ajax.reload();
  })

  let drawSearchResult = (inputName, value, inputId) => {
    $('.badges_container_multiple').append(`<span class="_username_influncer"><span class="spn-val"> ${inputName}: ${value} </span>
				<button class="badge-item-btn_multiple  badge-item-btn_text remove_items" id ="${inputId}" data-item="${value}"  >
					<i class="fas fa-times"></i></button></span>`)
  }


  $(document).on('click', ".remove_items", function() {
    var inputId = $(this).attr("id");
    var itemtoRemove = $(this).attr('data-item');
    $(this).parent().remove();
    if ($("#" + inputId).is("input")) {
      $('#influencer_filter_form #' + inputId).val('');
    } else {
      if ($('#' + inputId).prop('multiple')) {
        arr = $('#' + inputId).val();
        arr.splice($.inArray(itemtoRemove, arr), 1)
        $('#influencer_filter_form #' + inputId).val(arr).trigger('change');

      } else {
        $('#influencer_filter_form #' + inputId).val('').trigger('change');
      }
    }
    influe_tabels.ajax.reload();
  });

  $(document).on('input', '#custom', function() {
    influe_tabels.ajax.reload();
  })
  var status_filter = null;
  $('.status_influencer_statistic').on('click', function(event) {
    status_filter = $(event.currentTarget).attr('value');
    influe_tabels.ajax.reload();
    $('html, body').animate({
      scrollTop: ($("#influe").offset().top)
    }, 1000);
  });
  ////////////// end filter by status ///////////////////
  ////////////// Edit SCROLL DATATABLE in min.css file inside public/assets/css ///////////////////
  influe_tabels = $('#influe').DataTable({
    fixedHeader: {
      header: true,
      footer: false,
    },
    "drawCallback": function(settings) {
      recheckedInputsStoredInDatatableSession()
    },
    lengthChange: true,
    processing: true,
    serverSide: true,
    responsive: true,
    searching: true,
    clearable: true,
    dom: 'Blfrtip',
    buttons: [
      'colvis',
    ],
    columnDefs: [{
      'orderable': false,
      'targets': 0
    }],
    // 'aaSorting': [[1, 'asc']],
    "ajax": {
      url: "/dashboard/get-influences",
      data: function(d) {
        let dtSettings = $('#influe').dataTable().fnSettings();

        d.have_child = $('#influencer_filter_form #children_num').val();
        d.gender = $('#influencer_filter_form #gender').val();
        d.multi_language = $('#influencer_filter_form #lang').val();
        d.martial_status = $('#influencer_filter_form #socialType_id_search').val();
        d.life_style = $('#influencer_filter_form #ethink_id_search').val();
        d.citizen_ship = $('#influencer_filter_form  #citizen_status').val();
        d.interest_ids = $('#influencer_filter_form #interests_id_search').val();
        d.category_ids = $('#influencer_filter_form #category').val();
        d.classification_ids = $('#influencer_filter_form #chkveg').val();
        d.account_type = $('#influencer_filter_form #accountStatus_id_search').val();
        d.search_country_id = $('#influencer_filter_form #country_id_search').val();
        d.governorate_id = $('#influencer_filter_form #state_id_search').val();
        d.city_id = $('#influencer_filter_form #city_id_search').val();
        d.nationality_ids = $('#influencer_filter_form #nationality_id_search').val();
        d.channels = $("#influencer_filter_form #channel_id_search").val();
        d.platform = $("#influencer_filter_form #platform_id_search").val();
        d.not_multi_classification = $('#influencer_filter_form #not_has_multi_classification').val();
        d.followers_min_value = $("#influencer_filter_form #min_followers_id_search").val();
        d.followers_max_value = $("#influencer_filter_form #max_followers_id_search").val();
        d.engagement_min_value = $("#influencer_filter_form #min_engagement_id_search").val();
        d.engagement_max_value = $("#influencer_filter_form #max_engagement_id_search").val();
        d.is_verified = $("#influencer_filter_form #verified_id_search").val();
        d.status_val = status_filter;
        d.min_voucher = $('#influencer_filter_form #min_voucher').val();
        d.searchWord = $('#custom').val();

        d.company = $('#favourite-company').val();
        d.company_favourite_type = $('#unfavourite-or-favourite-company').val();

        d.sorted_by = $(dtSettings.aoColumns[dtSettings.aaSorting[0][0]]).attr('name');
        d.sorted_by = d.sorted_by ? d.sorted_by : "";
        d.sorted_type = dtSettings.aaSorting[0][1];
        addCheckedItemsInDataTableToSession();
        recheckedInputsStoredInDatatableSession();
      },


    },
    "columns": [{
        "data": "id",
        "sortable": false,
        render: function(data, type) {
          return '<input id="countChecked"  type="checkbox"  onclick="handleClick();"  value="' + data +
            '" class="box1 check-item-in-dt" >';
        }
      },
      {
        data: 'user_name',
        render: function(data, type, full) {
          return `<a class="show_influencer" href="social-scrape/${full['id']}"><span class="_username_influncer">${data}</span></a>`;
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
        data: 'image',
        sortable: false,
        render: function(data, type, full) {
          return `
                                <div class="img_container" style="
                                    position: relative;
                                ">
                                <img src="${full['image']}" class="img-thumbnail change_detail" style="width: 70px;height: 45px;" alt="image">

                                </div>
                               `
        }
      },

      {
        "className": "influen_description",
        "data": "bio",
        sortable: false,
        render: function(data) {
          if (data) {
            return `<span>${data}</span>`;
          } else {
            return '..'
          }
        }
      },
      {
        "data": 'active',
        sortable: false,
        render: function(data, type) {
          // console.log(data);
          switch (data) {
            case 1:
              return `<span class="badge badge-pill badge-success status_toggle status-active"  title="active" >active</span>`
              break;
            case 2:
              return `<span class="badge badge-pill badge-primary status_toggle status-pending"  title="pending" >Inactive</span> `
              break;
            case 3:
              return `<span class="badge badge-pill badge-danger status_toggle status-reject"  title="reject" >reject</span>`
              break;
            case 4:
              return `<span class="badge badge-pill badge-danger status_toggle status-reject"  title="reject" >Block</span>`
              break;
            case 5:
              return `<span class="badge badge-pill badge-danger status_toggle status-reject"  title="reject" >No Resoponse</span>`
              break;
            case 7:
              return `<span class="badge badge-pill badge-danger status_toggle status-reject"  title="reject" >Out oF country</span>`
              break;
            default:
              return `<span class="badge badge-pill badge-primary status_toggle status-pending" title="pending" >pending</span> `
              break;
          }
        }
      },
      {
        "data": "country_id",
        "className": "hover_country",
        sortable: false,
        render: function(data, type) {
          if (data) {

            return `<span class="_country_table">
                                      ${data.toUpperCase()}
                                    </span>`;
          } else {
            return '..'
          }

        }
      },

      {
        "data": "gender",
        sortable: false,
        render: function(data, type) {
          if (data == 1) {
            return `<span class="badge badge-pill badge-primary _username_influncer"> Male </span>`
          } else if (data == 0) {
            return `<span class="badge badge-pill badge-primary _username_influncer"> Female </span>`
          } else {
            return `..`
          }
        }
      },
      {

        "data": "followers",
        className: "social_media_follwers",
        sortable: false,
        render: function(data, type, full) {
          // console.log(data['insta']);
          var text = "";
          if (data['snap'] != 0) {

            text +=
              ` <div title="${full['user_name']}"> <i class="fab fa-snapchat"></i> <span>${data['snap']}</span> </div>  `
          }
          if (data['tiktok'] != 0) {
            text +=
              ` <div title="${full['user_name']}"> <i class="fab fa-tiktok"></i> <span>${data['tiktok']}</span> </div>  `
          }
          if (data['face'] != 0) {
            text +=
              ` <div title="${full['user_name']}"><i class="fab fa-facebook"></i>  <span>${data['face']}</span> </div>  `
          }
          if (data['twitter'] != 0) {
            text +=
              `<div title="${full['user_name']}"><i class="fab fa-twitter"></i>  <span>${data['twitter']}</span> </div> `
          }
          if (data['insta'] != 0) {
            text +=
              `<div title="${full['user_name']}"><i class="fab fa-instagram"></i>  <span>${data['insta']}</span> </div> `
          }

          return text;
        }


      },
      {
        "data": "complete_date",
        sortable: false,
        render: function(data, type) {
          if (data == "Complete") {
            return `<i style="color: green;font-size: 22px;" class="icon-beenhere"></i>`
          } else {
            return `<i style="color: red;font-size: 22px;" class="icon-circle-with-cross"></i>`
          }
        }
      },

      {
        "data": "interest",
        sortable: false,
        render: function(data) {
          return `
                            <span class="_username_influncer">${data}</span>
                        `
        }
      },
      {
        "data": "category_ids",
        sortable: false,
        render: function(data) {
          return `
                            <span class="_username_influncer">${data}</span>
                        `
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
        sortable: false,
        render: function(data, type) {
          return `
                            <td>
                            <div class="btn_action">
                            @can('update influencers')
                            <a style="" data-toggle="tooltip" data-placement="top" title="Edit Influencer"  href="influences/${data}/edit"class="btn-success btn-sm mt-2 mb-2">
                            <i class="icon-edit-3 text-success" style="font-size:16px;"></i>
                            </a>
                            @endcan
                            @can('delete influencers')
                            <button style="border:none !important;"  data-toggle="tooltip" data-placement="top" title="Delete Influencer"  class="btn-danger btn-sm mt-2 mb-2 delRow" data-id="${data}" id="del-${data}">
                            <i class="icon-trash-2 text-danger" style="font-size:16px;"></i>
                            </button>
                            @endcan
                            <a style="" data-toggle="tooltip" data-placement="top" title="Show Influencer" href="social-scrape/${data}" class="btn-warning btn-sm mt-2 mb-2 pb-2"><i class="icon-eye1 text-warning" style="font-size:16px;"></i> </a>
                            </div>
                            </td>
                            `;
        }
      },
    ],
    "lengthMenu": [
      [10, 25, 50, 100, 500, 1000 - 1],
      [10, 25, 50, 100, 500, 1000, "All"]
    ],
    language: {
      searchPlaceholder: 'Search',
      sSearch: '',
    },
    "data": {
      "json": 'hjggh'
    },
    "dataSrc": function(response) {
      roleList = response;
    }
  });

  influe_tabels.on('draw', function() {
    $(".influen_description").shorten({
      "showChars": 30,
      "moreText": "See More",
      "lessText": "Less"
    });
  });
  $('#influe_length').append('<input type="text" id="custom" placeholder="Search"/>');















});

function swalDel(id) {
  Swal.fire({
    title: "Are you sure you want delete?",
    text: "You won't be able to restore this data",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Delete',
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    closeOnCancel: false,
    html: '<input name="reason" id="reason" type="text" placeholder="Enter Reason" style="background-color:black; color:white">' +
      '<span id="reason_error" style="color: red"></span>'
  }).then(function(result) {
    var reason = $('#reason').val();
    if (result.isConfirmed) {
      $.ajax({
        url: `/dashboard/influences/${id}?reason=${reason}`,
        type: 'delete',
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          reason: reason
        },
        success: (data) => {
          for (let statictic in data.data) {
            let elId = data.data[statictic].id;
            $(`#${elId}`).find('.counter-value').text(data.data[statictic].count)
          }
          influe_tabels.ajax.reload();
          Swal.fire("Deleted!", "Deleted Successfully!", "success");
        },
        error: function(data) {
          let error = data.responseJSON.errors;
          let error_message = data.responseJSON.message;
          if (error_message) {
            Swal.fire("Error!", error_message, "error");
          }
        }
      });

    } else {
      Swal.fire("Cancelled", "canceled successfully!", "error");
    }

  })

}

$('#filter-counter-with-country').on('change', function() {
  influe_tabels.ajax.reload();
  $('#status').val('');
  var country_id = $(this).val();
  $.ajax({
    url: '{{ url("dashboard/influe/get-statistics") }}',
    type: 'get',
    data: {
      '_token': '{{ csrf_token() }}',
      'country_id': country_id
    },
    success: function(res) {

      $.each(res, function(i, v) {
        $('#count_' + v.id).html(v.count);
      })
    }
  });
});





$(document).on('click', '.delRow', function() {
  swalDel($(this).attr('data-id'));
});




function handleClick() {
  checkBox = document.getElementById('countChecked');
  var array = [];
  $("input:checked").each(function() {});

  $('.counterselector').text(array.length)
  if (array.length == 0)
    $('.counterselector').hide();
  else
    $('.counterselector').show()

}


var checkdate = $("#countChecked").find();
$('#countChecked').each(function() {
  $(this).on('click', function() {

  })
});

$('.select2').select2({
  placeholder: "Select",
  allowClear: true
});



$("#state_id_search").change(function() {
  let state = $(this).val();
  if (state)
    getCity($(this).val())

});

function getCity(val) {
  $.ajax({
    type: "GET",
    contentType: "application/json; charset=utf-8",
    url: "/dashboard/city/" + val,
    corssDomain: true,
    dataType: "json",
    success: function(data) {

      $('#city_id').parent().show();
      $('#city_id_search').empty();
      // $('#city_id_search').select2(data);
      var listItems = "";
      listItems = "<option value=''>Select</option>";
      $.each(data.data, function(key, value) {
        listItems += "<option value='" + key + "'>" + value + "</option>";
      });
      $("#city_id_search").html(listItems);
    },

    error: function(data) {

    }
  });
}

function getStateData(val) {
  $.ajax({
    type: "GET",
    contentType: "application/json; charset=utf-8",
    url: "/dashboard/state/" + val,
    corssDomain: true,
    dataType: "json",
    success: function(data) {

      $('#state_id_search').parent().show();
      //var listItems = ""
      listItems = "<option value=''>Select</option>";
      $.each(data.data, function(key, value) {
        listItems += "<option value='" + value.id + "' >" + value.name + "</option>";
      });
      $("#state_id_search").html(listItems);
      // $('#state_id_search').empty();
      // $('#state_id_search').select2(data);
    },

    error: function(data) {

    }
  });
}

$("#filterFormInfluencer").click(function() {
  $('.filter-form').slideToggle()
  if ($('.filter-form').hasClass('hideForm')) {
    $('.filter-form').removeClass('hideForm')
  }
})
$(".close_btn i").click(function() {
  $('.filter-form').slideToggle()
  if ($('.filter-form').hasClass('hideForm')) {
    $('.filter-form').removeClass('hideForm')
  } else {
    $('.filter-form').addClass('hideForm')
  }
});
</script>
<script>
$(document).ready(function() {
  $(".grand-view-changer .box-icon .icon").click(function() {
    $(this).addClass("active");
    $(this).siblings().removeClass("active");
    $(".grand-view-show .view-box").removeClass("active");
    $("#" + $(this).attr('data-show')).addClass("active");
  })
})
</script>




@endsection
