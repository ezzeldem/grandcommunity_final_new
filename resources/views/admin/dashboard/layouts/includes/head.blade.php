<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
<meta name="Author" content="Spruko Technologies Private Limited">
<meta name="csrf-token" content="{{csrf_token()}}">
<meta name="auth-id" content="{{auth()->id()}}">
<meta name="Keywords"
  content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
<!-- Title -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="icon" href="{{getLogoImage()}}" type="image/x-icon" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
  integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" />
<style>
.dataTable tbody td .img-thumbnail {
  height: 45px !important;
  width: 45px !important;
  margin-right: 10px;
}

.dataTable thead {
  text-transform: capitalize !important;
}

.inputs {
  width: 500px !important;
  height: auto;
}

#reportrange {
  overflow: hidden;
}

.inputs>label {
  color: #fff !important;
  font-size: 16px !important;
  font-weight: unset !important;
  margin-bottom: 5px !important;
}

.inputs .select2-container--default .select2-selection--multiple {
  /* border: 1px solid #A27929 !important; */
  height: 38px !important;
  line-height: 2 !important;
}

.inputs .select2-container--default .select2-selection--single .select2-selection__rendered {
  height: 55px !important;
  line-height: 2.5 !important;
  border-radius: 3px
}

.nav_active {
  background: #0c1425;
}

.btn-success.focus,
.btn-success:focus,
.btn-warning.focus,
.btn-warning:focus,
.btn-danger.focus,
.btn-danger:focus,
.btn-info.focus,
.btn-info:focus,
.btn-dark.focus,
.btn-dark:focus,
.btn-light.focus,
.btn-light:focus,
.btn-primary.focus,
.btn-primary:focus {
  box-shadow: none !important;
}

.inputs .select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 37px !important;
  position: absolute;
  top: 2px;
  right: 2px;
  width: 22px;
}

.inputs #reportrange {
  border: 1px solid #202020 !important;
  height: 40px !important;
  line-height: 2 !important;
  margin-top: 4px !important;
  border-radius: 3px
}

.inputs:last-child {
  margin-bottom: 25px !important;

}

.filter-form .search_reset_btns button {
  background: #314272 !important;
  height: 37px !important;
}

#filter-form,
#filterSection {
  display: flex;
  flex-wrap: nowrap;
  align-items: center;
  gap: 15px;
  margin-bottom: 1rem !important;
  background: var(--main-bg-color);
  padding: 30px 30px 30px 30px;
  justify-content: flex-start;
  align-items: flex-start;
  flex-direction: row;
}

@media (max-width: 767px) {

  #filter-form,
  #filterSection {
    flex-wrap: wrap;
  }
}

.select2-dropdown.select2-dropdown--below {
  background: #1a233a !important;
}

.breadcrumb-header .app-actions .btn.active {
  background: transparent;
  border: 1px solid #0047b1;
  color: #ffffff;
}

.breadcrumb-header .app-actions .btn:hover {
  background: transparent;
  border: 1px solid #0047b1;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  background: #1a233a !important;
  color: #8a99b5 !important;
  border: 1px solid #596280 !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered {
  background: #1a233a !important;
  color: #8a99b5 !important;
}

.select2-container--default .select2-selection--multiple {
  background: #1a233a !important;
  color: #8a99b5 !important;
  /*background: transparent !important;*/
}

.select2-container--default .select2-selection--single,
.select2-container--default {
  padding: 1px;
  /* height: 37px; */
  width: 100% !important;
  font-size: 1em;
  position: relative;
  border: none !important;
  background: transparent !important;
}

.select2-container--default .select2-results__option[aria-selected=true] {
  background-color: #120d1cb5 !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered li {
  list-style: none;
  background: #1a233a !important;
  color: #bcd0db !important;
}

.select2-container .select2-selection--single .select2-selection__rendered {
  padding-right: 28px !important;
  line-height: 33px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  background-image: -khtml-gradient(linear, left top, left bottom, from(#424242), to(#030303));
  background-image: -moz-linear-gradient(top, #424242, #030303);
  background-image: -ms-linear-gradient(top, #424242, #030303);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #424242), color-stop(100%, #030303));
  background-image: -webkit-linear-gradient(top, #424242, #030303);
  background-image: -o-linear-gradient(top, #424242, #030303);
  background-image: linear-gradient(#424242, #030303);
  width: 40px;
  color: #fff;
  font-size: 1.3em;
  padding: 4px 12px;
  height: 33px !important;
  position: absolute;
  top: 0px;
  right: 0px;
  width: 20px;
}

.select2-container--default .select2-search--inline .select2-search__field {
  color: white !important;
}

</style>

@yield('style')

<!-- *************
			************ Common Css Files *************
		************ -->
<!-- Bootstrap css -->
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<!-- Icomoon Font Icons css -->
<link rel="stylesheet" href="{{asset('assets/fonts/style.css')}}">
<!-- Main css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/home.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/sidebar.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/addCompaign.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/campDetails.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/influncer.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dataTable.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/brands.css')}}">

<!-- Chat css -->
<link rel="stylesheet" href="{{asset('assets/css/chat.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.3/pretty-checkbox.min.css" />
<link rel="stylesheet" href="{{asset('assets/css/full-screen-helper.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/grand-custom.css')}}">


@stack('style')
