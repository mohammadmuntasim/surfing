@extends('layouts.app')
@section('content')
<section class="landingslider landingpage">
	
	<!-- Carousel
		================================================== -->
	@if(Request::is('/')) 
	<div id="mywelcomeCarousel" class="carousel slide" >
		<!-- Indicators -->
		<!-- <ol class="carousel-indicators">
			<li data-target="#mywelcomeCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#mywelcomeCarousel" data-slide-to="1"></li>
			<li data-target="#mywelcomeCarousel" data-slide-to="2"></li>
			</ol> -->
		<div class="carousel-inner">
 @if(Auth::guest())
        <div class="col-md-3 pl showsapp">
            <figure class="dd-logos">
              
              <a href="{{ url('/') }}">
              
              <img src="{{url('/')}}/storage/{{Voyager::setting('logo')}}" alt="Surf Health Logo" class="onHoverHeartbeat"></a>
            </figure>
          </div>
          @endif
			@php($i = 1 )
			@foreach($sliders as $sliders)
			<div class="item {{$i == 1 ? 'active' : ''}} ">
				<img src="{{asset('/storage/')}}/{{$sliders->image}}" class="img-responsive">

				<div class="container">
					<div class="carousel-caption">
						<h1 class="animate" data-anim-type="fadeInDown" data-anim-delay="400">Health Connections</h1>
						<h2>
							@if($i==2)
							Navigate Your Way To Better Wellness Services
							@elseif ($i==3)
							Healthcare Services All In One Place
							@else
							Your Health Deserves Better Providers
							@endif 
						</h2>
					</div>
				</div>
			</div>
			@php($i++)
			@endforeach
		</div>
	</div>
	<!-- /.carousel -->
	<div class="overlay">
		<div class="s-overlay-inner">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="transparentsbg animate" data-anim-type="fadeInUp" data-anim-delay="400">
						@include('pages.searchform',['url'=>'search','link'=>'search'])                          
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="featureddoctors animate" data-anim-type="fadeInUp" data-anim-delay="400">
	<div class="container">
		<div class="row">
			<div class="find_someone_head animate" data-anim-type="fadeInDown" data-anim-delay="400">Our Featured Providers / Services</div>
			@if(sizeof($myusersdata)>0)
			<div id="myDoctors" class="carousel slide">
				<!-- Carousel items -->
				<div class="carousel-inner animate" data-anim-type="fadeInUp" data-anim-delay="400">
					@foreach($myusersdata as  $key => $myusersdatad)
					@if ($key === 0 || $key%3 ==0)                      
					<div   @if ($key === 0) class="item active" @else class="item " @endif  >
					@endif
					@php ($uids = $myusersdatad->id )
					<?php $urlnames = str_replace(' ', '-',$myusersdatad->name); ?>
					<div class="col-md-4 col-sm-6 col-xs-12 ">
						<a  href="{{url('/search')}}/{{ $myusersdatad->id }}/{{ $urlnames }}">
							<div class="whitebg">
								<div class="col-md-5">
									<?php $cv=explode('/', $myusersdatad->avatar);
									if($cv[0]=='users'){
										$paths='/storage/';
									}else{
									$paths='';
							 	    }
									?>
									<img src="{{$paths}}{{ isset($myusersdatad->avatar) ?  $myusersdatad->avatar : '/css/assets/img/dummy-photo-03.jpg' }}" alt="Image" calt="Image" class="img-responsive">
								</div>
								<div class="col-md-7">
									<h5>
										<!-- display role name -->
										  {{ isset($myusersdatad->name) ?  $myusersdatad->name : '' }}
									</h5>
									@php($metadata=$data['userMetaInformation']->getUserMeta(['user_id'=>$myusersdatad->id]))
									@foreach($metadata as $metadatavalue)
									
									@if($metadatavalue->user_meta_key=='user_specialties') 
									<h6><span> Specialties: </span>{{$metadatavalue->user_meta_value}} </h6>
									@endif
									
									
									@if($metadatavalue->user_meta_key=='user_number')
									<h6><span> Phone:</span>  {{$metadatavalue->user_meta_value}}  </h6>
									@endif
									                         
									@endforeach
									<h6>
										<div class="dd-rating-star pull-left">
											@if($data['getreviews']->countReviews(['user_id'=>$myusersdatad->id])==0)
											<ul>
												<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
												<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
												<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
												<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
												<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											</ul>
											@else
											<?php   $rew=0; $ir=0;  ?>
											@php($data['reviewss']=$data['getreviews']->getReviews(['user_id'=>$myusersdatad->id]))
											<ul>
												@foreach($data['reviewss'] as $allreviews1)
												<?php 
													$rew=$rew+$allreviews1->overall; 
													$rew=$rew+$allreviews1->punctuality;
													$rew=$rew+$allreviews1->knowledge;
													$rew=$rew+$allreviews1->staff;
													$ir++;
													?>
												@endforeach
												<?php 
													$numberofcount=$ir*20;
													
													$trtr=$rew/$numberofcount;
													$trt=$trtr*5;
													?>
												@for ($i = 0; $i < 5; $i++) 
												@if($i<(int)$trt)
												<li><i class="fa fa-star" aria-hidden="true"></i></li>
												@elseif($i<$trt)
												<li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
												@else
												<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
												@endif
												@endfor
											</ul>
											@endif
										</div>
									</h6>
								</div>
							</div>
						</a>
					</div>
					@if ( $key%3 == 2) 
				</div>
				@endif
				<!--/item-->
				@endforeach
			</div>
			<!-- carousel-inner--> 

			<a class="left carousel-control" href="#myDoctors" data-slide="prev"><i class="fa fa-angle-left fa-4"></i></a>
			<a class="right carousel-control" href="#myDoctors" data-slide="next"><i class="fa fa-angle-right fa-4"></i></a>
			@else
			 <div class="text-center"><h3>coming soon...</h3></div>
			@endif
		</div>
	</div>
	</div>
</section>

<section class="sections find-care-section bg-white animate" data-anim-type="fadeInUp" data-anim-delay="400">
	<?php //print_r($relatedPosts); ?>
	<div class="container">
		<div class=" margin_60">
			<h2 class="sections-title find_someone_head animate" data-anim-type="fadeInUp" data-anim-delay="400">Easy Way to Find Care</h2>
			<h3 class="sections-sub-titles find_someone_head animate" data-anim-type="fadeInUp" data-anim-delay="400">Connect to Medical Professionals, Wellness, Health Care, and Elder Care Services in Your Area</h3>
		</div>
		<div class="row">
			@foreach($relatedPosts as $posthomecat)
			<div class="col-md-4 col-sm-4 col-xs-12 text-center custom-col animate" data-anim-type="zoomInLeft" data-anim-delay="400">
				<div class="custom-circles onHoverHeartbeat"><img src="{{url('/')}}/storage/{{ $posthomecat->image}}"></div>
				<h2><a href="#">{!! $posthomecat->title !!}</a></h2>
				<p>{!! $posthomecat->body !!} </p>
			</div>
			@endforeach 
		</div>
		<h2 class="sections-title find_someone_head animate" data-anim-type="fadeInUp" data-anim-delay="400">Learn Why Today’s Families Choose Surf Health to Find<br> Providers and Services</h2>
		<br>
		<div class="row">
			<div class="col-sm-6 col-md-6 hm-learn-why-col">
				<div class="custom-circless medium col-md-3 col-sm-3"><img src="{{url('/')}}/img/trusted-professional.png"></div>
				<div class="hm-learn-why-content col-md-9 col-sm-9">
					<h3>Trusted Professionals</h3>
					<p>Surf Health thoroughly screens and checks all medical professionals before adding them to our portal.</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-6 hm-learn-why-col">
				<div class="custom-circless medium col-md-3 col-sm-3"><img src="{{url('/')}}/img/experiecne.png"></div>
				<div class="hm-learn-why-content col-md-9 col-sm-9">
					<h3>One Stop Health and Wellness Portal </h3>
					<p>Surf Health brings you comprehensive listings for doctors, adjunct medical specialties, elder care services, and wellness providers.</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-6 hm-learn-why-col">
				<div class="custom-circless medium col-md-3 col-sm-3"><img src="{{url('/')}}/img/need-one-place.png"></div>
				<div class="hm-learn-why-content col-md-9 col-sm-9">
					<h3>Experience </h3>
					<p>Find doctors, health care providers, elder care, and other wellness services that have the experience you need.</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-6 hm-learn-why-col ">
				<div class="custom-circless medium col-md-3 col-sm-3"><img src="{{url('/')}}/img/satisfaction.png"></div>
				<div class="hm-learn-why-content col-md-9 col-sm-9">
					<h3>Satisfaction</h3>
					<p>Surf Health provides you with support 24/7 to help you find the services you need – when you need them. </p>
				</div>
			</div>
		</div>
	</div>
</section>
@endif

<section id="get_started" class="pink_heading_bg margin_0 fix  animate" data-anim-type="fadeInUp" data-anim-delay="400">
	<div class="container">
		<div class="col-sm-10 your_story_waiting">
			Connecting you to Doctors, Dentist, Wellness and Healthcare services in your area
		</div>
		<div class="hm_btn_container col-sm-2">
			<a href="{{url('/register')}}" id="sign_up_btn" class="sign_up_btn waves-effect touch-feedback" onclick="return show_layer('registration', this);" type="registration">
			Get Started
			</a>
		</div>
	</div>
</section>
@endsection