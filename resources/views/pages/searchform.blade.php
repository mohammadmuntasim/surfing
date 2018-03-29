<ul class="nav nav-tabs">
		
	@if(!isset($_GET['role_id']))
	<li class="active"><a data-toggle="tab" href="#sh0">Doctors</a></li>
	@else  
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==2): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#sh0"> Doctors     </a></li>
	@endif
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==6): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#sh1"> Dentists     </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==5): echo 'class="active"'; endif; endif; ?>> <a data-toggle="tab" href="#sh3"> Wellness  </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==7): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#sh4"> Elder Care </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']==4): echo 'class="active"'; endif; endif; ?>><a data-toggle="tab" href="#sh2"> Hospitals     </a></li>
	<li <?php if(isset($_GET['role_id'])): if($_GET['role_id']=='people'): echo 'class="active"'; endif; endif; ?> ><a data-toggle="tab" href="#people">People</a></li>
	
	<li><a  href="{{url('/user/discountpage')}}">Discount Card</a></li>
</ul>
<div class="tab-content">
<!-- People Tab-->

<div id="people" class="tab-pane fade <?php  if(isset($_GET['role_id'])): if($_GET['role_id']=='people'): echo 'in active'; endif; endif; ?> ">

	<form class="navbar-form navbar-search form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
		{{ csrf_field() }}
		<input type="hidden" name="role_id" value="people">
		<div class="input-group custom-search-form">
			<div class="col-md-9 col-sm-8 col-xs-12">
				<h5>People	</h5>
				<input type="text" class="form-control"  id="namekeysearchpage" name="namekeysearch" placeholder="Search for People" value="<?php if(isset($_GET['namekeysearch']) ): echo $_GET['namekeysearch']; endif; ?>" >
			</div>
			@if(Auth::guest())
			<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
				@else
				<div class="col-md-3 col-sm-4 col-xs-12   ">
					@endif
					<span class="input-group-btn">
					<button class="btn btn-default-sm searchform-btn-alignment" type="submit">
					Search
					</button>
					@if(Auth::guest())
					<button class="btn btn-default-sm search-signup searchform-btn-alignment" type="button">
					<a href="{{url('\register')}}" style="color:white">Sign Up</a>
					</button>
					@endif
					</span>
				</div>
			</div>
	</form>
</div>
@if(!isset($_GET['role_id']))
<div id="sh0" class="tab-pane fade in active">
@else
<div id="sh0" class="tab-pane fade   <?php  if(isset($_GET['role_id'])): if($_GET['role_id']==2): echo 'in active'; endif; endif; ?> @if(Request::url()==url('/')) in active @endif">
@endif
	<form class="navbar-form navbar-search form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
		{{ csrf_field() }}
		<input type="hidden" name="role_id" value="2">
		<div class="input-group custom-search-form">
			<div class="col-md-3 col-sm-4 col-xs-12">
				<h5>speciality</h5>
				<select data-live-search-placeholder="Search Speciality" class="form-control selectpicker" id="speciality_id" data-live-search="true" tabindex="-98" name="speciality_id">
				<option selected="" value="0" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a speciality</option>
				@foreach($searchdropdown['docspeciality'] as $doctordata)
				<option value="{{ $doctordata->speciality }}" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == $doctordata->speciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordata->speciality }}</option>
		    	@endforeach
				</select>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<h5>INSURANCE PROVIDER</h5>
				<select data-live-search-placeholder="Type In Insurance" class="form-control selectpicker" id="insur_provider" data-live-search="true" tabindex="-98" name="insur_provider">
				<option selected="" value="0" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Select Insurance Provider</option>
				@foreach($searchdropdown['insurances'] as $doctordatas)
				<option value="{{ $doctordatas }}" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == $doctordatas): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordatas }}</option>
				@endforeach
				</select>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<h5>Location</h5>
				<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
			</div>
			@if(Auth::guest())
			<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
				@else
				<div class="col-md-3 col-sm-4 col-xs-12   ">
					@endif
					<span class="input-group-btn">
					<button class="btn btn-default-sm searchform-btn-alignment" type="submit">
					Search
					</button>
					@if(Auth::guest())
					<button class="btn btn-default-sm search-signup searchform-btn-alignment" type="button">
					<a href="{{url('\register')}}" style="color:white">Sign Up</a>
					</button>
					@endif
					</span>
				</div>
			</div>
	</form>
</div>

<!--dentist-->
<div id="sh1" class="tab-pane fade  <?php if(isset($_GET['role_id'])): if($_GET['role_id']==6): echo 'in active'; endif; endif; ?>">
<form class="navbar-form navbar-search form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="6">
	<div class="input-group custom-search-form">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<h5>speciality</h5>
			<select data-live-search-placeholder="Search Speciality" class="form-control selectpicker" id="speciality_id" data-live-search="true" tabindex="-98" name="speciality_id">
			<option selected="" value="0" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a speciality</option>
			@foreach($searchdropdown['denspeciality'] as $doctordatad)
			<option value="{{ $doctordatad->denspeciality }}" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == $doctordatad->denspeciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordatad->denspeciality }}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-5 col-sm-4 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
		</div>
		@if(Auth::guest())
		<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
			@else
			<div class="col-md-3 col-sm-4 col-xs-12   ">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm search-signup" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<div id="sh2" class="tab-pane fade <?php if(isset($_GET['role_id'])): if($_GET['role_id']==4): echo 'in active'; endif; endif; ?>">
<form class="navbar-form navbar-search form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="4">
	<div class="input-group custom-search-form">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<h5>KEYWORD</h5>
			<input type="text" class="form-control" name="keysearch" placeholder="Search Hospital Name" value="<?php if(isset($_GET['keysearch']) ): echo $_GET['keysearch']; endif; ?>" >
		</div>
		<div class="col-md-5 col-sm-4 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county">
		</div>
		@if(Auth::guest())
		<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
			@else
			<div class="col-md-3 col-sm-4 col-xs-12   ">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm search-signup" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<!---Wellness-->
<div id="sh3" class="tab-pane fade <?php if(isset($_GET['role_id'])): if($_GET['role_id']==5): echo 'in active'; endif; endif; ?>">
<form class="navbar-form navbar-search form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
	{{ csrf_field() }}
	<input type="hidden" name="role_id" value="5">
	<div class="input-group custom-search-form">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<h5>speciality</h5>
			<select data-live-search-placeholder="Search Individual Name or Company Name" class="form-control selectpicker" id="speciality_id" data-live-search="true" tabindex="-98" name="speciality_id">
			<option selected="" value="0" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a speciality</option>
			@foreach($searchdropdown['wellnessspeciality'] as $doctordataw)
			<option value="{{ $doctordataw->well_speciality }}" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == $doctordataw->well_speciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordataw->well_speciality }}</option>
			@endforeach
			</select>
		</div>
		<div class="col-md-5 col-sm-4 col-xs-12">
			<h5>Location</h5>
			<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
		</div>
		@if(Auth::guest())
		<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
			@else
			<div class="col-md-3 col-sm-4 col-xs-12   ">
				@endif
				<span class="input-group-btn">
				<button class="btn btn-default-sm" type="submit">
				Search
				</button>
				@if(Auth::guest())
				<button class="btn btn-default-sm search-signup" type="button">
				<a href="{{url('\register')}}" style="color:white">Sign Up</a>
				</button>
				@endif
				</span>
			</div>
		</div>
</form>
</div>
<!---elder care -->      
<div id="sh4" class="tab-pane fade <?php if(isset($_GET['role_id'])): if($_GET['role_id']==7): echo 'in active'; endif; endif; ?>">
	<form class="navbar-form navbar-search form-horizontal" role="form" method="GET" action="{{ url('/search') }}">
		{{ csrf_field() }}
		<input type="hidden" name="role_id" value="7">
		<div class="input-group custom-search-form">
			<div class="col-md-3 col-sm-4 col-xs-12">
				<h5>speciality</h5>
				<select data-live-search-placeholder="Search Individual Name or Company Name" class="form-control selectpicker" id="speciality_id" data-live-search="true" tabindex="-98" name="speciality_id">
				<option selected="" value="0" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Choose a speciality</option>
				@foreach($searchdropdown['eldercarespeciality'] as $doctordataelder)
				<option value="{{ $doctordataelder->elder_speciality }}" <?php if(isset($_GET['speciality_id']) && $_GET['speciality_id'] == $doctordataelder->elder_speciality): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordataelder->elder_speciality }}</option>
				@endforeach
				</select>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<h5>INSURANCE PROVIDER</h5>
				<select data-live-search-placeholder="Search in Insurance"class="form-control selectpicker" id="insur_provider" data-live-search="true" tabindex="-98" name="insur_provider">
				<option selected="" value="0" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == 0): ?>{{ 'selected="selected"' }} <?php endif; ?>>Select Insurance Provider</option>
				@foreach($searchdropdown['insurances'] as $doctordatas)
				<option value="{{ $doctordatas }}" <?php if(isset($_GET['insur_provider']) && $_GET['insur_provider'] == $doctordatas): ?>{{ 'selected="selected"' }} <?php endif; ?>>{{ $doctordatas}}</option>
				@endforeach
				</select>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<h5>Location</h5>
				<input type="text" class="form-control" name="locations" placeholder="Zip code, city or county" value="<?php if(isset($_GET['locations']) ): echo $_GET['locations']; endif; ?>" >
			</div>
			@if(Auth::guest())
			<div class="col-md-3 col-sm-4 col-xs-12  signupsss ">
				@else
				<div class="col-md-3 col-sm-4 col-xs-12   ">
					@endif
					<span class="input-group-btn">
					<button class="btn btn-default-sm" type="submit">
					Search
					</button>
					@if(Auth::guest())
					<button class="btn btn-default-sm search-signup" type="button">
					<a href="{{url('\register')}}" style="color:white">Sign Up</a>
					</button>
					@endif
					</span>
				</div>
			</div>
	</form>
	</div>
</div>