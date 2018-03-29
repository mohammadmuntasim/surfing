@extends('layouts.app')

@section('content')
<section class="dd-content-holder">
    <div class="container">
        <div class="row">
            <div class="col-md-3 pl">
                <div class="dd-user-short dd-fixed fw dd-card float-panel">
                    <div class="dd-user-holder">
                        <div class="dd-img-holder">
                            <figure class="dd-avater-holder">
                                <a href="#">
                                    <img src="{{url('/')}}{{ isset(Auth::user()->avatar) ?  Auth::user()->avatar : '/css/assets/img/profile-image.jpg' }}" alt="Image"  alt="Profile Pic {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}">
                               <!--  <img src="{{isset($data['profile-pic']) ? $data['profile-pic'] : '/css/assets/img/profile-image.jpg'}}" alt="Profile Pic {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}"> -->
                                </a>
                            </figure>
                        </div>
                        <div class="dd-detail-holder">
                            <h4><a href="{{url('/profile')}}"> {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}</a></h4>
                            <p>{{isset($data['specialist']) ? $data['specialist'].',' : ''}}  {{isset($data['hospital']) ? $data['hospital'] : ''}}</p>
                        </div>
                    </div>
                    <div class="dd-shortcut-holder fw myexplorelist">
                        <ul>
                            <li><a class="dd-news" href="{{url('/home')}}">Healthcare News</a></li>
                            <li><a class="dd-message" href="{{url('/messages')}}">My Messages</a></li>
                        </ul>
                    </div>
                    <div class="dd-shortcut-nav-holder fw myexplorelist">
                        <h5>EXPLORE</h5>
                        <ul class="dd-caret-list">
                            <li><a href="{{url('/profile')}}"><i class="fa fa-newspaper-o" aria-hidden="true"></i> {{Auth::user()->name}} </a></li>
                             @if(Auth::user()->role_id !=1 || Auth::user()->role_id !=3 || Auth::user()->role_id !=8 )
                            <li>
                                
                                <a href="{{url('/allreviews')}}"><i class="fa fa-star" aria-hidden="true"></i> Reviews</a>

                            </li>
                            @endif
                            <li><a href="{{url('/appointments')}}"><i class="fa fa-calendar" aria-hidden="true"></i> My Appointments</a></li>
                             <li style="display:none"><a href="{{url('/booking')}}"><i class="fa fa-book" aria-hidden="true"></i> Booked Appointments</a></li>
                            <li><a href="{{url('/connections')}}"><i class="fa fa-users" aria-hidden="true"></i> My Connections</a></li>
                            <!-- <li><a href="{{url('/following')}}"><i class="fa fa-check-square-o" aria-hidden="true"></i> Following</a></li>
                            <li><a href="{{url('/following')}}"><i class="fa fa-check-square" aria-hidden="true"></i> Followers</a></li> -->
                            <li><a href="{{url('/photos')}}"><i class="fa fa-picture-o" aria-hidden="true"></i> Photos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-pr dd-scroll-content">
                <div class="dd-timeline-posts-holder fw">
                    <!--start post form -->
                    @include('user.timeline.postForm')
                   
                    <!-- end post form -->
                    <div class="dd-post-holder fw">
                        @if(!empty($postblog['timeline_post']))
                       <div class="dd-post-holder fw" id="results">
                                     
                       
                    </div>
                     <div class="ajax-loading"><img src="{{ asset('css/assets/img/loadmore.gif') }}" /></div>
                     @else
                     
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 pr">
                <div class="dd-advertise-holder dd-fixed float-panel">
                     @include('user/sidebar')
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
