@extends('admin.dashboard.layouts.app')
@section('title','Influencer Social Media')
@section('style')
@include('admin.dashboard.layouts.includes.general.styles.index')
<style>
.padding {
  padding: 3rem !important;
}

.card-img-top {
  height: 200px
}

.card-no-border .card {
  border-color: #d7dfe3;
  border-radius: 4px;
  margin-bottom: 30px;
  -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05)
}

.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  padding: 1.25rem
}

.pro-img {
  margin-bottom: 20px
}

.little-profile .pro-img img {
  width: 128px;
  height: 128px;
  -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  border-radius: 100%;
  margin: auto;
}

html body .m-b-0 {
  margin-bottom: 0px
}

h3 {
  line-height: 30px;
  font-size: 21px
}

.btn-rounded.btn-md {
  padding: 12px 35px;
  font-size: 16px
}

html body .m-t-10 {
  margin-top: 10px
}

.btn-primary,
.btn-primary.disabled {
  background: #7460ee;
  border: 1px solid #7460ee;
  -webkit-box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
  box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
  -webkit-transition: 0.2s ease-in;
  -o-transition: 0.2s ease-in;
  transition: 0.2s ease-in
}

.btn-rounded {
  border-radius: 60px;
  padding: 7px 18px
}

.m-t-20 {
  margin-top: 20px
}

.text-center {
  text-align: center !important
}

.btn-group,
.btn-group-vertical {
  display: flex !important;
  margin-bottom: 10px !important;
  width: fit-content !important;
}

.card-title i {
  display: inline-block;
  background: #0b1426;
  color: #fff;
  padding: 9px 11px 9px 11px;
  border-radius: 2px;
}

.nav_center {
  justify-content: center;
}

.nav_main li {
  /* border-right: 1px solid #9ca6b9 !important; */
}

.nav_main li:last-child {
  border-right: none !important;
}

.nav-pills .nav-link.active {
  background-color: transparent !important;
  color: #000 !important;
  font-weight: bold !important;
}

.tab-content .count {
  background: #e7ebf5;
  min-height: 143px;
  border-radius: 4px;
  border: 1px solid #bed4ff;
  margin-top: 20px;
  margin-bottom: 20px;
}

.tab-content .count span {
  display: block;
  background: #0b1426;
  color: #fff;
  padding: 8px 0px 8px 0px;
  font-size: 16px;
  margin: 3px;
  border-radius: 4px;
}

.tab-content .count h5 {
  margin-top: 33px;
  font-size: 26px;
}

.second_section {
  margin-top: 50px;
  margin-bottom: 50px;
}

.scrape_data .main_data img {
  width: 100px;
  height: 100px;
  border: 1px solid #9ca6b9;
  border-radius: 50%;
  padding: 2px;
  display: inline-block;
}

.scrape_data .main_data .parent_names span {
  display: block;
}

.scrape_data .main_data {
  display: flex;
  justify-content: flex-start;
  gap: 12px;
}

.scrape_data .main_data .parent_names {
  padding-top: 26px;
}

#brand_campaigns_table tbody tr .style_td_action {
  display: flex;
  flex-direction: column;
}

.loader {
  background: white;
  width: 101%;
  height: 101%;
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 100;
  text-align: center;
  transform: translate(-50%, -50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.loader-wheel {
  animation: spin 1s infinite linear;
  border: 2px solid rgba(30, 30, 30, 0.5);
  border-left: 4px solid #030303;
  border-radius: 50%;
  height: 100px;
  margin-bottom: 10px;
  width: 100px;
}

.loader-text {
  color: #030303;
  font-family: arial, sans-serif;
  font-weight: bold;
  font-size: 20px;
}

.loader-text:after {
  content: 'Loading';
  animation: load 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

.card {
  /* border: 1px dashed #d0d5dd !important; */
}

@keyframes load {
  0% {
    content: 'Loading';
  }

  33% {
    content: 'Loading.';
  }

  67% {
    content: 'Loading..';
  }

  100% {
    content: 'Loading...';
  }
}

#tiktok_h5_header,
#insta_h5_header,
#snap_h5_header {
  text-align: center;
  background: var(--body-bg-color);
  min-width: 50px;
  max-width: 250px;
  margin: auto;
  margin-bottom: 35px;
  margin-top: 35px;
  padding: 15px 5px 15px 5px;
  color: #fff;
  border-radius: 4px;
}

</style>

@endsection

@section('page-header')
<!-- breadcrumb -->
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Influencer Social Media'])
<!-- /breadcrumb -->
@stop


@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="gran-content-box">

      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="grand-influe-box">
            <div class="states">Active</div>
            <div class="top-box">
              <div class="influe-img-box">
                <img
                  src="https://img.freepik.com/free-photo/handsome-confident-smiling-man-with-hands-crossed-chest_176420-18743.jpg?w=2000"
                  alt="" class="img-fluid influe-img">
                <img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARMAAAC3CAMAAAAGjUrGAAAAjVBMVEUAAADOESb////KAAC8jAC+jwC9jQDAkwC6hwC7igC+kADl1K3o2bnSs27w59Pu48z17+L59ezj0afu5M3gy5zl1bC4gwDz69rp2779/PjRsmjWun3eyJXUt3T48+nz69nZwIfOrFzGnjHJo0LClxnYvoTKpkzdxpbHnzfPrmDFmyfMqVPUt3fgy6DIoj7XPX04AAAHJ0lEQVR4nO2ba3PjqBJAZ7kgg8GAsLDAlmX5GT9C/v/PWyRnM5nhVs2Hu3M7VdMnVbIejqt1ClqNhL79hfzMN+gAviDopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlKCTEnRSgk5K0EkJOilBJyXopASdlHz7D/Iz3wjyM1/CSdQ2uhChw/iHL+FkY84rUa2OPXQgT76CE7tdDbvFxpkNdCRPvoKT2JLDhdRZjoYOZeIrOMm0w9RvPHQcE1/ESTTThwQO48kXcVKjkwLda9PW6OQzMgbvJTr5jNS9Uv4Pd2KcdPZjqzYyGh/idyc2HzcQgREwJ7LNi2UT3jcTccva11q9b4dmmZctULOBcRLfCxHbTVVaH3JDyR3HxUmS7t5bkIcZAsE4MfX5/bR3yaldQ7qxqYx/O+XS7nnInnuY3gPjJDBurx9b28bJJhnX7Nbd8LH3YDkL/+2ffzswTnwlLD/90zMisSlnl9xpvmfdeOJWVDC1PowTyWgvRPw85Os7+2lLRyF6ymCSLIyTxKilgtCPczbSaSc/HElKRP4GSyDRwTjpqmp0Uh1rZa1RQXodSdReBrW0VtVvbHRSsQ4kOhgnA5uNTsTers5dMxzFetq9po+u6c4ruxejkzkbfvE7vwcYJxt20nRO+LrlacbYfL6Ydi/mc8ZmibdrThjVJwZz4w3GyZZdDT0R/qrF8DabzT6c5PXjIPQrJydqrmwLEh2MkzU7BnqI/GzEej3/wcl8sRbmzOOBhiNbg0QH4+TB9ooea95lMy/sByesyTYGXh+p2rMHSHQwTi5sLem+540SW1f94KRyW6Ea3j+oXLMLSHQwTnKmSPSWE6wTXv7kRHohE7c3mnLWAYkOxsmdnTu61dwnbtxl/snJ/OIMT5LrLX05sztIdDBOZqwb6Nlw1XF9zZ3nuxPmrpq/KG42dMhVDEh0ME4q1uRzDjwnU3tyP7QTd2r5dIRuGlaBRAfjRFRuTZuxNfB+dujYhxPWHWY93+QW9EIXrhIg0QE5YT7nUMf1gtci+U91rE+i5gvNXc7Bnv1BTqJg4UJzgm1vPK5ql8S7E5FcvYp8vCJ5eglMgNx8BHFSiypcaU6w/UNERrzcv48B99KTKoqHzWmWXkMlaojwQJxYUS3vNJx5/SbiloRleg72Ns0ykG0UbzU/B3o3lbC/+KXfApATupvR5Wse1VR1IHrYqfHkrWqHHQl1lUdCG0Nnmv5BTjSlbUX1mpPZbGnqYUnOWYr1Z7IcarOczQhfa1q1lIJMSAFxYrITSu2ek+oeOkeUskEZH6xSxHXhXhG+t9N3QB5mwDip6I6K/sKJeBsf/W1k2PGO74Ic84p6E4Rf+ty/aPXnOFGTk/pAiZjbfLkNRDrGmJN5jUQ7F0Qc6smJ+vWP/fuAOPGTk3iaE36q96SXRN1yWX9TRPbkUR9WZH6KkxOQBzwgThwbnRB2qhedJ6rxxIjT7CQM8Y0ivnNt1jU6YQ4iPBAnzdROiJg5khPIgkiyYZf5hZ3zWq5oNyRXa5OTqoEID8TJSzXPtQdZJWKmJzihC+LGbiJ/jpudIWaVneg5e4EID8TJmZ3GkiwnC+9Jn0gwA32tNnQwgaR+3El0mFEzyy0HABAnG3YItBqn3UhrG0lSOLKOduwYEpFNa8dHpvnqE+4wD3hAnCzYm5rK9l6TR9TbnHSZE45Vjmx1fJDlOIG4ZuqNLSDCA3FyY4/ufd50nUfENifdQxLpkFNqNrWon/OpY3dhN4jwQJw8qnuu1LQLjjQ5g+xI4utOdGueyC5nl4bkI3mkE68VyAMeECeHY15IZRrVONe5NGXV05RxU952eb9RY1K5HCDCg7nujIuma0wMS3XWg/c+122yyZ+DPqtliCYf/fjm/xuwOcMxt4s6SOnbFKLPfWWf+5KPIbVeSpO71gnsvS8oJ/XdEDdOL0mNXYZgkpIqmbxiu1zPD/mIuUNJAXLS0jjWqzmR1pb48Y5Ayn9xvP1a23ztGevXSFuY4KDayS0SPW/0YqkvJnXk2SS66RrcX2utOkUiyIWYwDmxB0KW/hxeG6FS8t3QGKON687tZbG/vr0O4wRZoNjAcux27Cd9G2LcOz08hu52l4vFYOSl9dMlp4aZpEQAnfSHhXo2hEisymPjsd84Ep7dyKrtAezNWsD3d2o1PI6X9ZBkMGa5a/XS5EqtGdaX42NQIE+7noC/0xStNsq71DRNcl4ZbcHfRwd38gX5hiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgvzP/A0aCjKLRldwRAAAAABJRU5ErkJggg=="
                  alt="" class="img-fluid flag-item">
              </div>
              <h4 class="name">
                Ali Mohamed
              </h4>
              <h5 class="top-info">ali25</h5>
              <h5 class="top-info">ali25@gmail.com</h5>
            </div>
            <div class="grand-border-box">
              <ul class="list-unstyled-grand-list-info">
                <li>
                  <h3 class="title">Phone Number</h3>
                  <h4 class="info">0106985563</h4>
                </li>
                <li>
                  <h3 class="title">WhatsApp Number</h3>
                  <h4 class="info">0106985563</h4>
                </li>
                <li>
                  <h3 class="title">Instagram User</h3>
                  <h4 class="info">ali25</h4>
                </li>
              </ul>
            </div>
            <div class="grand-border-box">
              <ul class="list-unstyled-grand-list-info">
                <li>
                  <h3 class="title">Gender</h3>
                  <h4 class="info">Male</h4>
                </li>
                <li>
                  <h3 class="title">Marital</h3>
                  <h4 class="info">Married</h4>
                </li>
                <li>
                  <h3 class="title">Date of birth</h3>
                  <h4 class="info">2/2/2022</h4>
                </li>
              </ul>
            </div>
            <div class="grand-border-box">
              <ul class="list-unstyled-grand-list-info">
                <li>
                  <h3 class="title">Government</h3>
                  <h4 class="info">Egypt</h4>
                </li>
                <li>
                  <h3 class="title">City</h3>
                  <h4 class="info">Cairo</h4>
                </li>
                <li>
                  <h3 class="title">Address</h3>
                  <h4 class="info">Egypt, Mansoura, 6 oct street</h4>
                </li>
              </ul>
            </div>
            <div class="grand-border-box">
              <h3 class="title">
                Interests
              </h3>
              <div class="grand-tag-box m-2">
                Traveling
              </div>
              <div class="grand-tag-box m-2">
                Vlogger
              </div>
              <div class="grand-tag-box m-2">
                Traveling
              </div>
              <div class="grand-tag-box m-2">
                Vlogger
              </div>
              <div class="grand-tag-box m-2">
                Traveling
              </div>
              <div class="grand-tag-box m-2">
                Vlogger
              </div>
            </div>
            <div class="grand-border-box">
              <ul class="list-unstyled-grand-list-info">
                <li>
                  <h3 class="title">Category</h3>
                  <h4 class="info">Teacher</h4>
                </li>
                <li>
                  <h3 class="title">Classification</h3>
                  <h4 class="info">---</h4>
                </li>
                <li>
                  <h3 class="title">Languages</h3>
                  <h4 class="info">AR - EN</h4>
                </li>
              </ul>
            </div>
            <div class="grand-border-box">
              <ul class="list-unstyled-grand-list-info">
                <li>
                  <h3 class="title">Code</h3>
                  <h4 class="info">#963251</h4>
                </li>
                <li>
                  <h3 class="title">QR Code</h3>
                  <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkaHBiWVhfSbrseUaPeFtW84Am7eJLV_CmZg&usqp=CAU"
                    alt="" class="img-fluid qr-code">
                </li>

              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-8 mb-4">
          <div class="grand-tabs-box">
            <ul class="nav grand-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link  " id="snapchat-tab" data-toggle="tab" data-target="#snapchat" type="button"
                  role="tab" aria-controls="snapchat" aria-selected="true">Snapchat</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="instagram-tab" data-toggle="tab" data-target="#instagram"
                  type="button" role="tab" aria-controls="instagram" aria-selected="false">Instagram</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link " id="tiktok-tab" data-toggle="tab" data-target="#tiktok" type="button"
                  role="tab" aria-controls="tiktok" aria-selected="false">Tiktok</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link " id="pinterest-tab" data-toggle="tab" data-target="#pinterest" type="button"
                  role="tab" aria-controls="pinterest" aria-selected="false">Pinterest</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade  " id="snapchat" role="tabpanel" aria-labelledby="snapchat-tab">
                <div class="grand-tabs-inner-box">
                  <ul class="nav grand-inner-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link  " id="Videos-tab" data-toggle="tab" data-target="#Videos" type="button"
                        role="tab" aria-controls="Videos" aria-selected="true">Videos</button>
                    </li>
                    <li class="nav-item " role="inner-tab">
                      <button class="nav-link active" id="Posts-tab" data-toggle="tab" data-target="#Posts"
                        type="button" role="tab" aria-controls="Posts" aria-selected="false">Posts</button>
                    </li>
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link " id="Reels-tab" data-toggle="tab" data-target="#Reels" type="button"
                        role="tab" aria-controls="Reels" aria-selected="false">Reels</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  " id="Videos" role="tabpanel" aria-labelledby="Videos-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img src="https://www.imgacademy.com/sites/default/files/legacyhotel.jpg" alt=""
                                class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade show active" id="Posts" role="tabpanel" aria-labelledby="Posts-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="Reels" role="tabpanel" aria-labelledby="Reels-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show active" id="instagram" role="tabpanel" aria-labelledby="instagram-tab">
                <div class="grand-tabs-inner-box">
                  <ul class="nav grand-inner-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link  " id="instagram-Videos-tab" data-toggle="tab"
                        data-target="#instagram-Videos" type="button" role="tab" aria-controls="instagram-Videos"
                        aria-selected="true">Videos</button>
                    </li>
                    <li class="nav-item " role="inner-tab">
                      <button class="nav-link active" id="instagram-Posts-tab" data-toggle="tab"
                        data-target="#instagram-Posts" type="button" role="tab" aria-controls="instagram-Posts"
                        aria-selected="false">Posts</button>
                    </li>
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link " id="instagram-Reels-tab" data-toggle="tab"
                        data-target="#instagram-Reels" type="button" role="tab" aria-controls="instagram-Reels"
                        aria-selected="false">Reels</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  " id="instagram-Videos" role="tabpanel"
                      aria-labelledby="instagram-Videos-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade show active" id="instagram-Posts" role="tabpanel"
                      aria-labelledby="instagram-Posts-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="instagram-Reels" role="tabpanel"
                      aria-labelledby="instagram-Reels-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tiktok" role="tabpanel" aria-labelledby="tiktok-tab">
                <div class="grand-tabs-inner-box">
                  <ul class="nav grand-inner-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link  " id="tiktok-Videos-tab" data-toggle="tab" data-target="#tiktok-Videos"
                        type="button" role="tab" aria-controls="tiktok-Videos" aria-selected="true">Videos</button>
                    </li>
                    <li class="nav-item " role="inner-tab">
                      <button class="nav-link active" id="tiktok-Posts-tab" data-toggle="tab"
                        data-target="#tiktok-Posts" type="button" role="tab" aria-controls="tiktok-Posts"
                        aria-selected="false">Posts</button>
                    </li>
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link " id="tiktok-Reels-tab" data-toggle="tab" data-target="#tiktok-Reels"
                        type="button" role="tab" aria-controls="tiktok-Reels" aria-selected="false">Reels</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  " id="tiktok-Videos" role="tabpanel" aria-labelledby="tiktok-Videos-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade show active" id="tiktok-Posts" role="tabpanel"
                      aria-labelledby="tiktok-Posts-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="tiktok-Reels" role="tabpanel" aria-labelledby="tiktok-Reels-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pinterest" role="tabpanel" aria-labelledby="pinterest-tab">
                <div class="grand-tabs-inner-box">
                  <ul class="nav grand-inner-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link  " id="pinterest-Videos-tab" data-toggle="tab"
                        data-target="#pinterest-Videos" type="button" role="tab" aria-controls="pinterest-Videos"
                        aria-selected="true">Videos</button>
                    </li>
                    <li class="nav-item " role="inner-tab">
                      <button class="nav-link active" id="pinterest-Posts-tab" data-toggle="tab"
                        data-target="#pinterest-Posts" type="button" role="tab" aria-controls="pinterest-Posts"
                        aria-selected="false">Posts</button>
                    </li>
                    <li class="nav-item" role="inner-tab">
                      <button class="nav-link " id="pinterest-Reels-tab" data-toggle="tab"
                        data-target="#pinterest-Reels" type="button" role="tab" aria-controls="pinterest-Reels"
                        aria-selected="false">Reels</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  " id="pinterest-Videos" role="tabpanel"
                      aria-labelledby="pinterest-Videos-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade show active" id="pinterest-Posts" role="tabpanel"
                      aria-labelledby="pinterest-Posts-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pinterest-Reels" role="tabpanel"
                      aria-labelledby="pinterest-Reels-tab">
                      <div class="row">
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 mb-4">
                          <div class="social-img-content-box">
                            <div class="social-img-box">
                              <img
                                src="https://media-cdn.tripadvisor.com/media/photo-s/0c/bb/a3/97/predator-ride-in-the.jpg"
                                alt="" class="img-fluid">
                            </div>
                            <div class="social-content-box">
                              <ul class="list-unstyled">
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-message"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                                <li>

                                  <div class="item">
                                    <i class="fa-solid fa-share"></i>
                                    <span>3450</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


@endsection

@section('js')
@include('admin.dashboard.layouts.includes.general.scripts.index')

<script>
$(document).on('click', '.acceptRow', function() {
  $('#expre_date_err').hide();
  $('#expre_date_err').text('')
  let id = $(this).data('id');
  let data_flag = $(this).data('flag');
  $('#add_expiration_date').modal('show')
  $(document).on('click', '#active_user', function() {
    swalAccept(id, data_flag);
  });
});
//inaccept row
$(document).on('click', '.InAcceptRow', function() {

  let id = $(this).data('id');
  let data_flag = $(this).data('flag');
  swalAccept(id, data_flag);
});

//reject Row
$(document).on('click', '.rejectRow', function() {
  let id = $(this).data('id');
  let data_flag = $(this).data('flag');
  swalAccept(id, data_flag);
});

function swalAccept(id, data_flag) {
  console.log(data_flag);
  let accetp_swal = Swal.fire({
    title: "Are you sure you want to " + data_flag + "?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: data_flag,
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    closeOnCancel: false
  }).then(function(result) {
    if (result.isConfirmed) {
      let expire_date = ($('#expire_date_input').val() != '' && $('#expire_date_input').val() != null) ? $(
        '#expire_date_input').val() : -1;
      $.ajax({
        url: `/dashboard/influencer-accept/${id}`,
        type: 'post',
        data: {
          expire_date,
          data_flag
        },
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
          if (data.status) {
            // $('.acceptRow').attr("disabled", 'disabled');
            $('.fa-circle').addClass('active')
            $('.fa-circle').attr('title', 'Active')
            $('.fa-circle').attr('data-original-title', 'Active')
            $('#add_expiration_date').modal('hide')
            $('#expire_date_input').val('')
            Swal.fire("accepted!", data.message, "success");
            location.reload();
          } else {
            Swal.fire.close();
            let err = data.message.expirations_date[0];
            $('#expre_date_err').show();
            $('#expre_date_err').text(err)
          }
        },
        error: (data) => {
          // console.log(data);
        }
      })
    } else {
      $('#add_expiration_date').modal('hide')
      $('#expire_date_input').val('')
      Swal.fire("Cancelled", "canceled successfully!", "error");
    }
  })
}
</script>
@endsection
