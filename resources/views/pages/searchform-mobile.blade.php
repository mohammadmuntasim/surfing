<ul class="nav nav-tabs">
	@if(!isset($_GET['role_id']))
	<li  class="active" ><a data-toggle="tab" href="#msh0">Doctors</a></li>
	@else  
	<li  <?php if(isset($_GET['role_id'])): if($_GET['role_id']==2): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#msh0">Doctors</a></li>
	@endif
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==3): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#msh1"> Dentist     </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==5): echo 'class="active"'; endif; endif; ?>> <a data-toggle="tab" href="#msh3"> Wellness  </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==6): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#msh4"> Elder Care </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==4): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#msh2"> Hospital     </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']=='people'): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#mpeople"> People     </a></li>
	<li><a  href="{{url('/user/discountpage')}}">Discount Card</a></li>
</ul>
<div class="tab-content">
@if(!isset($_GET['role_id']))
<div id="msh0" class="tab-pane fade in active">
@else
<div id="sh0" class="tab-pane fade  @if(Request::url()==url('/')) in active @endif <?php if(isset($_GET['role_id'])): if($_GET['role_id']==2): echo 'in active'; endif; endif; ?>">
@endif 
<form class="form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="2">
	<div class="input-group custom-search-form row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h5>Specialty</h5>
			<select class="der-height form-control data-live-search-placeholder="Search Speciality"  selectpicker" id="specialty_id" data-live-search="true" tabindex="-98" name="specialty_id">
			<option selected="" value="0" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a Specialty</option>
			@foreach($searchdropdown['docspeciality'] as $doctordata)
			<option value="{{ $doctordata->speciality }}" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == $doctordata->speciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordata->speciality }}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h5>INSURANCE PROVIDER</h5>
			<select data-live-search-placeholder="Type In Insurance" class="form-control selectpicker insur_providers" id="insur_provider" data-live-search="true" tabindex="-98" name="insur_provider">
			<option selected="" value="0" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Select Insurance Provider</option>
			@foreach($searchdropdown['providers'] as $doctordatas)
			<option value="{{ $doctordatas->insur_provider }}" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == $doctordatas->insur_provider): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordatas->insur_provider }}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control sel-location" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
		</div>
		@if(Auth::guest())
		<div class="col-md-12 col-sm-12 col-xs-12  signupsss ">
			@else
			<div class="col-md-12 col-sm-12 col-xs-12   ">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<!-- People Tab-->
<div id="mpeople" class="tab-pane fade  <?php if(isset($_GET['role_id'])): if($_GET['role_id']=='people'): echo 'in active'; endif; endif; ?>">
<form class="form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="people">
	<div class="input-group custom-search-form">
		<div class="col-md-9 col-sm-8 col-xs-12">
			<h5>People</h5>
			<input type="text" class="form-control"  id="namekeysearchpage" name="namekeysearch" placeholder="Search by people" value="<?php if(isset($_GET['namekeysearch']) ): echo $_GET['namekeysearch']; endif; ?>" >
		</div>
		@if(Auth::guest())
		<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
			@else
			<div class="col-md-3 col-sm-4 col-xs-12   ">
				@endif
				<span class="input-group-btn mar-top15">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<!--dentist-->
<div id="msh1" class="tab-pane fade  <?php if(isset($_GET['role_id'])): if($_GET['role_id']==3): echo 'in active'; endif; endif; ?>">
<form class="form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="3">
	<div class="input-group custom-search-form">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<h5>Specialty</h5>
			<select data-live-search-placeholder="Search Dentist Name"  class="form-control selectpicker" id="specialty_id" data-live-search="true" tabindex="-98" name="specialty_id">
			<option selected="" value="0" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a Specialty</option>
			@foreach($searchdropdown['denspeciality'] as $doctordatad)
			<option value="{{ $doctordatad->denspeciality }}" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == $doctordatad->denspeciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordatad->denspeciality }}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
		</div>
		@if(Auth::guest())
		<div class="col-md-12 col-sm-12 col-xs-12  signupsss ">
			@else
			<div class="col-md-12 col-sm-12 col-xs-12 float-right">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<div id="msh2" class="tab-pane fade <?php if(isset($_GET['role_id'])): if($_GET['role_id']==4): echo 'in active'; endif; endif; ?>">
<form class="form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="4">
	<div class="input-group custom-search-form">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<h5>KEYWORD</h5>
			<input type="text" class="form-control" name="keysearch" placeholder="Start typing hospital name" value="<?php if(isset($_GET['keysearch']) ): echo $_GET['keysearch']; endif; ?>" >
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county">
		</div>
		@if(Auth::guest())
		<div class="col-md-12 col-sm-12 col-xs-12  signupsss ">
			@else
			<div class="col-md-12 col-sm-12 col-xs-12   ">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<!---Wellness-->
<div id="msh3" class="tab-pane fade <?php if(isset($_GET['role_id'])): if($_GET['role_id']==5): echo 'in active'; endif; endif; ?>">
<form class="form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="5">
	<div class="input-group custom-search-form">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<h5>Specialty</h5>
			<select data-live-search-placeholder="Search Individual Name or Company Name" class="form-control selectpicker" id="specialty_id" data-live-search="true" tabindex="-98" name="specialty_id">
			<option selected="" value="0" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a Specialty</option>
			@foreach($searchdropdown['wellnessspeciality'] as $doctordataw)
			<option value="{{ $doctordataw->well_speciality }}" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == $doctordataw->well_speciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordataw->well_speciality }}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
		</div>
		@if(Auth::guest())
		<div class="col-md-12 col-sm-12 col-xs-12  signupsss ">
			@else
			<div class="col-md-12 col-sm-12 col-xs-12   ">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<!---elder care -->      
<div id="msh4" class="tab-pane fade <?php if(isset($_GET['role_id'])): if($_GET['role_id']==6): echo 'in active'; endif; endif; ?>">
	<form class="form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
		{{ csrf_field() }}
		<input type="hidden" name="role_id" value="6">
		<div class="input-group custom-search-form">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h5>Specialty</h5>
				<select data-live-search-placeholder="Search Individual Name or Company Name" class="form-control selectpicker" id="specialty_id" data-live-search="true" tabindex="-98" name="specialty_id">
				<option selected="" value="0" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a Specialty</option>
				@foreach($searchdropdown['eldercarespeciality'] as $doctordataelder)
				<option value="{{ $doctordataelder->elder_speciality }}" <?php if(isset($_GET['specialty_id']) && $_GET['specialty_id'] == $doctordataelder->elder_speciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordataelder->elder_speciality }}</option>
				@endforeach
				</select>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h5>INSURANCE PROVIDER</h5>
				<select data-live-search-placeholder="Search in Insurance" class="form-control selectpicker" id="insur_provider" data-live-search="true" tabindex="-98" name="insur_provider">
				<option selected="" value="0" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Select Insurance Provider</option>
				@foreach($searchdropdown['providers'] as $doctordatas)
				<option value="{{ $doctordatas->insur_provider }}" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == $doctordatas->insur_provider): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordatas->insur_provider }}</option>
				@endforeach
				</select>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h5>Location</h5>
				<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
			</div>
			@if(Auth::guest())
			<div class="col-md-12 col-sm-12 col-xs-12  signupsss ">
				@else
				<div class="col-md-12 col-sm-12 col-xs-12   ">
					@endif
					<span class="input-group-btn">
					<button class="btn btn-default-sm" type="submit">
					Search
					</button>
					@if(Auth::guest())
					<button class="btn btn-default-sm" type="button">
					<a href="{{url('\register')}}" style="color:white">Sign Up</a>
					</button>
					@endif
					</span>
				</div>
			</div>
	</form>
	</div>
</div>