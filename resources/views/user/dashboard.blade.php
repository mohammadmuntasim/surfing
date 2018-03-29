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
	@if(Auth::check())
	@php($uid=Auth::user()->id)
	@php($data['userid']==Auth::user()->id)

	@if( $data['rolename']->checkRole(['id'=>Auth::user()->role_id]) != 'P.')
	
	<div class="main-content-holder">
		<div class="container">
			<div class="row">
				<div class="col-md-6 pl">
					<div class="dd-info-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Profile Summary</h3>
							@php($datstts=$data['userMetaObj']->getUserMeta(['user_id'=>$uid]))
							<?php $userMeta = $data['userAllMetaData'];
							//specialities
							$val=$data['userMetaObj']->getUserMeta(['user_id' =>$uid,'user_meta_key'=>'user_specialties']);		
							?>
							@if(!empty($datstts))
							<a href="{{url('/profile/edit?tab=info')}}" title="Edit Information" id="edit-user-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							@endif
						</div>
						<div class="dd-info-list-holder">
							
							<ul class="dd-info-list">
								
								
								@if(!empty($userMeta['user_specialties']))
								
								<li><label>Specialties</label>
									
										<?php
										$counter=1;
										
										if(count($val)>3)
										{
											foreach($val as $userMetaDataspcial)
											{	
												if($counter<=3)
											 	{
											 	  echo "<button type='button' class='btn btn-primary' style='border-radius:5px;margin:5px;'id='mindata'>";		
												  echo  $userMetaDataspcial->user_meta_value;
												  echo "</button>";	
												}
												$counter++;
										 	}	


										 	 echo "<button type='button' class='btn btn-default btn-sm' data-toggle='modal' data-target='#mySpcl'>View More</button>";
										 	 
										}
										else
										{
											foreach($val as $userMetaDataspcial)
											{	
											  echo "<button type='button' class='btn btn-primary' style='border-radius:5px;margin:5px;' id='elsemindata'>";		
												  
											  echo  $userMetaDataspcial->user_meta_value;

											  echo "</button>";
											}	
										} 
									?>

									
								</li>
								
								
								<div id="mySpcl" class="modal fade" role="dialog">
								  <div class="modal-dialog">

								    <!-- Modal content-->
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">

								        	<div>
												<h4>
													 {{Auth::user()->name }}'s Specialities: 
												
												</h4>
											</div>

								        </h4>
								      </div>
								      <div class="modal-body">
								       <ul class="sh-spe-list">
								        	
								        	@php ($userspecialties = $data['userMetaObj']->getUserMeta(['user_id' =>Auth::user()->id,'user_meta_key'=>'user_specialties']) )
											@if(!empty($userspecialties))
											
											@foreach($userspecialties as $userMetaDataspcial)
												
											<li class="list-inline" style="display: inline-block;width: 33.333333%;padding: 5px;">
											  <button type='button' class='btn btn-primary' style='border-radius:5px;width: 100%;'>	
												
											  {{ $userMetaDataspcial->user_meta_value}}

											  </button>
											
												
											@endforeach
											@endif
										</ul>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      </div>
								    </div>

								  </div>
								</div>								
								@endif
								@if(!empty($userMeta['user_professional_statement']))
								<li>
								<label>Professional Statement</label>
									<p>{{ $userMeta['user_professional_statement'] }}</p>
							   </li>
							   @endif
							  
								@if(!empty($userMeta['user_education']))
								<li><label>Education</label> {{ $userMeta['user_education'] }}</li>
								@endif
								
								@if(!empty($userMeta['user_hospital_ffiliations']))
								<li><label>Hospital Affiliations</label> {{ $userMeta['user_hospital_ffiliations'] }}</li>
								@endif
								
								@if(!empty($userMeta['user_certification']))
								
								<li><label>Board Certifications</label> {{ $userMeta['user_certification'] }}</li>
								@endif
						
								@if(!empty($userMeta['user_memberships']))
								<li><label>Memberships</label> {{ $userMeta['user_memberships'] }}</li>
								
								@endif
							
								@if(!empty($userMeta['user_practice']))
								<li><label>Practice</label> {{ $userMeta['user_practice'] }}</li>
								@endif
								@if(!empty($userMeta['user_location']))
								<li><label>Location Title</label> {{ $userMeta['user_location'] }}</li>
								@endif
							
								@if(!empty($userMeta['user_address']))
								<li><label>Address</label> {{ $userMeta['user_address'] }} {{isset($userMeta['user_city']) ? $userMeta['user_city'] : '' }} {{ $userMeta['user_state'] }} {{ $userMeta['user_county'] }} {{ $userMeta['user_zipcode'] }}</li>
								@endif
								
								@if(!empty($userMeta['user_number']))
								<li><label>Phone Number</label> {{ $userMeta['user_number'] }}</li>
								@endif
								
								@if(!empty($userMeta['user_fax_number']))
								<li><label>Fax Number</label> {{ $userMeta['user_fax_number'] }}</li>
								@endif
								
								@if(!empty($userMeta['user_hospital']))
								<li><label>Hospital</label> {{ $userMeta['user_hospital'] }}</li>
								@endif
								
								
								
								@if(empty($datstts))
								<a href="{{url('/profile/edit?tab=info')}}" title="Edit Information" id="edit-user-info"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Information</a>
								@endif
								
							</ul>
							
							
							<br>
						</div>
					</div>
					@php($myallavails = $myappoint->getAvailability($uid))
								@if(!empty($myallavails))
					<div class="dd-experience-holder dd-card fw mg-b15" style="display:none">
							<div class="dd-title-holder">
								<h3>Availability</h3>
							</div>
							<div class="dd-info-list-holder">
							
								
								@foreach($myallavails as $imworking)
									<ul class="dd-info-list">
									<li>
										<label>{{$imworking->opening_days}}</label>
										<ul class="speciality">
											
												<?php
													$mytime = unserialize($imworking->opening_time);

													for($i=0;$i<sizeof($mytime);$i++)
													{	
														if($mytime[$i]==0)
														{
															echo '<li class="alert alert-danger"> Not Available</li>';
														}
														else
														{
															echo '<li class="alert alert-success" style="margin-left:5px">'.$mytime[$i].'</li>';
														}
														
													}
													
												?>
											
										</ul>
									</li>
								</ul>
								@endforeach
								
							</div>
					</div>
					@endif
					<div class="dd-experience-holder dd-card fw mg-b15" style="display:none">
							<div class="dd-title-holder">
								<h3>Followers & Followings</h3>
							</div>
							<div class="dd-group-list-holder">
								<ul class="list-group">
									<li class="list-group-item">
										<div class="col-md-6">
											<label>Follwers</label><span>1</span>
										</div>
										<div class="col-md-6">
											<label>Following</label><span>1</span>
										</div>
									</li>
								</ul>
							</div>
					</div>
					<div class="dd-info-holders dd-cards fw mg-b15s" style="display:none">
						<div class="dd-experience-holder dd-card fw mg-b15" style="display:none">
							<div class="dd-title-holder">
								<h3>Total Experience : 5 Years</h3>
							</div>
						</div>
					</div>
					
						@php($checkrole=$data['rolename']->checkRole(['id'=>Auth::user()->role_id]))
						 @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')

							<div class="dd-experience-holder dd-card fw mg-b15">
								<div class="dd-title-holder">
									<h3>Reviews & rating</h3>
									<div class="dd-rating-star pull-right">
										@if($data['reviewss']=='no')
										<ul>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
										</ul>
										@else
										<?php   $rew=0; $ir=0;  ?>
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
											<i class="fa fa-star-half-o" aria-hidden="true"></i>
											@else
											<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
											@endif
											@endfor
										</ul>
										@endif
									</div>
									<div class="dd-text-holder">
										@if(Auth::check())

										
										
											@if($data['reviewss']=='no')
											@else
											<a href="javascript:void(0)" > Patients Reviews</a>
											<!-- user show reviews info foreach start-->
											@foreach($data['reviewss'] as $allreviews)
											<div class="showreviews">
												@php ($userprofilepicreview = $data['userdatabyid']->getUserData(['id' => $allreviews->sender_id]) )
												<!-- user info foreach start-->
												@foreach($userprofilepicreview as $userMetaDatapicreview)                                                                                                        
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 padding-left-0">
													<a href="{{url('/search')}}/{{$allreviews->sender_id}}/{{$userMetaDatapicreview->name}}?ref_app={{ $data['encrypt']->encryptIt($allreviews->sender_id)}}">
														<img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="Image" title="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}" class="img-responsive media-object">                                                                   
														<h6>
															<!-- display role name -->
															
															{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}
														</h6>
														<small>{{$allreviews->created_at->format('M d, Y')}}</small>
													</a>
												</div>
												<div class=" col-lg-10 col-md-10 col-sm-10 col-xs-12">
													<div class="dd-rating-star pull-right">
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pad-left-0">
															<strong>Overall Ratings</strong>
															<div class="static-rating">
																<div class="rating-container rating-xs rating-animate">        
																	@for ($i = 0; $i < 5; $i++) 
																	@if($i<(int)$allreviews->overall)
																	<i class="fa fa-star" aria-hidden="true"></i>
																	@elseif( $i<$allreviews->overall)
																	<i class="fa fa-star-half-o" aria-hidden="true"></i>
																	@else
																	<i class="fa fa-star-o" aria-hidden="true"></i>
																	@endif
																	@endfor
																</div>
															</div>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<strong>Punctuality</strong>
															<div class="static-rating">
																<div class="rating-container rating-xs rating-animate">
																	@for ($i = 0; $i < 5; $i++) 
																	@if($i<(int)$allreviews->punctuality)
																	<i class="fa fa-star" aria-hidden="true"></i>
																	@elseif( $i<$allreviews->punctuality)
																	<i class="fa fa-star-half-o" aria-hidden="true"></i>
																	@else
																	<i class="fa fa-star-o" aria-hidden="true"></i>
																	@endif
																	@endfor
																</div>
															</div>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pad-left-0">
															<strong>Knowledge/Helpfulness</strong>
															<div class="static-rating">
																<div class="rating-container rating-xs rating-animate">
																	@for ($i = 0; $i < 5; $i++) 
																	@if($i<(int)$allreviews->knowledge)
																	<i class="fa fa-star" aria-hidden="true"></i>
																	@elseif( $i<$allreviews->knowledge)
																	<i class="fa fa-star-half-o" aria-hidden="true"></i>
																	@else
																	<i class="fa fa-star-o" aria-hidden="true"></i>
																	@endif
																	@endfor
																</div>
															</div>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<strong>Staff </strong>
															<div class="static-rating">
																<div class="rating-container rating-xs rating-animate">
																	@for ($i = 0; $i < 5; $i++) 
																	@if($i<(int)$allreviews->staff)
																	<i class="fa fa-star" aria-hidden="true"></i>
																	@elseif( $i<$allreviews->staff)
																	<i class="fa fa-star-half-o" aria-hidden="true"></i>
																	@else
																	<i class="fa fa-star-o" aria-hidden="true"></i>
																	@endif
																	@endfor
																</div>
															</div>
														</div>
													</div>
													<div class="dd-review-comment">
														{{ $allreviews->body }}
													</div>
												</div>
												<!-- Review Comment section -->
												<div class="dd-review-reply review-action" id="review-comment-div-{{$allreviews->id}}">
													<a href="javascript:void(0);" id="review-reply-{{$allreviews->id}}" onclick="showReplyReviewForm(<?php echo $allreviews->id; ?>)" class="review-reply-btn"><i class="fa fa-comment-o" aria-hidden="true"></i> <span id="comment-count-{{$allreviews->id}}">{{isset($data['review_comments'][$allreviews->id]) ? count($data['review_comments'][$allreviews->id]) : '0' }}</span> Comment{{count(isset($data['review_comments'][$allreviews->id])) > 1 ? 's' : ''}}</a>
													<!-- Modal -->
													<div id="review-modal-{{$allreviews->id}}" style="display:none;">	
														<div id="review-reply-form-{{$allreviews->id}}">
															<form action="{{ url('/profile/review-reply') }}" method="POST" data-toggle="validator" >
																{{ csrf_field() }}
																<input type="hidden" name="review_id"  value="{{$allreviews->id}}">
																<input type="hidden" name="dr_id"  value="{{$allreviews->user_id}}" id="dr_id">
																<input type="hidden" name="sender_id"  value="{{Auth::user()->id}}" id="sender_id">
																<div class="form-group">
						                                            <textarea class="form-control review-comment" id="{{$allreviews->id}}" onclick="this.select()" onkeydown="if(event.keyCode==13)  reviewReply(this);" placeholder="Write a Reply Here..." rows="1" name="comment"></textarea>
						                                            <div id="review-error-{{$allreviews->id}}"></div>
						                                        </div>		                  	
															</form>
														</div>						
													</div>
													<div id="new-review-comment-{{$allreviews->id}}"></div>
													@if($allreviews->is_reply)
														@if(isset($data['review_comments'][$allreviews->id]))
															@foreach($data['review_comments'][$allreviews->id] as $reviewComment)
																
															<?php $profPic = $reviewComment['userProf'] != '' ? $reviewComment['userProf'] : '/css/assets/img/profile-image.jpg'; ?>
																<div class="review-comment-row" id="review-comment-row-{{$reviewComment['id']}}">
																    <figure class="dd-comment-avater-holder">
																        <img src="<?php echo $profPic ?>" alt="" width="30" class="img-responsive media-object">
																    </figure>

																    <div class="comment-info" style="">
																        <a href="/search/<?php echo $reviewComment['uid']; ?>/<?php echo $reviewComment['userName']; ?>" gold=""><?php echo $reviewComment['userName']; ?></a><br>

																            <?php echo $reviewComment['comment']; ?>
																        <br>
																        <div class="dd-comment-footer fw">
																            <ul>                
																                <li>        	
																                    <?php echo $reviewComment['commentTime']; ?>
																                </li>
																            </ul>
																        </div>
																        <br> 
																	</div>
																</div>
															@endforeach	
														@endif	
														<p><a href="javascript:void(0);" id="loadMore-review-comment-{{$allreviews->id}}"> Show More..</a></p>	
														<p><a href="#review-div-{{$allreviews->id}}" id="write-review-comment-link-{{$allreviews->id}}" style="display: none;"> Write Comment..</a></p>
													@endif	
												</div>
												<!-- End Review Comment -->
												@endforeach
												<!-- user info foreach end-->
											</div>
											@endforeach
											<!-- user show reviews info foreach end-->
											@endif
											@endif
									</div>	
								</div>
							</div>
						@endif	
						<div class="dd-professional-holder dd-card fw mg-b15" style="display:none;">
							<div class="dd-title-holder">
								<h3>Professional Statement</h3>
								
								@if(!empty($userMeta))
								<a href="{{url('/profile/edit?tab=p-stat')}}" title="Edit Professiopnal Statement" id="edit-user-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								@endif
							</div>
							<div class="dd-text-holder">
								@if(!empty($userMeta))
								<p>{{isset($userMeta['user_professional_statement']) ? $userMeta['user_professional_statement'] : '' }}</p>
								@else
								<a href="{{url('/profile/edit?tab=p-stat')}}" title="Add Professiopnal Statement" id="edit-user-info"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Information</a>
								@endif
							</div>
						</div>
						<div class="dd-post-holder dd-card fw" style="display:none">
							<div class="dd-title-holder">
								<h3>Past Experience</h3>
								
								@if(!empty($userMeta))
								<a href="{{url('/profile/edit?tab=p-exp')}}" title="Edit Past Experience" id="edit-user-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								@endif
							</div>
							<div class="dd-text-holder">
								@if(!empty($userMeta))
								<p>{{isset($userMeta['user_past_experience']) ? $userMeta['user_past_experience'] : '' }}</p>
								@else
								<a href="{{url('/profile/edit?tab=p-exp')}}" title="Add Past Experience" id="edit-user-info"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Past Experience</a>
								@endif
							</div>
						</div>
						
					
						<!-- Photos Tabs start-->
						@include('user.media.allPhotos')
						<!-- Photos Tabs end-->
						<!-- Connection Tabs start-->
						@include('user.connections.connectionslist')
						<!-- Connection Tabs end-->
						<div class="dd-reffer-holder dd-card fw mg-b15">
							<div class="dd-title-holder">
								<h3>Refer</h3>
							</div>
							<div class="dd-reffer-list-holder">
								<center>My Referrals comes here :)</center>
							</div>
						</div>
					
						<div class="dd-reffer-holder dd-card fw">
							<div class="dd-title-holder">
								<h3>Favored For</h3>
							</div>
							<div class="dd-reffer-list-holder">
								<div class="dd-reffer-list">
									<label>Option One</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-04.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-05.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-06.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-08.png" alt=""></li>
									</ul>
								</div>
								<div class="dd-reffer-list">
									<label>Option Two</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-05.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-06.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-08.png" alt=""></li>
									</ul>
								</div>
								<div class="dd-reffer-list">
									<label>Option Three</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-04.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-08.png" alt=""></li>
									</ul>
								</div>
								<div class="dd-reffer-list">
									<label>Option Four</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-04.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-05.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-06.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				
				<div class="col-md-6 pl pdding-rights">
					
	        			<div class="dd-timeline-posts-holder fw">
	                       	@include('user.timeline.postForm')
							<div class="dd-post-holder fw">
							@if(!empty($postblog['timeline_post']))
							<div class="dd-post-holder fw" id="results">
							<input type="hidden" id="base_url" value="{{url('/profile')}}">
							
							</div>
							<div class="ajax-loading"><img src="{{ asset('css/assets/img/loadmore.gif') }}" /></div>
							@else

							@endif      
							</div>
	                	</div>
	             
                </div>
        	</div>
    	</div>
	</div>
			
	@else
	
	<div class="main-content-holder">
		<div class="container">
			<div class="row">
				<div class="col-md-6 pl">
					<div class="dd-info-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Information</h3>
							<?php $userMeta = $data['userAllMetaData'] ?>
							@if(!empty($userMeta))
							<a href="{{url('/profile/edit?tab=info')}}" title="Edit Information" id="edit-user-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							@endif
						</div>
						<div class="dd-info-list-holder">
							<ul class="dd-info-list">
								@if(!empty($userMeta))
								<li><label>Name</label> {{$name }}</li>
								<li><label>Address</label>{{isset($userMeta['user_address']) ? $userMeta['user_address'] : '' }}</li>
								<li><label>Number</label> {{isset($userMeta['user_number']) ? $userMeta['user_number'] : '' }}</li>
								<li><label>Company</label>{{isset($userMeta['user_company']) ? $userMeta['user_company'] : '' }} </li>
								<li><label>Hospital</label> {{isset($userMeta['user_website']) ? $userMeta['user_website'] : '' }}</li>
								@else
								<a href="{{url('/profile/edit?tab=info')}}" title="Edit Information" id="edit-user-info"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Information</a>
								@endif
							</ul>
						</div>
					</div>
					<div class="dd-info-holder dd-card fw mg-b15">
						<div class="dd-reffer-holder dd-card fw">
							<div class="dd-title-holder">
								<h3>Favored For</h3>
							</div>
							<div class="dd-reffer-list-holder">
								<div class="dd-reffer-list">
									<label>Option One</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-04.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-05.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-06.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-08.png" alt=""></li>
									</ul>
								</div>
								<div class="dd-reffer-list">
									<label>Option Two</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-05.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-06.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-08.png" alt=""></li>
									</ul>
								</div>
								<div class="dd-reffer-list">
									<label>Option Three</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-04.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-08.png" alt=""></li>
									</ul>
								</div>
								<div class="dd-reffer-list">
									<label>Option Four</label>
									<ul class="dd-reffer-item pull-right">
										<li><img src="/css/assets/img/dummy-img-03.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-04.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-05.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-06.png" alt=""></li>
										<li><img src="/css/assets/img/dummy-img-07.png" alt=""></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					@if(Auth::check())
					<!-- Photos Tabs start-->
						@include('user.media.allPhotos')
						<!-- Photos Tabs end-->
						@endif
						<!-- Connection Tabs start-->
						@include('user.connections.connectionslist')
						<!-- Connection Tabs end-->
				</div>
				<div class="col-md-6 pl">
					<div class="main-content-holders">
						@if(Auth::check())
	        			<div class="dd-timeline-posts-holder fw">
	                         @include('user.timeline.postForm')
						<div class="dd-post-holder fw">
						@if(!empty($postblog['timeline_post']))
						<div class="dd-post-holder fw" id="results">
						<input type="hidden" id="base_url" value="{{url('/profile')}}">
						
						</div>
						<div class="ajax-loading"><img src="{{ asset('css/assets/img/loadmore.gif') }}" /></div>
						@else

						@endif      
						</div>
	                	</div>
	                	@else
	                	<!-- Photos Tabs start-->
						@include('user.media.allPhotos')
						<!-- Photos Tabs end-->
	                	@endif 
	                </div>
				</div>
			</div>
		</div>
	</div>
	@endif
	@endif
</section>

@endsection