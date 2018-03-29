@extends('layouts.app')

@section('content')
<!-- Content Start -->
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
                    <div class="dd-timeline-posts-holder fw">
                        
                        <div class="dd-content-inner fw dd-card">
                        	<div class="dd-common-inner-title">
                            	<h3>Followers ({{$data['userfollow']->CountFollowing(['follower_user_id'=>Auth::user()->id])}})</h3>
                            </div>
                        	<div class="dd-grid-2-column dd-grid-style-two">
                                @if(!empty($data['userfollowers']))
                                @foreach($data['userfollowers'] as $followersid)
                                 @php($userinfo=$data['userdatabyid']->getUserData(['id'=>$followersid->follow_user_id]))
                                  @foreach($userinfo as $userdata)
                                <div class="col-md-6">
                                    <div class="dd-grid-item">
                                        <figure class="dd-grid-avater">
                                            <img src="{{ isset($userdata->avatar) ?  $userdata->avatar : '/css/assets/img/profile-image.jpg' }}" alt="{{ isset($userdata->name) ?  $userdata->name : 'Surf Health Avatar' }}">
                                        </figure>
                                        <div class="dd-grid-content align-middle">

                                            <h4>{{ isset($userdata->name) ?  $userdata->name : '' }}</h4>
                                            <span>{{$data['userfollow']->CountFollowing(['follower_user_id'=>$userdata->id])}} followers</span>

                                            <a class="btn btn-default" href="javascript:void(0);" onclick="followusers(this)" data-followuser="{{$userdata->id}}" >
                                                @if($userdata->follow_user_id==Auth::user()->id) Following @else Follow 
                                                @endif</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-md-3 pl-pr dd-scroll-contents text-center">
                    @include('user.sidebar')
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Content End -->
@endsection
