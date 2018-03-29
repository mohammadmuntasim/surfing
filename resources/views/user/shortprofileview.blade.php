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
	@php($checkrole = $data['rolename']->SearchedUserRole($data['userid']))
	<div class="main-content-holder">
		<div class="container">
			<div class="row">
				<div class="col-md-6 pl">
					<div class="dd-info-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Profile Summary </h3>
						</div>
						<div class="dd-info-list-holder">
							<?php $sid=$data['userid']; ?>
							@php($datstts=$data['userMetaObj']->getUserMeta(['user_id'=>$data['userid']]))
								@php ($userspecialties = $data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_specialties']) )
									@if(sizeof($userspecialties)>0)
									<ul class="dd-info-list"> <li><label>Specialities:</label>
									<?php
										$counter=1;
										
										if(count($userspecialties)>3)
										{
											foreach($userspecialties as $userMetaDataspcial)
											{	
												if($counter<=3)
											 	{
											 	  echo "<button type='button' class='btn btn-primary' style='border-radius:5px;'id='mindata'>";		
												  echo  $userMetaDataspcial->user_meta_value;
												  echo "</button>";	
												}
												$counter++;
										 	}	

										 		
										 	echo "<button type='button' class='btn btn-default btn-sm' data-toggle='modal' data-target='#mySpcl$sid'>View More</button>";
										 	 
										}
										else
										{
											foreach($userspecialties as $userMetaDataspcial)
											{	
											  echo "<button type='button' class='btn btn-primary' style='border-radius:5px;' id='elsemindata'>";		
												  
											  echo  $userMetaDataspcial->user_meta_value;

											  echo "</button>";
											}	
										} 
									?>
									<div id="mySpcl{{$sid}}" class="modal fade" role="dialog">
										  <div class="modal-dialog">

											    <!-- Modal content-->
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal">&times;</button>
											        <h4 class="modal-title">

											        	<div>
															<h4>
																<strong> Specialties: </strong>
															
															</h4>
														</div>

											        </h4>
											      </div>
											      <div class="modal-body">
											        <ul class="sh-spe-list">
											        	
											        	@php ($userspecialties = $data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_specialties']) )
														@if(!empty($userspecialties))
														
														@foreach($userspecialties as $userMetaDataspcial)
															
														<li class="list-inline" style="display: inline-block;width: 33.333333%;padding: 5px;">
														  <button type='button' class='btn btn-primary' style='border-radius:5px;width: 100%;'>	
															  
														  {{ $userMetaDataspcial->user_meta_value}}

														  </button>
														</li>
															
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
								</li>
							</ul>
							<ul class="dd-info-list">
								

								@foreach($datstts as $valueinfo)
								
								@if(!empty($valueinfo->user_meta_key))
								
								@if($valueinfo->user_meta_key=='user_professional_statement')
								<li>
								<label>Professional Statement</label>
									<p>{{ $valueinfo->user_meta_value }}</p>									
							   </li>
							   @endif
							  
								@if($valueinfo->user_meta_key=='user_education')
								<li><label>Education</label> {{ $valueinfo->user_meta_value }}</li>
								@endif
								
								@if($valueinfo->user_meta_key=='user_hospital_ffiliations')
								<li><label>Hospital Affiliations</label> {{ $valueinfo->user_meta_value }}</li>
								@endif
								
								@if($valueinfo->user_meta_key=='user_certification')
								
								<li><label>Board Certifications</label> {{ $valueinfo->user_meta_value }}

								</li>
								@endif
								
								
						
								@if($valueinfo->user_meta_key=='user_memberships')
								<li><label>Memberships</label> {{ $valueinfo->user_meta_value }}</li>
								
								@endif
							
								@if($valueinfo->user_meta_key=='user_practice')
								<li><label>Practice</label> {{ $valueinfo->user_meta_value }}</li>
								@endif
							
								
								
								
								
								@if($valueinfo->user_meta_key=='user_fax_number')
								<li><label>Fax Number</label> {{ $valueinfo->user_meta_value }}</li>
								@endif
								
								
								@if($valueinfo->user_meta_key=='user_hospital')
								<li><label>Hospital</label> {{ $valueinfo->user_meta_value }}</li>
								@endif

								
								@endif
								@endforeach
								@php($getemail=$data['userdatabyid']->getUserData(['id'=> $data['currentUserid']]))
								@if(!empty($getemail[0]->email))
								<li>
								<label>Email</label>
									<p>{{$getemail[0]->email }}</p>									
							   </li>
							   @endif
								
							</ul>
							
						<br>
						
						</div>
					</div>
					@if(Auth::check())
					 @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.' ||  $checkrole=='H.')
                     @if($data['userdatabyid']->claimProfile($data['currentUserid'])==1)
					<div class="dd-experience-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Reviews</h3>
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
						</div>
						

						<div class="dd-group-list-holder tab-Dr">
							<ul class="list-group">
								<li class="list-group-item text-center">
									<div class="text-left">Write your review
										@if(Auth::check())

										<a class="btn btn-success btn-green pull-right" href="javascript:void(0)" id="open-review-box">Write a review</a>
										@else
										<a class="btn btn-success btn-green pull-right" href="javascript:void(0)" data-toggle="modal" data-target="#myModalsign">Write a review</a>
										@endif
									</div>
								</li>
							</ul>
							@if(Auth::check())
							@include('user.reviewform')
							@endif

									
										@if($data['reviewss']=='no')
										@else
										<h5 class="dd-title-holder-pateint-reviews">
											<a href="javascript:void(0)" > Patients Reviews</a>
										</h5>
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
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
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
												<a href="javascript:void(0);" id="review-reply-{{$allreviews->id}}" onclick="showReplyReviewForm(<?php echo $allreviews->id; ?>)" class="review-reply-btn"><i class="fa fa-comment-o" aria-hidden="true"></i>  <span id="comment-count-{{$allreviews->id}}">{{isset($data['review_comments'][$allreviews->id]) ? count($data['review_comments'][$allreviews->id]) : '0' }}</span> Comment{{count(isset($data['review_comments'][$allreviews->id])) > 1 ? 's' : ''}}</a>
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
										
						</div>
						
					</div>
					@endif
					@endif
					<div class="dd-professional-holder dd-card fw mg-b15" style="display:none;">
						<div class="dd-title-holder">
							<h3>Professional Statement</h3>
							
							
						</div>
						<div class="dd-text-holder">
							@if(!empty($userMeta))
						
							@endif
						</div>
					</div>
					@php($checkrole = $data['rolename']->SearchedUserRole($data['userid']))
                     @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')
                                
					@php($myallavails = $myappoint->getAvailability($data['userid']))
					@if(!empty($myallavails))
					<div class="dd-professional-holder dd-card fw mg-b15" style="display:none">
						<div class="dd-title-holder">
							<h3>Availability</h3>
							
							
						</div>
						<div class="dd-text-holder">
							
										
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
					@endif
					
					<div class="dd-post-holder dd-card fw" style="display:none;">
						<div class="dd-title-holder">
							<h3>Post Experience</h3>
							
						</div>
						<div class="dd-text-holder">
							@if(!empty($userMeta))
							
							@endif
						</div>
					</div>
					<br>
					<br>
					<br>
					 @if($data['userdatabyid']->claimProfile($data['currentUserid'])==1)
					 @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')
                           @php ($userprofilepicreview = $data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_address']) )
							@if(sizeof($userprofilepicreview)>0)
					<div class="dd-professional-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Location</h3></div>
							
						<div  class="text-justify">
							
								@foreach($userprofilepicreview as $userMetaAdd)   
								@php ($address = $userMetaAdd->user_meta_value  ) 
								<input type="text" id="address-input" value="{{ $userMetaAdd->user_meta_value }}" style="display:none;">
								<i class="fa fa-map-marker" aria-hidden="true"></i> 
								<!--  <button onclick="searchAddress();">Search</button> -->
								@php($zips=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_zipcode']))
								@php($city=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_city']))
									@php($county=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_county']))
									@php($state=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_state']))
								    {{ $userMetaAdd->user_meta_value }} 

									@foreach($city as $cityvalue)
									{{$cityvalue->user_meta_value}}
									@endforeach
									@foreach($county as $countyvalue)
									{{$countyvalue->user_meta_value}}
									@endforeach
									@foreach($state as $statevalue)
									{{$statevalue->user_meta_value}}
									@endforeach
									@foreach($zips as $zipsvalue)
									{{$zipsvalue->user_meta_value}}
									@endforeach
									@if($userMetaAdd->user_meta_key=='user_number')
								   (  {{ $userMetaAdd->user_meta_value }})
								   @endif
								
								@endforeach
								@php($datstts=$data['userMetaObj']->getUserMeta(['user_id'=>$data['userid']]))
								@foreach($datstts as $valueinfo)
								@if($valueinfo->user_meta_key=='user_number')
								<br>
								<i class="fa fa-phone" aria-hidden="true"></i>   {{ $valueinfo->user_meta_value }}</li>
								@endif
								@endforeach
							
						</div>
						<div id="map-canvas"></div>
					</div>
					@endif 
					@endif
					@endif
					@endif
					
				    @if(Auth::check())

					<!-- Photos Tabs start-->
						@include('user.media.allPhotos')
						<!-- Photos Tabs end-->
						
						<!-- Connection Tabs start-->
						@include('user.connections.connectionslist')
						<!-- Connection Tabs end-->
					@endif
					
				</div>
				 

				<div class="col-md-6 pr pdding-rights">
					<div class="main-content-holders">
	        			<div class="dd-timeline-posts-holder fw">

	        				@if(Auth::check())
	        					 @if($data['userdatabyid']->claimProfile($data['currentUserid'])==0)
					 @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')
                           @php ($userprofilepicreview = $data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_address']) )
							@if(sizeof($userprofilepicreview)>0)
					<div class="dd-professional-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Location </h3></div>
							
						<div  class="text-justify">
							
								@foreach($userprofilepicreview as $userMetaAdd)   
								@php ($address = $userMetaAdd->user_meta_value  ) 
								<input type="text" id="address-input" value="{{ $userMetaAdd->user_meta_value }}" style="display:none;">
								<i class="fa fa-map-marker" aria-hidden="true"></i> 
								<!--  <button onclick="searchAddress();">Search</button> -->
								@php($zips=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_zipcode']))
								@php($city=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_city']))
									@php($county=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_county']))
									@php($state=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_state']))
								    {{ $userMetaAdd->user_meta_value }} 

									@foreach($city as $cityvalue)
									{{$cityvalue->user_meta_value}}
									@endforeach
									@foreach($county as $countyvalue)
									{{$countyvalue->user_meta_value}}
									@endforeach
									@foreach($state as $statevalue)
									{{$statevalue->user_meta_value}}
									@endforeach
									@foreach($zips as $zipsvalue)
									{{$zipsvalue->user_meta_value}}
									@endforeach
									@if($userMetaAdd->user_meta_key=='user_number')
								   (  {{ $userMetaAdd->user_meta_value }})
								   @endif
								
								@endforeach
								@php($datstts=$data['userMetaObj']->getUserMeta(['user_id'=>$data['userid']]))
								@foreach($datstts as $valueinfo)
								@if($valueinfo->user_meta_key=='user_number')
								<br>
								<i class="fa fa-phone" aria-hidden="true"></i>   {{ $valueinfo->user_meta_value }}</li>
								@endif
								@endforeach
							
						</div>
						<div id="map-canvas"></div>
					</div>
					@endif 
					@endif
					@else
						@if(sizeof($data['getConnectedornot'])==1)

						 @include('user.timeline.postForm')
						 @endif
				 		<div class="dd-post-holder fw">
						@if(!empty($postblog['timeline_post']))
						<div class="dd-post-holder fw" id="results">
						<input type="hidden" id="base_url" value="{{url('/profile')}}">
						
						</div>
						<div class="ajax-loading"><img src="{{ asset('css/assets/img/loadmore.gif') }}" /></div>
						@else

						@endif  
						@endif    
					      </div>
					      @else

					      @if($data['userdatabyid']->claimProfile($data['currentUserid'])==1)
					 @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')
                           @php ($userprofilepicreview = $data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_address']) )
							@if(sizeof($userprofilepicreview)>0)
							
					<div class="dd-professional-holder dd-card fw mg-b15">
						<div class="dd-title-holder">
							<h3>Location</h3>
						</div>
							
						<div  class="text-justify">
							
								@foreach($userprofilepicreview as $userMetaAdd)   
								@php ($address = $userMetaAdd->user_meta_value  ) 
								<input type="text" id="address-input" value="{{ $userMetaAdd->user_meta_value }}" style="display:none;">
								<i class="fa fa-map-marker" aria-hidden="true"></i> 
								<!--  <button onclick="searchAddress();">Search</button> -->
								@php($zips=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_zipcode']))
								@php($city=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_city']))
									@php($county=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_county']))
									@php($state=$data['userMetaObj']->getUserMeta(['user_id' => $data['userid'],'user_meta_key'=>'user_state']))
								    {{ $userMetaAdd->user_meta_value }} 

									@foreach($city as $cityvalue)
									{{$cityvalue->user_meta_value}}
									@endforeach
									@foreach($county as $countyvalue)
									{{$countyvalue->user_meta_value}}
									@endforeach
									@foreach($state as $statevalue)
									{{$statevalue->user_meta_value}}
									@endforeach
									@foreach($zips as $zipsvalue)
									{{$zipsvalue->user_meta_value}}
									@endforeach
									@if($userMetaAdd->user_meta_key=='user_number')
								   (  {{ $userMetaAdd->user_meta_value }})
								   @endif
								
								@endforeach
								@php($datstts=$data['userMetaObj']->getUserMeta(['user_id'=>$data['userid']]))
								@foreach($datstts as $valueinfo)
								@if($valueinfo->user_meta_key=='user_number')
								<br>
								<i class="fa fa-phone" aria-hidden="true"></i>   {{ $valueinfo->user_meta_value }}</li>
								@endif
								@endforeach
							
						</div>
						<div id="map-canvas"></div>
					</div>
					@endif 
					@endif
					@endif
	                	<!-- Photos Tabs start-->
						@include('user.media.allPhotos')
						<!-- Photos Tabs end-->
	                	@endif 
			              
		                </div>
		            </div>
		      </div>
	</div>
	</div>
	</div>
</section>
@endsection