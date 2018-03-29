
<?php 
if(!empty($data['currentUserid'])){
	$uid=$data['currentUserid'];
}
 ?>
 <style type="text/css">.dd-profile-name .dd-group-btn>ul>li {
    float: right;
}</style>
<div class="dd-profile-holder" >
	<div class="dd-cover-holder">
		<figure class="dd-cover-changer">
			<!--crop cover image start -->
			<div class="myimages" style="overflow: hidden;">
			<div class="imageBoxcover" style="display:none">
				<div class="instructionWrap">
					<div class="instructions">Drag to Reposition Cover Photo</div>
					<input type="button" id="btnZoomIncover" value="+" class="btn btn-primary btn-md" style="float: right;"  data-toggle="tooltip" data-placement="bottom" data-content="Click here to Zoon In"  title="Zoom In ">
					<input type="button" id="btnZoomOutcover" value="-" class="btn btn-primary btn-md" style="float: right;" data-toggle="tooltip" data-placement="bottom" data-content="Click here to Zoon Out" title="Zoom Out "> 
				</div>
				<div class="thumbBoxcover" style="overflow: hidden;">
					<div class="spinnercover" style="display: none">Loading...</div>
				</div>
				<div class="cropped">
				</div>
			</div>
			<!--crop cover image end -->
	<img src="{{!empty($data) ? $data['cover-image'] : '/css/assets/img/default-cover.jpg'}}" alt="surf health cover {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}" id="cover-image-individiuals">     
		</figure>
		@if(Auth::check())
		@php($uids=Auth::user()->id)
		@if(empty($data['userid']) || ($uids==$data['userid']))
		<div class="cover-edit-form">
			<div class="btn-group dd-dropdown">
				<a href="javascript:void(0);"   title="Change profile picture" id="edit-cover-icon" data-toggle="dropdown"><i class="fa fa-camera" aria-hidden="true"></i><span id="update-cover-btn-title">
				Update Cover Photo</span></a>                                
				<ul class="dropdown-menu">
					<li>
						<form action="{{url('/profile')}}" id="cover-edit-form" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}

							<input type="file" name="cover_photos" id="prof-cover-photo-file" style="visibility:hidden;">  
							        
							<a href="javascript:void(0);" id="prof-cover-photo" onclick="document.getElementById('prof-cover-photo-file').click();">choose file...</a>                                            
						</form>
					</li>
					@if($data['cover-image']!='/css/assets/img/default-cover.jpg')
					<li>
						<a href="javascript:void(0)" id="removecover" >Remove Photo... </a>
					</li>
					@endif
				</ul>

				<button type="submit" id="save-cover-pic-change" style="display:none" class="btn btn-primary">Save Change</button>
			</div>
		</div>
		@endif
		<!-- if user not logged in show sign up buttons -->
		@else
		<div class="dd-profile-navbar-holder text-left">
		<div class="dd-profile-name">
			<a href="/{{Request::path()}}">
				<h3>
					@if(!empty($data['usergeneralinfo']))
					@foreach($data['usergeneralinfo'] as   $myusersdatad)
					<!-- display role name -->
					{{  $myusersdatad->name }}
					@endforeach
					@endif
				</h3>
			</a>
		</div>
		</div>
		@endif
	
		@if(Auth::guest())
		@php($checkrole = $data['rolename']->SearchedUserRole($data['currentUserid']))
		@if($checkrole=='W' || $checkrole=='Dr.' || $checkrole=='EC' || $checkrole=='D'  || $checkrole=='H.')


		<div class="timelineLoggedOutSignUp">
			@if($data['userdatabyid']->claimProfile($data['currentUserid'])==0)
             <a  class="notregisteronprofile"  href="{{url('/email-resend-verification')}}?claim=true" role="button" id="box_reg_button">
             	<span class="uiButtonText"><i class="fa fa-unlock" aria-hidden="true"></i>  Claim your profile</span>
			</a>
             @else
			<a class="notregisteronprofile" href="<?php if(Auth::check()){ ?> {{url('/appointments')}} <?php }else{ ?> {{url('/register')}} <?php  } ?>"    role="button" id="box_reg_button">

			<span class="uiButtonText">Make Appointment</span>
			</a>
			@endif
			
		</div>
		@endif
		@endif

	</div>
	<div class="dd-profile-picture">
		<figure class="dd-display-picture ">
			@if(!empty($data['userid']))
			@foreach($data['usergeneralinfo'] as   $myusersdatad) 
							<?php $cv=explode('/', $myusersdatad->avatar);
							$paths='';
									if($cv[0]=='users'){
										$paths='/storage/';
									}else{
									$paths='';
							 	    }
									?>                
			<img src="{{$paths}}{{ isset($myusersdatad->avatar) ?  $myusersdatad->avatar : '/css/assets/img/profile-image.jpg' }}" alt="surf health profile picture {{ isset($myusersdatad->name) ?  $myusersdatad->name : '' }}" id="profile-image-individiual">
			@endforeach
			@else
<?php $cv=explode('/', Auth::user()->avatar);
$paths='';
									if($cv[0]=='users'){
										$paths='/storage/';
									}else{
									$paths='';
							 	    }?>
			<img src="{{$paths}}{{ isset(Auth::user()->avatar) ?  Auth::user()->avatar : '/css/assets/img/profile-image.jpg' }}" alt="surf health profile picture {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}" id="profile-image-individiual">                             
			@endif
		</figure>
		<div class="namebelowimage">
			<h3>
				@if(Auth::check())
				@if(empty($data['userid']))
				<!-- display role name -->
				{{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}
				@else
				@php($uids1=Auth::user()->id)
				@if($uids1==$data['userid'])
				<!-- display role name -->
				 {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}
				@else                
				@foreach($data['usergeneralinfo'] as   $myusersdatad)
				<!-- display role name -->
				 {{  $myusersdatad->name }}
				@endforeach
				@endif
				@endif
				@endif
			</h3>
		</div>
		 @if(Auth::check())
         @php($uids=Auth::user()->id)
         @if(empty($data['userid']) || ($uids==$data['userid']))
      <div class="profile-pic-edit-form">
            <form action="{{url('/profile')}}" id="profile-pic-edit-form" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="profile_photo" id="file" style="visibility:hidden;">           
                <a href="javascript:void(0);" id="prof-pic-photo" onclick="document.getElementById('file').click();"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a>
            </form>
           <!--  <button type="button" id="save-profile-pic-change" style="display:none" class="btn btn-primary">Save Change</button> -->
        </div>
        	@endif
         @endif
	</div>
	<div class="dd-profile-navbar-holder">
		@if(Auth::check())
		<div class="dd-profile-name">
			<a href="/{{Request::path()}}">
				<h3>
					@if(empty($data['userid']))
					{{isset(Auth::user()->name) ?  Auth::user()->name : '' }}
					@else
					@php($uids1=Auth::user()->id)
					@if($uids1==$data['userid'])
                       {{ isset(Auth::user()->name) ?  Auth::user()->name : '' }}
					@else                
					@foreach($data['usergeneralinfo'] as   $myusersdatad)
					<!-- display role name -->
					 {{  $myusersdatad->name }}
					@endforeach
					@endif
					@endif
				</h3>
			</a>
			<div class="dd-group-btn">
				<ul>
				@if($data['userdatabyid']->claimProfile($data['currentUserid'])==0)
	            <!--  <li><a  href="{{url('/email-resend-verification')}}?claim=true">
	             	<i class="fa fa-unlock" aria-hidden="true"></i> Claim your profile
	             </a>
				</li> -->
	             @else
				
					@if(!empty($data['userid']))
					@php($showfollow='Follow')
					@php($findfollow= $data['userfollow']->CountFollowing(['follow_user_id'=>$data['userid'],'follower_user_id'=>Auth::user()->id]))
					@if($findfollow==1)
					@php($showfollow='Follower')
					@endif
					@php($findfollow1= $data['userfollow']->CountFollowing(['follower_user_id'=>$data['userid'],'follow_user_id'=>Auth::user()->id]))
					@if($findfollow1==1)
					@php($showfollow='Following')
					@endif
					<!-- if user login then this button shows -->
					@if(Auth::check())
						@php($checkrole = $data['rolename']->SearchedUserRole($data['currentUserid']))
						@if($checkrole=='W' || $checkrole=='Dr.' || $checkrole=='EC' || $checkrole=='D' || $checkrole=='H.')
						<li><a href="javascript:void(0);" data-toggle="modal" data-target="#refer-id" onclick="connectionlist(this)">Referring Network</a></li>
						@endif
					<!-- <li><a href="javascript:void(0);" onclick="followusers(this)" id="follows" data-followuser="{{$data['userid']}}">{{$showfollow}}</a></li> -->
					@endif
					@endif
					@if(!empty($data['userid']))
						@if(Auth::check())
						@php($uids=Auth::user()->id)                 
					<li>
						
							@if(!empty($data['username']))
							@php($urlnames ='')
							@foreach($data['username'] as $usernames)
							@php($urlnames = str_replace(' ', '-',$usernames->name))
							@endforeach
							<form class="form-horizontal" id="senderrequest" role="form" method="POST" action="{{ url('/search') }}/{{ $data['userid'] }}/{{ $urlnames }}">
								{{ csrf_field() }}
								<input type="text" name="receiverid" id="receiverid" value="{{ $data['userid'] }}">
								
								@if(sizeof($data['getConnectedornot'])==0)                            
			
									<a href="javascript:void(0);" id="makeconnection-{{ $data['userid'] }}" class="requestbutton"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i> Make Connection</a>
									
                                   
                                     <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                        </ul>
                                    </div> 
                                     
                                   
                                   
								@else
								
								@foreach($data['getConnectedornot'] as $frndrequest)
								@if($frndrequest->status=='0')
								@if($frndrequest->connect_user_id==$uids)

									<div class="dropdown  sentrequest" id="removeconnection-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove1-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                             
                                        </ul>
                                    </div>
									    
                                    <a href="javascript:void(0);" id="makeconnection-{{ $data['userid'] }}" class="requestbutton sentrequest"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i> Make Connection</a>
									
                                   
                                     <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                        </ul>
                                    </div> 
                                     
								 	<div class="dropdown " id="confirmrequest-{{ $data['userid'] }}" >
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Respond to request
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="confirm-{{ $data['userid'] }}" onclick="requestfunction(this)">Confirm</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Delete request</a></li>  
                                        </ul>
                                    </div>

								@else
									  <a href="javascript:void(0);" id="makeconnection-{{ $data['userid'] }}" class="requestbutton sentrequest"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i> Make Connection</a>
									
                                   
                                     <div class="dropdown " id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                        </ul>
                                    </div> 
                                   
                                   



								
								@endif
								@elseif($frndrequest->status=='1')
						
                                    <div class="dropdown " id="removeconnection-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                             
                                        </ul>
                                    </div>
                                     <a href="javascript:void(0);" id="makeconnection-{{ $data['userid'] }}" class="requestbutton sentrequest"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i> Make Connection</a>
									
                                   
                                     <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                        </ul>
                                    </div> 
								@endif
								@endforeach
								@endif
								
							</form>
							@endif
					
					</li>
					@endif
					@endif
				
				@endif
				</ul>
			</div>
		</div>
		@if($data['userdatabyid']->claimProfile($data['currentUserid'])==0)
            <!--  <a  href="{{url('/email-resend-verification')}}?claim=true">
             	<span class="uiButtonText"><i class="fa fa-unlock" aria-hidden="true"></i>  Claim your profile</span>
			</a> -->
             @else
		<nav class="navbar navbar-default dd-navbar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#dd-navbar" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="dd-navbar">
				<ul class="nav navbar-nav">									
					@if(!empty($data['userid']))
						<?php $otherprofile='/?ref_app='.$data['encrypt']->encryptIt($data['userid']); ?>
					@else
					@php($otherprofile='')
					@endif
					@if(!empty($data['userid']))
					@php($checkrole = $data['rolename']->SearchedUserRole($data['userid']))
					@if($checkrole=='W' || $checkrole=='Dr.' || $checkrole=='EC' || $checkrole=='D'  || $checkrole=='H.')
					<li class="{{(Request::url() === url('/appointments')) ? 'active' : ''}}"><a href="{{url('/appointments')}}{{$otherprofile}}"><?php if(isset($_GET['ref_app'])):  echo 'Make'; elseif(!empty($data['userid'] )): echo 'Make'; else: echo 'My'; endif;?> Appointments</a></li>					
					@endif
					@else
					@if(Auth::check())
					@php($checkrole = $data['rolename']->SearchedUserRole($data['currentUserid']))
					@if($checkrole=='W' || $checkrole=='Dr.' || $checkrole=='EC' || $checkrole=='D'  || $checkrole=='H.')
					<li class="{{(Request::url() === url('/appointments')) ? 'active' : ''}}"><a href="{{url('/appointments')}}{{$otherprofile}}"><?php if(isset($_GET['ref_app'])):  echo 'Make'; elseif(!empty($data['userid'] )): echo 'Make'; else: echo 'My'; endif;?> Appointments</a></li>					
					@else
					<li class="{{(Request::url() === url('/appointments')) ? 'active' : ''}}"><a href="{{url('/appointments')}}{{$otherprofile}}"> My Appointments</a></li>
					@endif
					@endif
					@endif
					<li class="{{(Request::url() === url('/#.')) ? 'active' : ''}}"><a href="#">Send a Message</a></li>
					<li class="{{(Request::url() === url('/connections')) ? 'active' : ''}}"><a href="{{url('/connections')}}{{$otherprofile}}">Connections</a></li>
					<li class="{{(Request::url() === url('/photos')) ? 'active' : ''}}"><a href="{{url('/photos')}}{{$otherprofile}}">Photos</a></li>
					
					
					<li class="{{(Request::url() === url('/user/discountpage')) ? 'active' : ''}}"><a href="{{url('/user/discountpage')}}{{$otherprofile}}">Discount Card</a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
		 @endif
		@endif
	</div>
</div>

<!-- Cropped image profile start -->
<div class="container" id="crop-avatar">
	<!-- Cropping modal -->
	<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-md text-center">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="avatar-modal-label">Change Profile Picture</h4>
				</div>
				<div class="modal-body">
					<div class="avatar-body">
						<div class="row avatar-btns">
							<div class="col-md-12">
								<div class="myimage">
									<div class="imageBox" style="display:none">
										<div class="thumbBox"></div>
										<div class="spinner" style="display: none">Loading...</div>
									</div>
									<div class="cropped">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer myimage">
					<!-- Upload image and data -->
					<!-- <div class=" col-md-3">
						<span class="select-wrapper " data-toggle="tooltip" data-placement="bottom" data-content="Choose profile from here" title="Upload Profile Picture">
						<input type="file" id="file" style="float:left; width: 250px " >                       
						</span>
					</div> -->
					<div class="col-md-3 col-md-offset-3">
						<input type="button" id="btnZoomIn" value="+" class="btn btn-primary btn-md" style="float: right"  data-toggle="tooltip" data-placement="bottom" data-content="Click here to Zoon In"  title="Zoom In ">
						<input type="button" id="btnZoomOut" value="-" class="btn btn-primary btn-md" style="float: right" data-toggle="tooltip" data-placement="bottom" data-content="Click here to Zoon Out" title="Zoom Out "> 
					</div>
					<div class="profile-pic-edit-forms col-md-6">
						<form action="{{url('/profile')}}" id="profile-pic-edit-forms" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<!--  <input type="file" name="profile_photodd" id="prof-pic-photo-file"> -->
							<textarea name="profilepic" id="profilepic"></textarea>
							<button type="button" class="btn btn-primary btn-md avatar-save" id="cancelprofile">Cancel</button>  <button type="submit" id="btnCrop" class="btn btn-primary btn-md avatar-save">Save Change</button>         
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.modal -->
</div>
<!-- Cropped image profile end -->