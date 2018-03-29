<!--
 /*!
 * Design and develop by RIZWANA ANSARI ( rizwanawork786@gmail.com ) at FUDUGO SOLUTIONS PVT. LTD. 
 *
 * Copyright 2017 www.fudugo.com
 * Licensed Authorize by fudugosolutions@2017
 */ 
-->

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/css/assets/img/favicon.ico"/>
    <title>{{ Voyager::setting('title') }}</title>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <!-- Scripts -->
    <script>
      window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style type="text/css">
.dd-scroll-content .file-drop-zone {
    height: auto;
}
#senderrequest .btn-group {
    margin-top: -36px;
}
.dd-user-point .btn-group .btn.btn-primary {
    font-size: 13px;
    color: #F99104;    border: 1px solid;
    padding: 2px 10px;
}
.dd-user-point .btn-group .btn.btn-primary.blues{
  color: #3d88ed;
}
    </style>
  </head>
@if(Auth::check())
 @if(Request::url()== url('/home'))
 <body class="homepage01" id="homepage01">
@else
  <body class="{{ $bodyClass or "default" }}">
@endif
@else
<body class="{{ $bodyClass or "landingouter" }}">
@endif
<?php date_default_timezone_set('Asia/Kolkata'); ?>
    <header class="dd-header navbar-fixed-top desktop-head">
      <div class="container">
      <div class="row">
  @if(Request::url() != url('/'))
        <div class="col-md-2 pl">
          
            @if(Auth::guest())
            <figure class="dd-logo">
            @else
            <figure class="dd-logo dashborards">
              @endif 
              @if (Auth::check())
              <a href="{{ url('/home')}}">
              @else
              <a href="{{ url('/') }}">
              @endif
              <img src="{{url('/')}}/storage/{{Voyager::setting('logo')}}" alt="Surf Health Logo" class="onHoverHeartbeat"></a>
            </figure>
          </div>
          @endif

          <div class="  @if(Request::url() == url('/')) col-md-offset-2 @endif col-md-10 homepage pr @if (Auth::guest()) login-head @endif">

              @if (Auth::guest())
              <div class="dd-login">
                <form  role="form" method="POST"  id="mainlogin"  action="{{ url('/login') }}">
                  {{ csrf_field() }}
                  <input id="showerror" type="hidden" class="form-control" name="showerror"  value="0">
                  <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    <div id="login-email-error">
                      
                      @if ($errors->has('email'))
                      <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                      </span>
                      @endif 
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif 
                    
                  </div>
                  <div class="form-group">
                    <button type="submit" class="dd-default Submitbtn">Login</button>
                  </div>
                </form>
                @if(Request::url() != url('/register'))
                <div class="form-group">
                  <a href="/register"><button type="submit" class="dd-default-signup Submitbtn">Sign Up</button></a>
                </div>
                @endif
              </div>
              <div class="dd-social-login" style="display:none">
                <span>OR </span>
                <ul class="dd-icon-list pull-left">
                  <li>

                    <a class="dd-icon" href="#"><i  class="fa fa-facebook-square"></i></a>
                    
                  </li>
                  <li><a class="dd-icon" href="#"><i class="fa fa-google-plus-square"></i></a></li>
                  <li><a class="dd-icon" href="#"><i  class="fa fa-linkedin-square"></i></a></li>
                </ul>
              </div>
              <div><a href="{{url('/')}}/password/reset" class="forgotpasss">Forgot Password?</a></div>
              @else
              <div class="dd-user-point">
                <!-- Split button -->
                <div class="btn-group dd-dropdown dd-notification" id="here">
                  <a href="{{ url('/home') }}" type="button" class="btn btn-info pink"  ><i class="fa fa-home" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Home"></i></a> 

                  <div class="dropdown keep-open">
                      <a href="javascript:void(0);" type="button" data-toggle="collapse" data-target="#demo" class=" btn btn-info pink"  @if(count($data['showNotificationConnection'])>0) data-bubble="{{count($data['showNotificationConnection'])}}" @endif id="connections"><i class="fa fa-users" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Connections"></i></a> 
                        <ul class="dropdown-menu dd-notification-list collapse connections" role="menu" id="demo" aria-labelledby="connections" >
                          no connection
                          
                        </ul>
                  </div>
                  <div class="dropdown ">
                      <a href="javascript:void(0);" type="button"  class="btn btn-info" id="messages"><i class="fa fa-envelope" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Messages"></i></a> 
                          <ul class="dropdown-menu dd-notification-list" role="menu" aria-labelledby="messages" >
                              <span class="dd-notification-title"> Notifications</span>
                                   @if(count($data['showNotificationConnection'])>0)
                                   @foreach($data['showNotificationConnection'] as $notifys)
                                    <li class="dd-note-list">
                                      <span>49 minutes ago</span>
                                    </li>
                                    @endforeach
                                    @else
                                  No notifications founds
                                    @endif
                          </ul>
                  </div>
                   <div class="dropdown">
                      <a href="javascript:void(0);" type="button" data-toggle="dropdown" class=" btn btn-info pink"  @if(count($data['showNotification'])>0) data-bubble="{{count($data['showNotification'])}}" @endif id="allnotifications"><i class="fa fa-bell" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Notification"></i></a> 
                  
                  <ul class="dropdown-menu dd-notification-list allnotifications" aria-labelledby="allnotifications">
                    <span class="dd-notification-title">Notifications</span>
                          @if(count($data['showNotification'])>0)
                           
                            @else
                            No notifications founds
                            @endif
                  </ul>
                  </div>
                </div>

                 <figure class="mini-profile-block">
                  <a href="/profile">
                    <img class="mini-profile" src="{{ isset(Auth::user()->avatar) ?  Auth::user()->avatar : '/css/assets/img/profile-image.jpg' }}" alt="Profile Pic {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}">
                     
                            <?php

                             $results = array();
                             $myname='';
                             $name= Auth::user()->name;
                             $brname=explode(' ', $name);
                             if($brname[0]=='Dr.'){
                              $myname=$brname[0].' '.$brname[1];
                              
                             }else{
                              $myname=$brname[0];
                             }
                             
                         ?>

                         <span> {{$myname}}</span>
                   </a>
                   <div class="btn-group dd-dropdown">
                  <!--<a href="{{ url('/profile') }}" type="button" class="btn btn-info"><i class="fa fa-user-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Profile"></i></a>-->
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                  <span class="caret" ></span>
                  <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                    <!-- <li><a href="#.">Settings</a></li> -->
                    <li><a href="{{ URL::route('account-sign-out') }}">Sign Out</a></li>
                    
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ url('/contactus') }}" >Report a Problem</a></li>
                  </ul>
                </div>
                </figure>
               
                
              </div>
              <div class="dd-search-bar searchtabs">
               <!--  <form class="navbar-form navbar-search" role="search" method="GET" action="{{ url('/search') }}"> -->
                  {{ csrf_field() }}
                  @include('pages.searchform')
                <!-- </form> -->
              </div>
              @endif
            </div>
          </div>
        </div>
    </header>
    <header class="dd-header navbar-fixed-top mobile-head">
    <div class="container">
    <div class="row">
    <div class="sh-logo">
    <figure class="dd-logo">
    <a href="{{url('/')}}">
    <img src="{{url('/')}}/storage/{{Voyager::setting('logo')}}" alt="Surf Health Logo"></a>
    </figure>
    </div>
    @if (Auth::guest())
    <div class="sh-right">
    <ul>
    <li> <a href="{{url('/')}}/password/reset">Forgot Password?</a></li>
    <li><a data-toggle="modal" data-target="#myModalsign" href="#">Sign In</a></li>
    @if(Request::is('/')) 
    <li><a href="{{url('/register')}}">Create Account</a></li>  
    @endif
    </ul>
    </div>
    @else
    <div class="dd-user-point">
    <!-- Split button -->
    <div class="btn-group dd-dropdown dd-notification">
    <a href="{{ url('/home') }}" type="button" class="btn btn-info"><i class="fa fa-home" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Home"></i></a> 
    <a href="{{ url('/connections') }}" type="button" class="btn btn-info"><i class="fa fa-users" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Connections"></i></a> 
    <a href="{{ url('/') }}" type="button" class="btn btn-info"><i class="fa fa-envelope" aria-hidden="true"  data-toggle="tooltip" data-placement="bottom" title="Messages"></i></a> 
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-bell" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Notification"></i></button>
    <ul class="dropdown-menu dd-notification-list">
    <span class="dd-notification-title">Notifications</span>
    <li class="dd-note-list">
    <figure class="dd-note-avater">
    <img src="{{url('/')}}/css/assets/img/default-avater.png" alt="">
    </figure>
    <div class="dd-note-content">
    <a href="#.">David Wolf</a> has referred you to <a href="#.">Rose Mary</a>
    <span>49 minutes ago</span>
    </div>
    </li>
    <li class="dd-note-list">
    <figure class="dd-note-avater">
    <img src="{{url('/')}}/css/assets/img/default-avater.png" alt="">
    </figure>
    <div class="dd-note-content">
    <a href="#.">David Wolf</a> has referred you to <a href="#.">Rose Mary</a>
    <span>49 minutes ago</span>
    </div>
    </li>
    </ul>
    </div>
    <div class="btn-group dd-dropdown">
    <a href="{{ url('/profile') }}" type="button" class="btn btn-info"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
   <!--  <li><a href="#.">Settings</a></li> -->
    <li>
    <a href="{{ url('/logout') }}"
      onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
    Sign Out
    </a>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    </form>
    </li>                                    
    <li role="separator" class="divider"></li>                          
    <li><a href="#.">Report a Problem</a></li>
    </ul>
    </div>
    </div>
    <div class="people-search">
    <a href="#" data-toggle="modal" data-target="#myModalpeople" href="#"><i class="fa fa-search" aria-hidden="true"></i>
    </a>
    </div>
    @endif
    </div>
    </div>
    </header>
    <!-- Header End -->
    <div id="app" @if(Auth::check()) class="margin-top-50" @endif>
    @yield('content')
    </div>
    <!-- Footer Start -->
    @include('layouts.footer')

    <!-- Footer End -->
    <!-- Scripts -->           
   