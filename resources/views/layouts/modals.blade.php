<span id="top-link-block" class="hidden">
    <a href="#top" class="well well-sm"  onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
        <i class="glyphicon glyphicon-chevron-up"></i>
    </a>
</span>

    <!---------------------Modal Mobile Popup--------------> 
    <div id="myModalsign" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Surf Health</h4>
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
              <div class="login-with" >
                <div class="removesocial" style="display:none">
                <span>OR Sign in using</span>
                <ul class="dd-icon-list" >
                  <li><a class="dd-icon" href="#"><i  class="fa fa-facebook"></i></a></li>
                  <li><a class="dd-icon" href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li><a class="dd-icon" href="#"><i  class="fa fa-linkedin"></i></a></li>
                </ul>
              </div>
                 <a href="{{url('/password/reset')}}" class="clearfix">Forgot Password?</a>
                <a href="{{url('/register')}}" class="clearfix">Create an Account/Sign Up</a>
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
    <!--Remove cover picture-->
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


<!-- Text Modal End -->
<!-- Light Box Modal -->
<div class="modal fade modal-style gallery-modal" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/css/assets/img/close-white.png')}}" aria-hidden="true"></button>
            <div class="modal-body">
                <div class="dd-gallery-carousel">
                    <figure class="dd-gallery-image-holder">
                        <img id="image-gallery-image" src="">
                    </figure>
                    <button type="button" id="show-previous-image" class="dd-control left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button type="button" id="show-next-image" class="dd-control right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>



