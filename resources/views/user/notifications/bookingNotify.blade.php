 @php($cnuser=$data['appointment']->getDatabyAppointmentId($notifys->post_id))
  @php($requestusername='')
  @if(sizeof($cnuser)>0)
  @foreach($cnuser as $uservalue)
  @if($uservalue->status==0)
  

    @if($uservalue->doctor_id==Auth::user()->id)
    @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->patient_id]))
    <figure class="dd-note-avater">
      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt=""></a>
    </figure>
    <div class="dd-note-content">
      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a>
      booked your appointment on date  <a href="{{url('/appointments')}}?apdate={{$uservalue->booking_date}}"><strong>{{$uservalue->booking_date}} </strong></a> at  <strong>{{ $uservalue->booking_time}}</strong>.
      <?php $datedd=$notifys->created_at;   ?>
       <br>
      @include('user.timeline.getTimes')
       
    </div>
     
    @else
    @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->doctor_id]))
    <div class="dd-note-content">
    Your appointment has been successfully submitted to <br> <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong> {{$requestusername[0]->name }}  </strong></a>
     on date  <a href="{{url('/appointments')}}?apdate={{$uservalue->booking_date}}"><strong>{{$uservalue->booking_date}} </strong></a> at  <strong>{{ $uservalue->booking_time}}</strong>.
      <?php $datedd=$notifys->created_at;   ?><br>
    @include('user.timeline.getTimes')
  </div>
    @endif
    
  
  @elseif($uservalue->status!=0)
      @php($userid=0)
     @if($uservalue->doctor_id==$notifys->user_id)
      @php($userid=$uservalue->patient_id)
     @else
     @php($userid=$uservalue->doctor_id)
     @endif
   @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$userid]))
  <figure class="dd-note-avater">
      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt=""></a>
    </figure>
    <div class="dd-note-content">
      <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a>
      has cancelled your appointment on date  <a href="{{url('/appointments')}}?apdate={{$uservalue->booking_date}}"><strong>{{$uservalue->booking_date}} </strong></a> at  <strong>{{ $uservalue->booking_time}}</strong>.
      <?php $datedd=$notifys->created_at;   ?>
       <br>
      @include('user.timeline.getTimes')
       
    </div>
    

   @endif

  @endforeach
  @endif
                             
   
