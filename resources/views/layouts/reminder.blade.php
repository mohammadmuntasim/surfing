@if(sizeof($data['appointmentReminder'])>0)

	<div class="alert alert-success " id="bookingNotify">
	    <a href="javascript:void(0);" class="close" data-dismiss="alert"  title="close">×</a>
	    <strong>Reminder!</strong>
	    <!--current date -->
	    @php($currentdate=date('Y-m-d H:i:s'))
	    @php($lastdate=0)
	   
	    <!--all appointments -->

	    <ul class="dd-notification-list dd-reminder ">
		    @foreach($data['appointmentReminder'] as $uservalue )
		   
		    	<?php 
$lastdate=$uservalue->booking_date;
$time = strtotime($uservalue->booking_date.' '.$uservalue->booking_time);
$currentTime = Carbon\Carbon::now();
$newformat = date('Y-m-d H:i:s',$time);
$finishTime = Carbon\Carbon::parse($newformat);
$differences=$finishTime->diffForHumans($currentTime);
$getvalue=explode(' ', $differences);
$checked=0;
		    	?>
		    	@if($getvalue[0]>0  && $getvalue[2]=='after' && ($getvalue[1]=='day' || $getvalue[1]=='hours'))
		    	 @php($checked=1)
		    	 <li class="dd-note-list"> 
		    	@if($uservalue->doctor_id==Auth::user()->id)
				    @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->patient_id]))
				    <figure class="dd-note-avater">
				      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt=""></a>
				    </figure>
				    <div class="dd-note-content">
				      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a>
				      this is a reminder you have an Appointment on  <a href="{{url('/appointments')}}?apdate={{$uservalue->booking_date}}"><strong>{{$uservalue->booking_date}} </strong></a> at  <strong>{{ $uservalue->booking_time}}</strong>.
				       
				    </div>
				     
				@else
				@php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->doctor_id]))
				    @if($getvalue[1]=='hours')
				    <div class="dd-note-content">
				    	Hello! This is a reminder you have an Appointment with
				      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}" data-toggle="popover" data-trigger="hover" data-placement="top" data-html="true" title="Popover Header" data-content='<figure class="dd-note-avater"><a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : "/css/assets/img/default-avater.png" }}" alt=""></a></figure>'><strong>{{$requestusername[0]->name }}</strong></a>
				       on   <a href="{{url('/appointments')}}?apdate={{$uservalue->booking_date}}"><strong>{{$uservalue->booking_date}} </strong></a> at  <strong>{{ $uservalue->booking_time}}</strong>.
				      
				       
				    </div>
				    @else
				    <div class="dd-note-content">
				    	Hello! your next appointment with
				      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}" data-toggle="popover" data-trigger="hover" data-placement="top" data-html="true" title="Popover Header" data-content='<figure class="dd-note-avater"><a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : "/css/assets/img/default-avater.png" }}" alt=""></a></figure>'><strong>{{$requestusername[0]->name }}</strong></a>
				       is on  <a href="{{url('/appointments')}}?apdate={{$uservalue->booking_date}}"><strong>{{$uservalue->booking_date}} </strong></a> at  <strong>{{ $uservalue->booking_time}}</strong>.
				      
				       
				    </div>
				    @endif
				    

				    
				@endif
				</li>
				@endif

		    @endforeach
		    <!--view more add button if record have more reminder start-->
				
				@if(sizeof($data['appointmentReminder'])>1 && $checked==1)
					<li class="dd-note-list text-center"><a href="{{url('/appointments')}}/{{$lastdate}}">view all</a> </li>
				@endif
			<!--view more add button if record have more reminder start-->
	    </ul>
	</div>
	@if($checked==1)
	<a href="javascript:void(0);" id="reminder">
	   <div class="ribbon-content flash">
		    <div class="ribbon base"><span>Reminder !</span></div>
	   </div>
    </a>
    @endif
@endif
