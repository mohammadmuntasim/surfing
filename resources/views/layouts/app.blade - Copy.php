<!DOCTYPE html>
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
    <!-- Scripts -->
    <script>
      window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        ]); ?>
    </script>
  </head>
  <body>
    @if(Route::current()->getName() == 'register')
    @if (Auth::guest())               
    <!--  <section class="dd-bg-carousel">
      <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
          <div class="carousel-inner">
              {{$i = 1 }}
              @foreach($sliders as $s)
                  <div class=" {{$i == 1 ? 'active' : ''}} item" style="background:url({{asset('/storage/')}}/{{$s->image}}) no-repeat center center fixed"></div>
                  {{$i++}}
              @endforeach                    
          </div>
      </div>
      </section> -->
    @endif
    @endif
    <!-- Header Start -->
    <header class="dd-header navbar-fixed-top desktop-head">
      <div class="container">
      <div class="row">
        @if(Request::is('/')) 
        <div class="col-md-2 pl">
          @else
          <div class="col-md-3 pl">
            @endif
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
              <img src="{{url('/')}}/storage/{{Voyager::setting('logo')}}" alt="Surf Health Logo"></a>
            </figure>
          </div>
          @if(Request::is('/')) 
          <div class="col-md-10 homepage pr @if (Auth::guest()) login-head @endif">
            @else
            <div class="col-md-9 pr @if (Auth::guest()) login-head @endif">
              @endif
              @if (Auth::guest())
              <div class="dd-login">
                <form  role="form" method="POST" action="{{ url('/login') }}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif 
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
              <div class="dd-social-login">
                <span>OR </span>
                <ul class="dd-icon-list pull-left">
                  <li>
                    <a class="dd-icon" href="#"><i  class="fa fa-facebook-square"></i></a>
                    <script>
                      window.fbAsyncInit = function() {
                        FB.init({
                          appId      : '695225547324647',
                          cookie     : true,
                          xfbml      : true,
                          version    : 'v2.8'
                        });
                        FB.AppEvents.logPageView();   
                      };
                      
                      (function(d, s, id){
                         var js, fjs = d.getElementsByTagName(s)[0];
                         if (d.getElementById(id)) {return;}
                         js = d.createElement(s); js.id = id;
                         js.src = "//connect.facebook.net/en_US/sdk.js";
                         fjs.parentNode.insertBefore(js, fjs);
                       }(document, 'script', 'facebook-jssdk'));
                    </script>
                  </li>
                  <li><a class="dd-icon" href="#"><i class="fa fa-google-plus-square"></i></a></li>
                  <li><a class="dd-icon" href="#"><i  class="fa fa-linkedin-square"></i></a></li>
                </ul>
              </div>
              <div><a href="{{url('/')}}/password/reset" class="forgotpasss">Forgot Password?</a></div>
              @else
              <div class="dd-user-point">
                <!-- Split button -->
                <div class="btn-group dd-dropdown dd-notification">
                  <a href="{{ url('/home') }}" type="button" class="btn btn-info"><i class="fa fa-home" aria-hidden="true"></i></a>   
                  <a href="{{ url('/connections') }}" type="button" class="btn btn-info"><i class="fa fa-users" aria-hidden="true"></i></a> 
                  <a href="{{ url('/') }}" type="button" class="btn btn-info"><i class="fa fa-envelope" aria-hidden="true"></i></a>  
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-bell" aria-hidden="true"></i></button>
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
                    <li><a href="#.">Settings</a></li>
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
              <div class="dd-search-bar searchtabs">
                <form class="navbar-form navbar-search" role="search" method="GET" action="{{ url('/search') }}">
                  {{ csrf_field() }}
                  @include('pages.searchform')
                </form>
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
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-bell" aria-hidden="true"></i></button>
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
    <li><a href="#.">Settings</a></li>
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
    <footer class="dd-footer">
      <div class="container">
        <div class="row">
          <div class="dd-footer-nav">
            {{menu('Footer Menu')}}
          </div>
        </div>
      </div>
    </footer>
    <!---------------------Modal Mobile Popup--------------> 
    <div id="myModalsign" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sign In</h4>
          </div>
          <div class="modal-body">
            @if (Auth::guest())
            <div class="popup-sign">
              <form  role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="form-group">
                  <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                  <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif    
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
                  <button type="submit" class="dd-default Submitbtn">Submit</button>
                </div>
              </form>
              <div class="login-with">
                <span>OR Sign in using</span>
                <ul class="dd-icon-list">
                  <li><a class="dd-icon" href="#"><i  class="fa fa-facebook"></i></a></li>
                  <li><a class="dd-icon" href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li><a class="dd-icon" href="#"><i  class="fa fa-linkedin"></i></a></li>
                </ul>
              </div>
            </div>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    @if(Auth::check())
    <div id="myModalpeople" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Search </h4>
          </div>
          <div class="modal-body">
            <div class="dd-search-bar">
              <form class="navbar-form navbar-search" role="search" method="POST" action="{{ url('/search') }}">
                {{ csrf_field() }}
                @include('pages.searchform-mobile')
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!-- Remove cover picture-->
    <div id="confirm" class="modal fade confirms">
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <form action="{{url('/profile')}}" method="POST">
          {{ csrf_field() }}
          <button type="submit"  class="btn btn-primary" id="delete">Delete</button>
          <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </form>
      </div>
    </div>
    <!-- Don't upload profile picture-->
    <div id="cancelprofilepoup" class="modal fade confirms">
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <form action="{{url('/profile')}}" method="POST">
          {{ csrf_field() }}
          <button type="submit"  class="btn btn-primary" id="delete">Yes</button>
          <button type="button" data-dismiss="modal" class="btn">No</button>
        </form>
      </div>
    </div>
    <!-- Show any text message to this popup -->
    <div class="modal fade confirms" id="overlay">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <p>Context here</p>
          </div>
        </div>
      </div>
    </div>
    <!--post share popup-->
    <div id="sharewithcontent" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Share on timeline</h4>
          </div>
          <div class="modal-body" id="sharewithcontentform" >
            <center> <img src="{{url('/')}}/css/assets/img/ring.gif" ></center>
          </div>
        </div>
      </div>
    </div>
    <!-- Refer Modal Start -->
    <div class="modal fade refer-modal modal-style in" id="refer-id" tabindex="-1" role="dialog" aria-labelledby="Refer">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{url('/')}}/css/assets/img/close.png" aria-hidden="true"></button>
            <h4 class="modal-title" id="ReferTitle">Refer Dr. Iva Ruth to</h4>
            <div class="dd-refer-search">
              <div class="input-group">
                <input type="text" class="form-control" name="refers" placeholder="Search by Name" id="searchnametorefer" onkeypress="refername()" onkeydown="refername()">                        
                <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="refername()">Go!</button>
                </span>
              </div>
              <!-- /input-group -->
            </div>
          </div>
          <div class="modal-body">
            <div class="dd-grid-2-column">
              <center> <img src="{{url('/')}}/css/assets/img/ring.gif" ></center>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Refer Modal End -->
    <!-- Text Modal Start -->
    <div class="modal fade text-modal modal-style in" id="your-refer-id" tabindex="-1" role="dialog" aria-labelledby="Refer">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{url('/')}}/css/assets/img/close.png" aria-hidden="true"></button>
          </div>
          <div class="modal-body">
            <div class="dd-text-modal">
              <h1>You Are  Refer Dr. Iva Ruth</h1>
              <!-- <ul>
                <li><a href="#.">Fix Appointment</a></li>
                   <li>or</li>
                   <li><a href="#." data-dismiss="modal">Ignore</a></li>
                </ul> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Text Modal End -->
    <!-- Modal Mobile Popup -->   
    <!-- Footer End -->
    <!-- Scripts -->           
    <!-- <script type="text/javascript" src="{{asset('/css/assets/js/jquery.min.js')}}"></script>-->
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/animations.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/bootstrap-select.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/dncalendar.min.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWxSwqOvmw8hT9r-nYlhRBOsqOI49069g&sensor=false"></script>
    <script src="{{asset('js/map.js')}}"></script>
    <script src="{{asset('js/ajax-crud.js')}}"></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/dd-panel.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/validation-ajax.js')}}"></script>
    <script type="text/javascript" src="{{asset('/css/assets/js/wickedpicker.min.js')}}"></script>
    <script>
      var page = 1; //track user scroll as page number, right now page number is 1
      load_more(page); //initial content load
      $(window).scroll(function() { //detect page scroll
          if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
              page++; //page number increment
              load_more(page); //load content   
          }
      });     
      function load_more(page){
        $.ajax(
              {
                  url: '?page=' + page,
                  type: "get",
                  datatype: "html",
                  beforeSend: function()
                  {
                      $('.ajax-loading').show();
                  }
              })
              .done(function(data)
              {
                  if(data.length == 0){
                  console.log(data.length);
                     
                      //notify user if nothing to load
                      $('.ajax-loading').html("No more records!");
                      return;
                  }
                  $('.ajax-loading').hide(); //hide loading animation once data is received
                  $("#results").append(data); //append data into #results element          
              })
              .fail(function(jqXHR, ajaxOptions, thrownError)
              {
                    alert('No response from server');
              });
       }
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
      $("#dialog").dialog({
        autoOpen: false,
        modal: true
      });
      });
      
      $("#canceldoc #mybutton").click(function(e) {
      e.preventDefault();
      
      
      $("#dialog").dialog({
        buttons : {
          "Confirm" : function() {
             $(this).dialog("close");
            $( "#canceldoc" ).submit();
          },
          "Cancel" : function() {
            $(this).dialog("close");
          }
        }
      });
      
      $("#dialog").dialog("open");
      });
      
    </script>
    <script type="text/javascript">
      $('.timepicker').wickedpicker();
      $('#removecover').on('click', function(e) {
      var $form = $(this).closest('form');
      e.preventDefault();
      $('#confirm').modal({
          backdrop: 'static',
          keyboard: false
        })
        .one('click', '#delete', function(e) {
          $form.trigger('submit');
        });
      });
    </script>
    <script type="text/javascript">
      $('#cancelprofile').on('click', function(e) {
        var $form = $(this).closest('form');
        e.preventDefault();
        $('#cancelprofilepoup').modal({
            backdrop: 'static',
            keyboard: false
          })
          .one('click', '#delete', function(e) {
            $form.trigger('submit');
          });
      });
    </script>
    <script language="javascript">
      $(function(){    
      	$(".input-group-btn .dropdown-menu li a").click(function(){	
      		var selText = $(this).html();		
      		//working version - for single button //
      	   //$('.btn:first-child').html(selText+'<span class="caret"></span>');  
      	   
      	   //working version - for multiple buttons //
      	   $(this).parents('.input-group-btn').find('.btn-search').html(selText);
      
         });
      
      });
    </script>
    <script language="javascript">
      $("#file-1").fileinput({
          uploadUrl: '#', // you must set a valid URL here else you will get an error
          allowedFileExtensions: ['jpg', 'png', 'gif'],
          overwriteInitial: false,
          maxFileSize: 1000,
          maxFilesNum: 10,
          //allowedFileTypes: ['image', 'video', 'flash'],
          slugCallback: function (filename) {
              return filename.replace('(', '_').replace(']', '_');
          }
      });
    </script>
    <script language="javascript">
      $(document).ready(function(){
      
         loadGallery(true, 'a.dd-light-box');
      
         //This function disables buttons when needed
         function disableButtons(counter_max, counter_current){
             $('#show-previous-image, #show-next-image').show();
             if(counter_max == counter_current){
                 $('#show-next-image').hide();
             } else if (counter_current == 1){
                 $('#show-previous-image').hide();
             }
         }
      
         /**
          *
          * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
          * @param setClickAttr  Sets the attribute for the click handler.
          */
      
         function loadGallery(setIDs, setClickAttr){
             var current_image,
                 selector,
                 counter = 0;
      
             $('#show-next-image, #show-previous-image').click(function(){
                 if($(this).attr('id') == 'show-previous-image'){
                     current_image--;
                 } else {
                     current_image++;
                 }
      
                 selector = $('[data-image-id="' + current_image + '"]');
                 updateGallery(selector);
             });
      
             function updateGallery(selector) {
                 var $sel = selector;
                 current_image = $sel.data('image-id');
                 $('#image-gallery-caption').text($sel.data('caption'));
                 $('#image-gallery-title').text($sel.data('title'));
                 $('#image-gallery-image').attr('src', $sel.data('image'));
                 disableButtons(counter, $sel.data('image-id'));
             }
      
             if(setIDs == true){
                 $('[data-image-id]').each(function(){
                     counter++;
                     $(this).attr('data-image-id',counter);
                 });
             }
             $(setClickAttr).on('click',function(){
                 updateGallery($(this));
             });
         }
      });
    </script>
    <!-- Autocomplete name -->
    <script type="text/javascript">
      function refername(){
         
           var refers=$('#searchnametorefer').val();
          // console.log(refers.length);
           if(refers.length>2){
             $.get('/searchconnectname/?refers='+refers,function(data){               
                 $('#refer-id  .dd-grid-2-column').html(data);
              });
            }else if(refers==''){
              $.get('/connectionlist',function(data){               
                $('#refer-id  .dd-grid-2-column').html(data);
              });
            }
      }
    </script>
    <script type="text/javascript">
      $('#namekeysearch').autocomplete({
        source : '{!!URL::route('autocomplete')!!}',
        minlenght:1,
        autoFocus:true,
        select:function(e,ui){
          //alert(ui);
        }
      });
    </script>
    <script type="text/javascript">
      $('#namekeysearchpage').autocomplete({
        source : '{!!URL::route('autocomplete')!!}',
        minlenght:1,
        autoFocus:true,
        select:function(e,ui){
          //alert(ui);
        }
      });
    </script>
  </body>
</html>