@extends('admin.dashboard.layouts.app')

@section('title','Admins')


@section('style')

    @include('admin.dashboard.layouts.includes.general.styles.index')
@endsection

@section('page-header')
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Admins'])
@stop
@section('content')
<form method="post" action="{{route('dashboard.updateprofile')}}">
                            @csrf

			<!-- Row start -->
            <div class="row gutters">
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
							<div class="card h-100">
								<div class="card-body">
									<div class="account-settings">
										<div class="user-profile">
											<div class="user-avatar">

												<img src="{{$user ? $user->image : '/assets/img/avatar_logo.png'}}" alt="Maxwell Admin" />
											</div>
											<h5 class="user-name">{{$user ? $user->name : '-'}}</h5>
											<h6 class="user-email">{{$user->email ?? '-'}}</h6>
										</div>

									</div>
								</div>
							</div>
						</div>


						<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
							<div class="card h-100">
								<div class="card-body">
									<div class="row gutters">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<h6 class="mb-2 text-primary">Personal Details</h6>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="fullName">Name</label>
												<input type="text" value="{{$user->name}}" name="name" class="form-control" id="fullName" placeholder="Enter full name">
											</div>
										</div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="fullName">User Name</label>
												<input readOnly type="text" value="{{$user->username}}" name="user_name" class="form-control" id="fullName" placeholder="Enter username">
											</div>
										</div>
                                        <input type="hidden" name="id" value="{{$user->id}}">
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="eMail">Email</label>
												<input readOnly type="email" value="{{$user->email}}" name="email" class="form-control" id="eMail" placeholder="Enter email Address">
											</div>
										</div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="phone">Image</label>
												<input type="file" name="image" class="form-control" id="phone" placeholder="">
											</div>
										</div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="phone">Password</label>
												<input type="password" name="password" class="form-control" id="phone" placeholder="Enter password">
											</div>
										</div>

									</div>
									<!-- <div class="row gutters">

										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="Street">Street</label>
												<input type="name" class="form-control" id="Street" placeholder="Enter Street">
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label for="ciTy">City</label>
												<input type="name" class="form-control" id="ciTy" placeholder="Enter City">
											</div>
										</div>


									</div> -->
									<div class="row gutters">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="text-right">
												<button type="button" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
												<button type="submit" id="submit" class="btn btn-primary">Update</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
</form>
					<!-- Row end -->
@endsection

