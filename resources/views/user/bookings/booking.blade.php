@extends('layouts.app')
@section('content')
<section class="main-content">
	<div class="dd-userport">
		<div class="container">
			<div class="row"> 
				@include('user.profilehead')
			</div>
		</div>
	</div>

	<div class="main-content-holder">
	<div class="container">
		<div class="row">
			<div class="col-md-9 pl">
				<!-- Nav tabs -->
				<div class="card">

					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#myappo" aria-controls="profile" role="tab" data-toggle="tab">Your Appointments</a></li>
						<li role="presentation"><a href="#bookings" aria-controls="profile" role="tab" data-toggle="tab">Your Bookings</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<form action="{{url('/booking')}}" class="profile-edit-form" method="get">
							<div class="dd-refer-search">
								<div class="input-group">
									<input type="text" class="form-control"  placeholder="Select Date"  type="text" name="checkdate" id="patientdob">                        
									<span class="input-group-btn">
									<button class="btn btn-default" type="submit" >Go!</button>
									</span>
								</div>
								<!-- /input-group -->
							</div>
						</form>
						<!--my appointments start-->
						<div role="tabpanel" class="tab-pane active" id="myappo">
							<div class="dd-content-inner fw dd-card">
								<div class="dd-common-inner-title">
									<h3>Patients ({{$data['dates']}})</h3>
								</div>
								<form action="{{url('/booking')}}" class="canceldoc" id="canceldoc" method="post">
									{{ csrf_field() }}
									<input type="hidden" class="form-control" value="{{ app('request')->input('checkdate') }}"  type="text" name="checkdate" > 
									<div class="pull-right"> <button class="btn btn-default "  name="canceldoc" id="mybutton" type="button" >Cancel</button> </div>
									<div class="dd-grid-2-column dd-grid-style-two">
										@if(!empty($data['showpatients']))
										@php($i=0)
										@foreach($data['showpatients'] as $showappointments)
										@php ($userprofilepicreview = $data['userdatabyid']->getUserData(['id' => $showappointments->patient_id]) )
										<!-- user info foreach start-->
										@foreach($userprofilepicreview as $userMetaDatapicreview)      
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="dd-grid-item">
												<figure class=" col-md-1 col-sm-1 col-xs-12">
													<input type="checkbox" id="myCheckbox{{$i}}" name="cancelbydoc[]"  value="{{$showappointments->id}}"/>
													<label for="myCheckbox{{$i}}">
													<img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}" title="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}">
													</label> {{ $showappointments->patient_full_name}}
												</figure>
												<div class=" col-md-11 col-sm-11 col-xs-12">
													<ul class="list-group">
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-calendar" aria-hidden="true"></i> {{$showappointments->patient_dob}} </small>
														</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-phone" aria-hidden="true"></i> {{$showappointments->phone_number}} </small>
														</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-envelope" aria-hidden="true"></i> {{$showappointments->patient_email}} </small>
														</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small>
															@if($showappointments->patient_type='new')
															<i class="fa fa-user" aria-hidden="true"></i>
															@else
															<i class="fa fa-users" aria-hidden="true"></i>
															@endif
															{{ $showappointments->patient_type}}</small>
														</li>
													</ul>
													<ul class="list-group">
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">Reason for Visit:</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->reason_for_visit}}</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">Gender:</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_gender}}</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">Insurance Provider:    </li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_insurance_provider}}</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"> @if($showappointments->status==1) Cancelled By Patient @elseif($showappointments->status==2)Cancelled By  You @else Processing @endif</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><a  href="{{url('/appointments')}}/?ref_app={{ $data['encrypt']->encryptIt($showappointments->patient_id)}}">See Profile</a></li>
													</ul>
												</div>
											</div>
										</div>
										@endforeach
										@php($i++)
										@endforeach
										@else
										<div class="text-center"> No Booking Founds</div>
										@endif
									</div>
								</form>
							</div>
						</div>
						<!--my appointments end-->
						<div role="tabpanel" class="tab-pane " id="bookings">
							<div class="dd-content-inner fw dd-card">
								<div class="dd-common-inner-title">
									<h3>Doctors Appointments</h3>
								</div>
							<form action="{{url('/booking')}}" class="cancelpat" id="cancelpat" method="post">
									{{ csrf_field() }}
									<input type="hidden" class="form-control" value="{{ app('request')->input('checkdate') }}"  type="text" name="checkdate" > 
									<div class="pull-right"> <button class="btn btn-default " name="cancelpat" id="mybutton" type="button" >Cancel</button> </div>
									<div class="dd-grid-2-column dd-grid-style-two">
										@if(!empty($data['showbookings']))
										@php($i=0)
										@foreach($data['showbookings'] as $showappointments)
										@php ($userprofilepicreview = $data['userdatabyid']->getUserData(['id' => $showappointments->patient_id]) )
										<!-- user info foreach start-->
										@foreach($userprofilepicreview as $userMetaDatapicreview)      
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="dd-grid-item">
												<figure class=" col-md-1 col-sm-1 col-xs-12">
													<input type="checkbox" id="myCheckboxs{{$i}}" name="cancelbypat[]"  value="{{$showappointments->id}}"/>
													<label for="myCheckboxs{{$i}}">
													<img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}" title="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}">
													</label> {{ $showappointments->patient_full_name}}
												</figure>
												<div class=" col-md-11 col-sm-11 col-xs-12">
													<ul class="list-group">
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-calendar" aria-hidden="true"></i> {{$showappointments->patient_dob}} </small>
														</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-phone" aria-hidden="true"></i> {{$showappointments->phone_number}} </small>
														</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-envelope" aria-hidden="true"></i> {{$showappointments->patient_email}} </small>
														</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small>
															@if($showappointments->patient_type='new')
															<i class="fa fa-user" aria-hidden="true"></i>
															@else
															<i class="fa fa-users" aria-hidden="true"></i>
															@endif
															{{ $showappointments->patient_type}}</small>
														</li>
													</ul>
													<ul class="list-group">
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">Reason for Visit:</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->reason_for_visit}}</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">Gender:</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_gender}}</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">Insurance Provider:    </li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_insurance_provider}}</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"> @if($showappointments->status==1) Cancelled By Patient @elseif($showappointments->status==2)Cancelled By  You @else Processing @endif</li>
														<li class="list-group-item col-md-3 col-sm-3 col-xs-12"><a  href="{{url('/appointments')}}/?ref_app={{ $data['encrypt']->encryptIt($showappointments->patient_id)}}">See Profile</a></li>
													</ul>
												</div>
											</div>
										</div>
										@endforeach
										@php($i++)
										@endforeach
										@else
										<div class="text-center"> No Booking Founds</div>
										@endif
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 pr">
				<div class="dd-advertise-holder">
					@include('user.sidebar')
				</div>
			</div>
		</div>
	</div>
</section>
<div id="dialog" title="Confirmation Required">
	Are you sure cancel these appointments?
</div>
@include('user.bookings.bookappointment')
@endsection