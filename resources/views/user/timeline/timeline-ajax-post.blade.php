
@php($uids = $postvalues->user_id) 
@php($myuids = Auth::user()->id)
<div class="dd-single-post-holder" id="singplepostid-{{$postvalues->id}}">
	<div class="dd-post-header fw" id="postcontent{{$postvalues->id}}">

		@php( $getposteduserid = $data['otherUserTimelinePosted']->getUserDataTimelinePosted($postvalues->id))
    	@php($postedonuserid='')
    	@if(sizeof($getposteduserid)>0)
	    	@foreach($getposteduserid as $dettt)
	    		
	    		@php($postedonuserid = $dettt->posted_on_user_id)

	    	@endforeach
    	@endif
    	
		 @if($myuids == $uids)
                <div class="btn-group pull-right">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <div class="arrow" style="left: 50%;"></div>
                        
                       <li>
                            <a href=""  id="editpost" rel="" data-toggle="modal" data-target="#editMyPostModal{{$postvalues->id}}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
                        </li>
                        <li>
                             <a href="" data-toggle="modal" data-target="#deleteMyPostModal{{$postvalues->id}}"><i class="fa fa-trash" aria-hidden="true"></i>  Delete</a>
                        </li>
                    </ul>
                </div>

                <!-- EDIT POST Modal -->
				<div id="editMyPostModal{{$postvalues->id}}" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Edit Post</h4>
				      </div>
				      <div class="modal-body" style="clear:both; float:left;width:100%">
							<div class="dd-write-post dd-card">
	                            <ul class="nav nav-tabs" role="tablist">
	                                <li role="presentation" class="active">
	                                    <a class="type-article" href="#post-type-article" aria-controls="article" role="tab" data-toggle="tab">Post Article</a>
	                                </li>
	                            </ul>


	                            <!-- Tab panes -->
	                            <div class="tab-content">
	                                <div role="tabpanel" class="tab-pane active" id="post-type-article">
		                                <div class="dd-post-write-holder">
		                                    
		                                    
		                                	@if($postvalues->media_id==0 && $postvalues->type==0)
		                                	<!-- SINGLE SIMPLE POST -->
		                                    <form class="form-horizontal" role="form" >
		                                         {{ csrf_field() }}
		                                        
			                                        <div class="form-group" style="clear:both; float:left;width:100%">
			                                        	
			                                        	
			                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedcontentonly" style="font-size:25px">{{$postvalues->content }}</textarea>
			                                        </div>
			                                        <div class="surfhealth-modal-footer">
		                                        <button type="button" class="btn btn-default" onclick="updatepost({{$postvalues}})">Post</button>
		                                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
		                                    </div>
		                                    </form>
		                                    <!-- POST WITH PHOTO -->
		                                    @elseif($postvalues->media_id!=0 && $postvalues->type==0)
		                                    <form class="form-horizontal" role="form" >
		                                         {{ csrf_field() }}
		                                        
			                                        <div class="form-group">
			                                        	

			                                        	<input type="hidden" value="{{$postvalues->media_id}}" id="editimageid">
			                                        	@if($postvalues->content=='')
			                                        	
			                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedphotocontent" style="font-size:25px"></textarea>
			                                            @else
			                                            
			                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedphotocontent" style="font-size:25px">{{$postvalues->content}}</textarea>
			                                           	@endif

			                                            <div class="col-lg-4 col-sm-4"><img src="{{$data['myphotos']->getMediaUrlById($postvalues->media_id)}}"  id="myimg{{$postvalues->media_id}}" class="img-responsive"><i class="fa fa-times" aria-hidden="true" id="mecross{{$postvalues->media_id}}"onclick="removeme({{$postvalues->media_id}})"></i></div>
			                                        	

			                                        </div>

			                                      <div class="surfhealth-modal-footer">
				                                        <button type="button" class="btn btn-default" onclick="updatephoto({{$postvalues}})">Post</button>
				                                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
			                                    	</div>
		                                    </form>
		                                    @else
		                                    	
		                                    	@if($postvalues->media_id==0)
		                                    	<form class="form-horizontal" role="form" >
		                                        	{{ csrf_field() }}
		                                        
			                                        <div class="form-group">

			                                        	<input type="hidden" value="{{$postvalues->type}}" id="editsharetype">
			                                        	
			                                        	@if($postvalues->content=='')
			                                        	<textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedsharedcontent" style="font-size:25px"></textarea>
														
														@else
														<textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedsharedcontent" style="font-size:25px">{{$postvalues->content}}</textarea>
														
														@endif	
			                                            <div id="myshare{{$postvalues->id}}">
			                                            	<!-- <i class="fa fa-times" aria-hidden="true" id="mecross{{$postvalues->media_id}}"onclick="shareeditpost({{$postvalues->id}})"></i>
			                                            		 -->					                                        	

				                                        	<!-- get user data who created post  -->
															@if(!empty($sharepost))
															@foreach($sharepost as $postsharedata)
															@php($userdatapost=$data['userdatabyid']->getUserData(['id'=>$postsharedata->post_user_id]))
															@foreach($userdatapost as $usersdatapost)
															<figure class="dd-post-avater-holder">
																@if(empty($usersdatapost->avatar))     
																<img src="/css/assets/img/dummy-img-10.jpg" alt="">
																@else
																<img src="{{ $usersdatapost->avatar }}" alt="Image" class="img-responsive media-object">
																@endif
															</figure>
															<div class="dd-post-user-holder">
																<h5>
																<a href="{{url('/search')}}/{{$usersdatapost->id}}/{{$usersdatapost->name}}">
																	<!-- display role name -->
																	{{$usersdatapost->name}} 
																</a>
																</h5>

																<span>
																<?php 
																$datedd2=$parentPostCreatedTime;
																$date1 = date('Y-m-d H:i:s', strtotime($datedd2));
																$date2 = date("Y-m-d H:i:s");
																
																$diff = abs(strtotime($date2) - strtotime($date1));
																
																$years = floor($diff / (365*60*60*24));
																$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
																$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
																$times=abs(strtotime($date2)-strtotime($date1));
																$gettimepost = date('h:i A', strtotime($date1));
																if($days==0){
																    $days=$times;
																	//echo $times;
																    if($times<60)
																    {
																        $days=$times." seconds";
																    }elseif($times<3600){
																        $checkminuts=floor($times/60);
																        if($checkminuts<59){
																                $days=$checkminuts."  minutes";
																        }else{
																        $days="about an hours";
																       }
																
																    }else{
																        $checkminuts=floor($times/3600);
																        $days=$checkminuts." hrs";
																    }
																    
																}elseif($days==1) {
																       $days='Yesterday at '.$gettimepost;
																}elseif($days>1){
																        if($years==0){
																        $days=date('d M', strtotime($date1))." at ".$gettimepost;
																       }else{
																        $days=date('d-m-y h:i A', strtotime($date1))." at ".$gettimepost;
																       }
																    }
																    ?>
																{!! $days !!} 
															    </span>
				
															</div>
															<div class="post-content shared clearfix">	
																@php($sharedata=$data['timlinepost']->getPostDataById($postsharedata->parent_post_id))

																@foreach($sharedata as $sharedvalue)		
																<div class="posttext">{!! $sharedvalue->content !!}</div>
																@endforeach
															</div>
															@endforeach
															@endforeach
															@endif
				                                        </div>

				                                         <div class="surfhealth-modal-footer">
					                                        <button type="button" class="btn btn-default" onclick="updateshare({{$postvalues}})">Post</button>
					                                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
				                                    	</div>
				                                    </div>	
		                                    	</form>
		                                    	 @else
				                                <form class="form-horizontal" role="form" >
				                                         {{ csrf_field() }}
				                                        
					                                        <div class="form-group">
					                                        	<input type="hidden" value="{{$postvalues->type}}" id="editsharetype">
					                                        	@if($postvalues->content=='')
					                                        	<textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedsharedcontent" style="font-size:25px"></textarea>
																@else
																<textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" id="updatedsharedcontent" style="font-size:25px">{{$postvalues->content}}</textarea>
																@endif	
																<div class="" id="sharewithphoto{{$postvalues->media_id}}" style="border:1px red solid;clear: both;float: left; width: 100%;">
					                                            	<img src="{{$data['myphotos']->getMediaUrlById($postvalues->media_id)}}" class="img-responsive">

					                                            	<!-- <i class="fa fa-times" aria-hidden="true" id="mecross{{$postvalues->media_id}}"onclick="removemesharephot({{$postvalues->media_id}})"></i>
					                                          	 -->
					                                            	<!-- get user data who created post  -->
																	@if(!empty($sharepost))
																	@foreach($sharepost as $postsharedata)
																	@php($userdatapost=$data['userdatabyid']->getUserData(['id'=>$postsharedata->post_user_id]))
																	@foreach($userdatapost as $usersdatapost)
																	<figure class="dd-post-avater-holder">
																		@if(empty($usersdatapost->avatar))     
																		<img src="/css/assets/img/dummy-img-10.jpg" alt="">
																		@else
																		<img src="{{ $usersdatapost->avatar }}" alt="Image" class="img-responsive media-object">
																		@endif
																	</figure>
															
																	<div class="dd-post-user-holder">
																		<h5>
																	<a href="{{url('/search')}}/{{$usersdatapost->id}}/{{$usersdatapost->name}}">
																		<!-- display role name -->
																		{{$usersdatapost->name}} 
																	</a>
																		</h5>

																		<span>
																		<?php 
																	$datedd2=$parentPostCreatedTime;
																	$date1 = date('Y-m-d H:i:s', strtotime($datedd2));
																	$date2 = date("Y-m-d H:i:s");
																	
																	$diff = abs(strtotime($date2) - strtotime($date1));
																	
																	$years = floor($diff / (365*60*60*24));
																	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
																	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
																	$times=abs(strtotime($date2)-strtotime($date1));
																	$gettimepost = date('h:i A', strtotime($date1));
																	if($days==0){
																	    $days=$times;
																		//echo $times;
																	    if($times<60)
																	    {
																	        $days=$times." seconds";
																	    }elseif($times<3600){
																	        $checkminuts=floor($times/60);
																	        if($checkminuts<59){
																	                $days=$checkminuts."  minutes";
																	        }else{
																	        $days="about an hours";
																	       }
																	
																	    }else{
																	        $checkminuts=floor($times/3600);
																	        $days=$checkminuts." hrs";
																	    }
																	    
																	}elseif($days==1) {
																	       $days='Yesterday at '.$gettimepost;
																	}elseif($days>1){
																	        if($years==0){
																	        $days=date('d M', strtotime($date1))." at ".$gettimepost;
																	       }else{
																	        $days=date('d-m-y h:i A', strtotime($date1))." at ".$gettimepost;
																	       }
																	    }
																		?>
																		{!! $days !!} 
															  			 </span>
																	</div>
																	<div class="post-content shared clearfix">	
																		@php($sharedata=$data['timlinepost']->getPostDataById($postsharedata->parent_post_id))

																		@foreach($sharedata as $sharedvalue)		
																		<div class="posttext">{!! $sharedvalue->content !!}</div>
																		@endforeach
																	</div>
																	@endforeach
																	@endforeach
																	@endif
															  </div>
					                                        </div>

					                                       <div class="surfhealth-modal-footer">
						                                        <button type="button" class="btn btn-default" onclick="updateshare({{$postvalues}})">Post</button>
						                                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
					                                    	</div>
				                                </form>
				                                 @endif
		                                   	 @endif
		                               	 </div>  
	                            	</div>


		                            <div role="tabpanel" class="tab-pane" id="post-type-photo">
		                                <div class="dd-post-write-holder">
		                                     <form class="form-horizontal" role="form"  id="upload_form" method="POST" action="{{ url('/profile') }}"  enctype="multipart/form-data">
		                                         {{ csrf_field() }}                                         

		                                        <div class="form-group">
		                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content">{{$postvalues->content }}</textarea>
		                                        </div>
		                                        
		                                        <div class="form-group">
		                                        <figure class="dd-cover-changer">  
		                                            <!--<a href="#" class="removedpost"><i class="fa fa-remove" aria-hidden="true"></i></a>  -->                 
		                                           <img src="" alt="surf health cover " id="cover-image-individiual">     
		                                         </figure>
		                                        </div>
		                                        <div class="form-group margin-top-10 dd-post-img-uploader">
		                                       		<input id="file-1" class="inputfile inputfile-1 file" type="file" name="post_image" multiple data-overwrite-initial="false" data-min-file-count="1" id="imagedatagetimagedata(document.getElementById('imagedata'))">
		                                           	<label for="file-1"><i class="glyphicon glyphicon-plus"></i><span></span></label>
		                                         	<button type="submit" class="btn btn-default" >Post</button>
		                                        </div>		                                       
		                                    </form>

		                                </div>
		                            </div>
	                            </div>
	                        </div>
					 </div>
				      <div class="modal-footer">
				        
				        
				      </div>
				    </div>

				  </div>
				</div>

				<!-- DELETE POST MODAL -->
				<div id="deleteMyPostModal{{$postvalues->id}}" class="modal fade" role="dialog">
 					 <div class="modal-dialog">

		    			<!-- Modal content-->
		   				 <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Delete Post</h4>
						      </div>
						      <div class="modal-body">
						        <h4>This post will be deleted and you'll no longer be able to find it. You can also edit this post if you just want to change something.</h4>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" >Close</button>
						        <button type="button" class="btn btn-default pull-right"  data-dismiss="modal" data-toggle="modal" data-target="#editMyPostModal{{$postvalues->id}}">Edit</button>
						        <button type="button" class="btn btn-default pull-right" data-dismiss="modal" onclick="deletepost({{$postvalues}})">Delete</button>
						      </div>
		   				</div>

 					 </div>
				</div>

				@elseif($myuids == $postedonuserid)	
				<div class="btn-group pull-right">
		                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
		                </a>
		                <ul class="dropdown-menu">
		                   <div class="arrow" style="left: 50%;"></div>
		                    <li>
		                         <a href="" onclick="deletepost({{$postvalues}})"><i class="fa fa-trash" aria-hidden="true"></i>  Delete</a>
		                    </li>
						</ul>
		        </div>		
		@endif
		<!-- start main post html -->
		@php($userprofilepic=$data['userdatabyid']->getUserData(['id'=>$uids]))
		@foreach($userprofilepic as $userMetaDatapic)
		<figure class="dd-post-avater-holder">
			<img src="{{ isset($userMetaDatapic->avatar) ?  $userMetaDatapic->avatar : '/css/assets/img/profile-image.jpg' }}" alt="Profile Image" title="{{ isset($userMetaDatapic->name) ?  $userMetaDatapic->name : '' }}" class="img-responsive media-object">
		</figure>
		<div class="dd-post-user-holder">
			<ul>
				<li><h5><a href="{{url('/search')}}/{{$userMetaDatapic->id}}/{{$userMetaDatapic->name}}">{{$userMetaDatapic->name}}</a></h5></li>
				<!-- for share post title start-->
				@if(!empty($sharepost))
				@foreach($sharepost as $postsharedata2)   
				@php($userdatapost2=$data['userdatabyid']->getUserData(['id'=>$postsharedata2->post_user_id]))  
				<!-- find user gender from meta table -->
				@php($userdatapost3=$data['userMetaObj']->getUserMeta(['user_id'=>$postsharedata2->post_user_id,'user_meta_key'=>'user_gender']))  
				@php($checkgender='')
				@if(sizeof($userdatapost3)>0)
				@foreach($userdatapost3 as $userdatapostname3)
				@php($checkgender=$userdatapostname3->user_meta_value)
				@endforeach
				@endif

				@foreach($userdatapost2 as $userdatapostname) 
				@if($userdatapostname->id!=$postsharedata2->share_user_id)  
				<li><span>shared</span></li>
				<li><h5><a href="{{url('/search')}}/{{$userdatapostname->id}}/{{$userdatapostname->name}}">{{ $userdatapostname->name }} </a></h5></li>
				<li> post.</li>
				@else
				<li>shared @if($checkgender=='female') her @else  his @endif post.</li>
				@endif

				@endforeach
				@endforeach
				<!-- for share post title end-->
				@endif
				<!-- posted on other user timeline  start-->
				@php($showpostedTimeline=$data['otherUserTimelinePosted']->getUserDataTimelinePosted($postvalues->id))
				@if(sizeof($showpostedTimeline)>0)
					@foreach($showpostedTimeline as $getPosteduserid)
						<!-- get user data by id from user table -->
						@php($userdatapost2=$data['userdatabyid']->getUserData(['id'=>$getPosteduserid->posted_on_user_id]))  
						@if(sizeof($userdatapost2)>0)
							@foreach($userdatapost2 as $getvalue)
						
							<li class="postedonTimeline"> <h5> <span> posted on </span> <a href="{{url('/search')}}/{{$getvalue->id}}/{{$getvalue->name}}">{{$getvalue->name}}</a> <span>timeline.</span></h5> </li>
							@endforeach
						@endif
					
						
					@endforeach
				@endif

			</ul>
			@endforeach
			<!-- Time posted show  -->
			<sp
			an><?php $datedd=$postvalues->updated_at;   ?>@include('user.timeline.getTimes')</span>
		</div>
	</div>
	<div class="dd-post-content fw" id="timeline-post-content{{$postvalues->id}}">
		<div class="post-content">
			<div class="posttext">{!! $postvalues->content !!}</div>
			<!-- check post is album or not / post type 1 means post is album  start-->
			@if($postvalues->post_type==1)

				@include('user.timeline.albumPost')
			<!-- check post is album or not / post type 1 means post is album  end-->
			@else
			@if($postvalues->media_id!=0)
				<div class="postimage">
				 <img src="{{$data['myphotos']->getMediaUrlById($postvalues->media_id)}}" class="img-responsive">
				</div>
			 @endif
			 @endif
	    </div>
		<!-- get user data who created post  -->
		@if(!empty($sharepost))
		@foreach($sharepost as $postsharedata)
		@php($userdatapost=$data['userdatabyid']->getUserData(['id'=>$postsharedata->post_user_id]))
		@foreach($userdatapost as $usersdatapost)
		<figure class="dd-post-avater-holder">
			@if(empty($usersdatapost->avatar))     
			<img src="/css/assets/img/dummy-img-10.jpg" alt="">
			@else
			<img src="{{ $usersdatapost->avatar }}" alt="Image" class="img-responsive media-object">
			@endif
		</figure>
		<div class="dd-post-user-holder">
			<h5>
				<a href="{{url('/search')}}/{{$usersdatapost->id}}/{{$usersdatapost->name}}">
					<!-- display role name -->
					{{$usersdatapost->name}} 
				</a>
			</h5>

			<span>
				<!-- Time posted show  -->
			<span><?php $datedd=$parentPostCreatedTime;   ?>@include('user.timeline.getTimes')</span></span>
			
		</div>
		<div class="post-content shared clearfix">	
		@php($sharedata=$data['timlinepost']->getPostDataById($postsharedata->parent_post_id))
			@if(!empty($sharedata))
			@foreach($sharedata as $sharedvalue)		
			<div class="posttext">{!! $sharedvalue->content !!}</div>
			@endforeach
			@endif
		</div>
		@endforeach
		@endforeach
		@endif
	</div>
	<div class="dd-post-footer fw">
		<ul>
			<!-- count if I  like this post or not  -->
			@php($mylike=$data['countlike']->TotalLikeByPostId(['content_id'=>$postvalues->id,'user_id'=>$myuids,'type'=>0]))
			<li><a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-{{$postvalues->id}}"  data-like='{"p_id":"<?php echo $postvalues->id ?>","l_status":"0","p_uid":"<?php echo $uids ?>"}' @if($mylike==1) class="orangecolor" @endif><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;Like</a></li>
			<li><a href="#."  id="maincomment-{{$postvalues->id}}"  onclick="chide(this)"><i class="fa fa-comment-o" aria-hidden="true" ></i>&nbsp;@php($commentcount = $timelinePostController->totalcomment(['commetid'=>$postvalues->id]))
				{{$commentcount}}Comment</a>
			</li>
			<li>
				<div class="btn-group">
				  	<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    	<i class="fa fa-share-square-o" aria-hidden="true" ></i>Share
				  	</a>
				  	<ul class="dropdown-menu">
				  		<div class="arrow" style="left: 50%;"></div>
					   <li><a href='javascript:void(0);' onclick='SharePost(this)' id='sharenow-{{$postvalues->id}}'>Share Now </a></li>
					   	<li><a href='javascript:void(0);'  id='share-{{$postvalues->id}}'  data-toggle='modal' data-target='#sharewithcontent' onclick='getpostid(this)' >Share </a></li>
				  	</ul>
				</div>
			</li>
		</ul>
	</div>
	<div class="dd-comments-holder postid{{$postvalues->id}} ">
		<div class="dd-show-likes">
			@php($postTotallike=$data['countlike']->TotalLikeByPostId(['content_id'=>$postvalues->id,'type'=>0]))
			<a href="#."><i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;
				@if($mylike==1)
					You 
					@if($postTotallike>1)
					<?php $postTotallike=$postTotallike-1; ?>
					and {{$postTotallike}} others
					@endif
				@else
				@if($postTotallike==0)
				 0 Likes
				 @else
				 {{$postTotallike}} others
				@endif
				
				@endif
			
			</a>
		</div>
	</div>
	<div class="all-comment-div dd-comments-holder cpostid{{$postvalues->id}}" id="commentbox-{{$postvalues->id}}" style="display:none">		
		<div class="dd-write-comment" id="comment-div-{{$postvalues->id}}">	
			<div id="comment-box-{{$postvalues->id}}" style="margin-bottom: 3px;">
				<textarea class="form-control commentarea"  id="{{$postvalues->id}}" onclick="this.select()"  onKeyDown="if(event.keyCode==13)  homecomments(this);"  placeholder="Write a comment..." rows="1" name="comment" ></textarea>
			</div>		
			@for($i=0;$i< sizeof($comments);$i++)
			@foreach ($comments[$i] as $value) 
			@if($postvalues->id == $value->content_id)
			@php ($userinfo = $userpic->getUserData(['id'=>$value->comment_userid]))
			<!-- $userinfo -->
			<div class="row comment-row {{$i}}" id="old-comment-hide-after-edit{{$value->id}}">
				@php($showpostedTimeline=$data['otherUserTimelinePosted']->getUserDataTimelinePosted($postvalues->id))
			
				@if(!empty($showpostedTimeline))
					@php($datasss ='')
					@foreach($showpostedTimeline as $getpostid)
						@php($datasss =$getpostid->posted_on_user_id)
					@endforeach
				@endif	

				@if($myuids == $uids || $myuids == $value->comment_userid)
				<div class="btn-group pull-right">
                    	<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        	<i class="fa fa-chevron-down" aria-hidden="true"></i>
                    	</a>
                    	<ul class="dropdown-menu">
                    	<div class="arrow" style="left: 50%;"></div>
                    	
                    	@if(($value->comment_userid == $postvalues->user_id && $myuids == $value->comment_userid) || ($myuids == $value->comment_userid && $datasss == $value->comment_userid) || $myuids == $value->comment_userid)
                   		<li>
			                <a href="javascript:void(0);" onclick="editcommentfunction(this)" id="editcomment" rel="editcomment-{{$value->id}}"><i class="fa fa-pencil" aria-hidden="true"></i>  Edit</a>
			            </li>
			            @endif
					   	<li>
			                 <a href="javascript:void(0);" onclick="deletecomment(this)" id="deletecomment-{{$value->id}}-{{$postvalues->id}}"><i class="fa fa-trash" aria-hidden="true"></i>  Delete</a>
			            </li>
                	</ul>
            		</div>
				@endif
				@foreach($userinfo as $userdetail)
				<figure class="dd-comment-avater-holder">
					@if($userdetail->avatar=='')     
					<img src="/css/assets/img/profile-image.jpg" alt="" width="30">
					@else
					<img src="{{ $userdetail->avatar }}" alt="Image" class="img-responsive media-object" width='30'>
					@endif   
				</figure>
				<div  class="comment-info" style="">
					<a href={{url('/search')}}/{{$userdetail->id}}/{{$userdetail->name}}> {{$userdetail->name}}</a><br>  
					<span id="myeditcomment{{$value->id}}">{{$value->comment}}   </span>


					<br>
					@php($countlikepost=$data['countlike']->TotalLikeByPostId(['content_id'=>$value->id,'type'=>1])) 
					@php($mylikecomments=$data['countlike']->TotalLikeByPostId(['content_id'=>$value->id,'user_id'=>$myuids,'type'=>1]))
					<div class="dd-comment-footer fw">
						<ul>
							<li><a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-{{$value->id}}"  data-like='{"p_id":"<?php echo $value->id ?>","l_status":"1","p_uid":"<?php echo $uids ?>"}'   @if($mylikecomments==1) class="orangecolor" @endif><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>{{$countlikepost}} Like</a></li>
							<li><a href="javascript:void(0);"  class="comment" id="mainrepy-{{$value->id}}"  onclick="rhide(this)"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;@php($replycount= $timelinePostController->replycount(['commetid'=>$value->id]))
								
								{{$replycount}} Reply</a>
							</li>
							<li>
								<?php $commentdate=$value->updated_at;
									$cdate1 = date('Y-m-d H:i:s', strtotime($commentdate));
									$cdate2 = date("Y-m-d H:i:s");
									$cdiff = abs(strtotime($cdate2) - strtotime($cdate1));
									
									$cyears = floor($cdiff / (365*60*60*24));
									$cmonths = floor(($cdiff - $cyears * 365*60*60*24) / (30*60*60*24));
									$cdays = floor(($cdiff - $cyears * 365*60*60*24 - $cmonths*30*60*60*24)/ (60*60*24));
									$ctimes=abs(strtotime($cdate2)-strtotime($cdate1));
									$cgettimepost = date('h:i A', strtotime($cdate1));
									if($cdays==0){
									    $cdays=$ctimes;
									    if($ctimes<60)
									    {
									        $cdays=$ctimes." seconds ago";
									    }elseif($ctimes<3600){
									        $checkminuts=floor($ctimes/60);
									        if($checkminuts<59){
									                $cdays=$checkminuts."  minutes ago";
									        }else{
									        $cdays="about an hours afo";
									       }
									
									    }else{
									        $checkminuts=floor($ctimes/3600);
									        $cdays=$checkminuts." hrs ago";
									    }
									    
									}elseif($cdays==1) {
									       $cdays='Yesterday at'." ".$cgettimepost;
									}elseif($cdays>1){
									        if($cyears==0){
									        $cdays=date('d M', strtotime($cdate1))." at ".$cgettimepost;
									       }else{
									        $cdays=date('d-m-y h:i A', strtotime($cdate1))." at ".$cgettimepost;
									       }
									    }
									 ?>
								{!! $cdays !!}
							</li>
						</ul>
					</div>
					<div class="dd-comment-footer fw">
						<input type="hidden" value="{{$postvalues->id}}" id="Postid-of-Edited-Comment-{{$value->id}}">
			            <textarea class="form-control" post="{{$postvalues->id}}" id="editcomment-{{$value->id}}" onclick="this.select()" onKeyDown="if(event.keyCode==13)  editcomments(this);" placeholder="Write a Reply Here..." rows="1" name="comment" style="display:none">{{$value->comment}}</textarea>
			        </div>
					<br> <br>
					<!-- REPLEIS SECTOION OF COMMENT -->
					<div id="replybox-{{$value->id}}" style="display:none" >
						@foreach($comments as $replies)
						@foreach($replies as $allreplies)
						@if($value->id == $allreplies->content_id)
						@php($countlikereply=$data['countlike']->TotalLikeByPostId(['content_id'=>$allreplies->id,'type'=>1]))
						<div class="replies-section" id="wholereply-{{$allreplies->id}}">
							@php ($replyuserinfo = $userpic->getUserData(['id'=>$allreplies->comment_userid]))
							@php($showpostedTimeline=$data['otherUserTimelinePosted']->getUserDataTimelinePosted($postvalues->id))
							@if(!empty($showpostedTimeline))
								@php($datasss2 ='')
								@foreach($showpostedTimeline as $getpostid)
									@php($datasss2 =$getpostid->posted_on_user_id)
								@endforeach
							@endif
							
							<div class="row" >

									@if($myuids == $uids || $myuids == $allreplies->comment_userid || $datasss2==$myuids )

									<div class="btn-group pull-right">
					                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
					                    </a>
					                    <ul class="dropdown-menu">
					                        <div class="arrow" style="left: 50%;"></div>
					                        
					                        @if(($value->comment_userid == $postvalues->user_id && $myuids == $allreplies->comment_userid) || $myuids == $allreplies->comment_userid)
                   							<li>
								                <a href="javascript:void(0);"  myreplyeditid="{{$allreplies->id}}" onclick="editreplyfunction(this)" id="editreply" rel="editreply-{{$allreplies->comment}}-{{$value->id}}-{{$allreplies->id}}"><i class="fa fa-pencil" aria-hidden="true"></i>  Edit</a>
								            </li>
								            @endif
										   	<li>
								                 <a href="javascript:void(0);" onclick="deletecommentorreply(this)" id="deletereply-{{$allreplies->id}}-{{$value->id}}"><i class="fa fa-trash" aria-hidden="true"></i>  Delete</a>
								            </li>
					                    </ul>
					                </div>
								@endif



								@foreach($replyuserinfo as $replyuser)
								<figure class="dd-reply-avater-holder">
									@if($replyuser->avatar=='')     
									<img src="/css/assets/img/profile-image.jpg" alt="" width="25">
									@else
									<img src="{{ $replyuser->avatar }}" alt="Image" class="img-responsive media-object" width='25'>
									@endif   
								</figure>
								<div  class="replybox">
									<a href="{{url('/search')}}/{{$userdetail->id}}/{{$replyuser->name}}"> {{$replyuser->name}}</a><br>  
									
									<span id="myeditreply{{$allreplies->id}}" comment-main>	{{$allreplies->comment}} </span>
									

									@php($mylikecomments=$data['countlike']->TotalLikeByPostId(['content_id'=>$value->id,'user_id'=>$myuids,'type'=>1]))
									<div class="dd-comment-footer fw">
										<ul>
											<li><a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-{{$allreplies->id}}"  data-like='{"p_id":"<?php echo $allreplies->id ?>","l_status":"1","p_uid":"<?php echo $uids ?>"}' @if($mylikecomments==1) class="orangecolor" @endif><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>{{ $countlikereply }} Likes</a></li>
											<li><a href="javascript:void(0);" class="comment" class="comment" onclick="subreplyhide({{$value->id}})"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;Reply</a></li>
											<li>
												<?php $commentdate=$allreplies->updated_at;
													$cdate1 = date('Y-m-d H:i:s', strtotime($commentdate));
													$cdate2 = date("Y-m-d H:i:s");
													$cdiff = abs(strtotime($cdate2) - strtotime($cdate1));
													
													$cyears = floor($cdiff / (365*60*60*24));
													$cmonths = floor(($cdiff - $cyears * 365*60*60*24) / (30*60*60*24));
													$cdays = floor(($cdiff - $cyears * 365*60*60*24 - $cmonths*30*60*60*24)/ (60*60*24));
													$ctimes=abs(strtotime($cdate2)-strtotime($cdate1));
													$cgettimepost = date('h:i A', strtotime($cdate1));
													if($cdays==0){
													    $cdays=$ctimes;
													    if($ctimes<60)
													    {
													        $cdays=$ctimes." seconds ago";
													    }elseif($ctimes<3600){
													        $checkminuts=floor($ctimes/60);
													        if($checkminuts<59){
													                $cdays=$checkminuts."  minutes ago";
													        }else{
													        $cdays="about an hours ago";
													       }
													
													    }else{
													        $checkminuts=floor($ctimes/3600);
													        $cdays=$checkminuts." hrs";
													    }
													    
													}elseif($cdays==1) {
													       $cdays='Yesterday at'." ".$cgettimepost;
													}elseif($cdays>1){
													        if($cyears==0){
													        $cdays=date('d M', strtotime($cdate1))." at ".$cgettimepost;
													       }else{
													        $cdays=date('d-m-y h:i A', strtotime($cdate1))." at ".$cgettimepost;
													       }
													    }
													 ?>
												{!! $cdays !!}
											</li>
										</ul>
									</div>
								</div>
									<textarea  class="form-control" replyid="" post="{{$postvalues->id}}-{{$value->id}}" id="editreplytextbox-{{$allreplies->id}}" onclick="this.select()"  onKeyDown="if(event.keyCode==13)  editreply(this);"  placeholder="Write a Reply Here..." rows="1" name="comment" style="display:none"></textarea>
								
								@endforeach
							</div>
						</div>
						@endif    
						@endforeach        
						@endforeach
						<textarea  class="form-control" replyid="" post="{{$postvalues->id}}" id="{{$value->id}}" onclick="this.select()"  onKeyDown="if(event.keyCode==13)  homereply(this);"  placeholder="Write a Reply Here..." rows="1" name="comment" ></textarea>
					
					</div>

				</div>
				@endforeach 
			</div>
			@endif
			@endforeach
			@endfor   
			<p><a href="javascript:void(0);" id="loadMore-{{$postvalues->id}}" style="display:none;"> Show More..</a></p> 			
			<p><a href="#timeline-post-content{{$postvalues->id}}" id="write-comment-link-{{$postvalues->id}}" style="display:none;"> Write Comment..</a></p> 
		</div>
	</div>
</div>
