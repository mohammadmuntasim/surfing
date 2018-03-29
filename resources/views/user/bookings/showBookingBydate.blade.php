@extends('layouts.app')
@section('content')
<style type="text/css">
   
    /*Filter START*/
.filterable {
    margin-top: 15px;
}
.filterable .panel-heading .pull-right {
    margin-top: -20px;
}
.filterable .filters input[disabled] {
    background-color: transparent;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters input[disabled]::-webkit-input-placeholder {
    color: #333;
}
.filterable .filters input[disabled]::-moz-placeholder {
    color: #333;
}
.filterable .filters input[disabled]:-ms-input-placeholder {
    color: #333;
}
/*Filter END*/

.table-widthB{
    width: 48%;
    }
    
.table-widthA{
    width: 49.8%;
    }
    
.bg{
    background-color: white;
    }  
      
.tablescroll {
    overflow-y: auto;
	overflow-x: hidden;
	height: 189px;
	margin-right: 1px;
}
/*.marginTop30{
    margin-top:30px;
}*/

.radio,
.checkbox {
  margin-top: 0px;
  margin-bottom: 0px;
  }
  
  .checkbox,.radio{
  margin-top:0px;
  margin-bottom:0px
  }
  
.radio-margin{
    margin-left: -13px;
	margin-top: 7px;
}
.radio-margin{
    margin-left: -13px;
    margin-top: 7px;
}
.EU_DataTable td, th {
  padding: 6px;
  border: 1px solid #ccc;
  text-align: left;
  height: 50px;
}
th {
  background: #e5e5e5;
  color: #454545;
  font-weight: bold;
  height: 40px;
}
/*Radio and Checkbox START*/
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
/*Radio and Checkbox END*/
</style>
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
            <div class="creatediv1 marginTop30">
					<div class="col-md-12">
						<div class="panel panel-primary filterable">
							<div class="panel-heading">
								<h3 class="panel-title">Appointments<span style="color: white; font-weight: bold;"> *</span></h3>
								<div class="pull-right">
									<button type="button" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
								</div>
							</div>
							<table class="span12">
								<table>
									<tr class="filters">
									<th style="width: 4.1%; width:50px;">
										<div class="checkbox radio-margin">
											<label>
												<input type="checkbox" value="">
												<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
											</label>
										</div>
									</th>
									<th style="width: 25%">
										<input type="text" class="form-control" placeholder="Cost Center Name" disabled>
									</th>
									<th style="width: 25%">
										<input type="text" class="form-control" placeholder="Cost Center ID" disabled>
									</th>
									<th style="width: 25%">
										<input type="text" class="form-control" placeholder="Cost Center ID" disabled>
									</th>
									<th style="width: 25%">
										<input type="text" class="form-control" placeholder="Cost Center ID" disabled>
									</th>
									</tr>
								</table>
								<div class="bg tablescroll">
									
									<table class="table table-bordered table-striped">
										@if(sizeof($data['showbookings'])>0)
										 @foreach($data['showbookings'] as $bookings)
										<tr>
											<td style="width: 4.1%; width:50px;">
												<div class="checkbox radio-margin">
													<label>
														<input type="checkbox" value="">
														<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
													</label>
												</div>
											</td>
											
											<td style="width: 25%">{{$bookings->patient_full_name}}</td>
											<td style="width: 25%">{{$bookings->patient_full_name}}</td>
												<td style="width: 25%">BYU-I</td>
											<td style="width: 25%">542584612548</td>
										</tr>
										@endforeach
										@endif
										
										
									</table>
								</div>
							</table>
						</div>
					</div>
				</div>
   			
		</div>
	</div>
</div>
</section>
@endsection