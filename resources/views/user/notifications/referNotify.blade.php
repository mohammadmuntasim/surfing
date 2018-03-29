@php($cnuser=$data['getRefer']->getReferData($notifys->post_id))
	
	@if(!empty($cnuser))
		@foreach($cnuser as $uservalue)
			
				@if($uservalue->receiver_user_id==$notifys->user_id)
				@php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->sender_user_id]))
			
			    @php($doctorInfo=$data['userdatabyid']->getUserData(['id' =>$uservalue->refer_user_id]))
				<!-- this Notification show to patient  start-->
				<figure class="dd-note-avater">
					<a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}">
						<img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt="">
					</a>
				</figure>
	            <div class="dd-note-content">
	            	<a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a> has referred you to <a href="{{url('/')}}/search/{{$doctorInfo[0]->id }}/{{$doctorInfo[0]->name }}"><strong>{{$doctorInfo[0]->name }}</strong></a>.
	                <?php $datedd=$notifys->created_at;   ?>
				@include('user.timeline.getTimes')
	            </div>
				@else
				@php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->sender_user_id]))
			
				@php($doctorInfo=$data['userdatabyid']->getUserData(['id' =>$uservalue->receiver_user_id]))

				<!-- this Notification show to patient  start-->
				<figure class="dd-note-avater">
					<a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}">
						<img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt="">
					</a>
				</figure>
				<div class="dd-note-content">
					<a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a>
					has referred you to <a href="{{url('/')}}/search/{{$doctorInfo[0]->id }}/{{$doctorInfo[0]->name }}"><strong>{{$doctorInfo[0]->name }}</strong></a>.
					
					<?php $datedd=$notifys->created_at;   ?>
				
				@include('user.timeline.getTimes')
				</div>
				
				@endif
				
				
		@endforeach
    @endif