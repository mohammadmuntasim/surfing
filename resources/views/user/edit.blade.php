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
  <style type="text/css">
.fudugo-tab-content.active ul.dropdown-menu.inner {
    max-height: 120px !important;
    overflow-y: scroll;
}
div#fields .col-lg-6.col-md-12.col-sm-12.form-colmns {
    padding-right: 15px;
}

.fudugo-tab-content input,.form-control { border-radius: 0;}
.avaails.col-md-4 {
    font-weight: 800;
    line-height: 32px;
}
.bootstrap-tagsinput .tag {margin-right: 2px;color: white;font-size: 14px;}
.{cursor: not-allowed; text-decoration:none;pointer-events: none;}
  </style>
  @if(Auth::check())
  @php($userMeta = $data['userInformationMetaData'])
    <!--doctor ,wellness,hospital etc user -->
  @php($uid=Auth::user()->id)
  @if( $data['rolename']->checkRole(['id'=>Auth::user()->role_id]) != 'P.')
  
   @php($myavali=$data['myappoint']->getAvailability($uid))

  <div class="main-content-holder">
  <div class="container">
  <div class="row">
     @if(empty($userMeta))
       
    <!-- data fill success message start-->
    <div class="alert  alert-info profiles" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> 
   
        Fill out your details..
        </div>
    @else
     @if(!empty($data['success']))
    <div class="alert alert-success profiles" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> 
     Updated {{$data['success']}}
    </div>
    @endif
     @endif
    <!-- data fill success message end -->

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fudugo-tab-container">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 fudugo-tab-menu wizard">

        <div class="list-group">
          <a href="#info" data-toggle="tab" role="tab" class="list-group-item {{ app('request')->input('tab') == 'info' ? 'active' : '' }} text-center" title="Basic Profile">
            <h4 class="glyphicon glyphicon-user"></h4>
            <br/>Basic Profile
          </a>
          <a href="#educated" data-toggle="tab" role="tab" class="{{isset($userMeta['user_certification']) ?  : '' }} list-group-item text-center {{ app('request')->input('tab') == 'educated' ? 'active' : '' }}" title="Education">
            <h4 class="glyphicon glyphicon-education"></h4>
            <br/>Education
          </a>
          <a href="#p-detail" data-toggle="tab"role="tab" class=" {{isset($userMeta['user_institute']) ?  : '' }} list-group-item text-center {{ app('request')->input('tab') == 'p-detail' ? 'active' : '' }}" title="Professional Details">
            <h4 class="glyphicon glyphicon-briefcase"></h4>
            <br/>Professional Details
          </a>
          <a href="{{url('/profile')}}/edit?tab=insurance" role="tab" data-toggle="tab" class="{{isset($userMeta['user_hospital_ffiliations']) ?  : '' }} list-group-item text-center {{ app('request')->input('tab') == 'insurance' ? 'active' : '' }}" title="Supported Insurances">
            <h4 class="glyphicon fa fa-info"></h4>
            <br/>Supported Insurances
          </a>
          <a href="#" class="{{isset($userMeta['insurance_provider_plans']) ?  : '' }} list-group-item text-center {{ app('request')->input('tab') == 'avail-shedule' ? 'active' : '' }}" role="tab" data-toggle="tab" title="Availability Schedule">
            <h4 class="glyphicon fa fa-clock-o"></h4>
            <br/>Availability Schedule
          </a>
          <a href="#" class="{{isset($myavali) ?  : '' }} list-group-item text-center {{ app('request')->input('tab') == 'p-exp' ? 'active' : '' }}" role="tab" data-toggle="tab" title="Post Experience">
            <h4 class="glyphicon glyphicon-briefcase"></h4>
            <br/>Past Experience
          </a> 

        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 fudugo-tab">
              <!-- Basic profile start -->
              @include('user.edit-tabs.tab1')
              <!-- Basic profile end -->
             <!-- Education  start -->
              @include('user.edit-tabs.tab2')
              <!-- Education  end -->
             <!-- professional details  start -->
              @include('user.edit-tabs.tab3')
              <!-- professional details   end -->
              <!-- Insurance details  start -->
              @include('user.edit-tabs.tab4')
              <!-- Insurance details   end -->
               <!-- Availability details  start -->
              @include('user.edit-tabs.tab5')
              <!-- Availability details   end -->
             
              <!-- past experience details  start -->
              @include('user.edit-tabs.tab6')
              <!-- Availability details   end -->
      </div>
  </div>
  </div>
  </div>
  </div>
  @else
  <!--other user -->
  <div class="main-content-holder">
  <div class="container">
  <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fudugo-tab-container">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 fudugo-tab-menu wizard">
    <div class="list-group">
      <a href="#" class="list-group-item {{ app('request')->input('tab') == 'info' ? 'active' : '' }} text-center">
        <h4 class="glyphicon glyphicon-user"></h4>
        <br/>Information
      </a>
      <a href="#" class="list-group-item text-center {{ app('request')->input('tab') == 'p-exp' ? 'active' : '' }}">
        <h4 class="glyphicon glyphicon-user"></h4>
        <br/>About Me
      </a>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 fudugo-tab">
      <!-- Basic profile start -->
      @include('user.edit-tabs.other.other-tab1')
      <!-- Basic profile end -->
     
     <!-- Basic profile start -->
      @include('user.edit-tabs.other.other-tab2')
      <!-- Basic profile end -->

  </div>
  </div>
  </div>
  </div>
  </div>    
  @endif  
  @endif
</section>
<style type="text/css">
  .dd-info-list .dropdown-menu.open {
  max-height: 300px !important;
  }
</style>



 
@endsection