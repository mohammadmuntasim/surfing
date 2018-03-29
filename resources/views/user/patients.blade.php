@if(!empty($data['showpatients']) || !empty($data['showbooking']))
    <ul class="nav nav-tabs appointmentbooking" role="tablist">
        @if(sizeof($data['showpatients'])>0)
            <li role="presentation"  data-toggle="tooltip" title="Appointment"  class="active"><a href="#book1" aria-controls="home" role="tab" data-toggle="tab">Patients</a></li>
        @endif
        @if(sizeof($data['showbooking'])>0) 
            <li role="presentation"  data-toggle="tooltip" title="Bookings"  @if(sizeof($data['showpatients'])==0) class="active" @endif><a href="#book2" aria-controls="home" role="tab" data-toggle="tab">My Booking</a></li>
        @endif
    </ul>
                   
    <div class="tab-content appointment-tab-content">
        @if(sizeof($data['showpatients'])>0)
            <div role="tabpanel" class="tab-pane active " id="book1">
                <form action="{{url('/appointments')}}" class="canceldoc" id="cancel-form-patient" method="post" data-toggle="validator" onsubmit="return checklistappointmentvalid()">
                    {{ csrf_field() }}

                    <input type="hidden" class="form-control" value="{{ app('request')->input('checkdate') }}"  type="text" name="checkdate" > 
                    <div class="cancel-reason-box">
                        <div class="form-group col-sm-12 col-md-12 pr">
                            <label for="cancelmsg" class="control-label">Cancellation Message/Reason For Cancellation</label>                                    
                            <textarea name="cancelmsg"  id="cancelmsg" class="form-control" placehoder="Cancellation Message/Reason for Cancelling"></textarea>
                            <span id='error-apppointmentlist-msg' class="alert alert-info" style="display:none;">Please Enter Cancellation Reason.</span>

                        </div>
                        
                        <div class="pull-right col-md-3"> 
                            <button class="btn btn-default "  name="canceldoc" id="mybutton" type="submit" >Submit</button> 
                        </div>
                        <div class="pull-right col-md-1"> 
                            <button class="btn btn-default" id="back-booking-btn" onclick="rejectPatientCancelBookingProcess()" >Back</button> 
                        </div>
                    </div>
                    <div class="cancel-booking-error-section">
                        <div class="col-md-8 pull-left" id="cancel-user-not-select-error"><p class="alert alert-danger">Please select bookings to cancel.</p></div>
                        <div class="pull-right col-md-4"> 
                            <button class="btn btn-default " id="cancel-booking-brn" type="button" onclick="checkPatientBookingSelection()">Cancel Booking</button> 
                        </div>
                    </div>
                    <div class="dd-grid-2-column dd-grid-style-two booking-list-section">                        
                        @if(!empty($data['showpatients']))
                            @php($i=0)
                            @foreach($data['showpatients'] as $showappointments)
                                @php ($userprofilepicreview = $data['userdatabyid']->getUserData(['id' => $showappointments->patient_id]) )
                                <!-- user info foreach start-->
                                @foreach($userprofilepicreview as $userMetaDatapicreview)      
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="dd-grid-item @if($showappointments->status!=0) booking-cancelled @endif">
                                            @if($showappointments->status!=0)
                                                <img src="/css/assets/img/cancelled-label.png" class="cancelled-label-img">
                                            @endif
                                            <figure class=" col-md-1 col-sm-1 col-xs-12 pad-0 appointment-prof-info">
                                                @if($showappointments->status==0)
                                                    <input type="checkbox" id="myCheckbox{{$i}}" name="cancelbydoc[]"  value="{{$showappointments->id}}" title="Cancel"/>
                                                @endif
                                                <a  href="{{url('/search')}}/{{ $showappointments->patient_id}}/{{ $showappointments->patient_full_name}}">
                                                    <div class="appointment-booked-prof">
                                                        <img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}" title="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}">
                                                        <p>{{ $showappointments->patient_full_name}}</p>
                                                    </div>
                                                </a>
                                                @if($showappointments->status!=0)
                                                    <label class="cancel-label">Cancelled</label>
                                                @endif
                                            </figure>
                                            <div class=" col-md-11 col-sm-11 col-xs-12">
                                                <ul class="list-group">
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-calendar" aria-hidden="true"></i> {{$showappointments->patient_dob}} </small>
                                                    </li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-phone" aria-hidden="true"></i> {{$showappointments->phone_number}} </small>
                                                    </li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-envelope" aria-hidden="true"></i> {{$showappointments->patient_email}} </small>
                                                    </li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small>
                                                        @if($showappointments->patient_type='new')
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        @else
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                        @endif
                                                        {{ $showappointments->patient_type}}</small>
                                                    </li>
                                                </ul>
                                                <ul class="list-group">
                                                      <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Date Of Booking</b></li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"> {{$showappointments->created_at }}
                                                    </li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Appointment Date and Time</b></li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->booking_date}}  {{ $showappointments->booking_time}}</li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Reason for Visit</b></li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->reason_for_visit}}</li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Gender</b></li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_gender}}</li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Insurance Provider</b>    </li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_insurance_provider}}</li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Appointment Status</b> </li>
                                                    <li class="list-group-item col-md-3 col-sm-3 col-xs-12">@if($showappointments->status==1) Cancelled By Patient @elseif($showappointments->status==2)Cancelled By  Doctor @else Processing @endif</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @php($i++)
                            @endforeach
                            @else
                            <div class="text-center"> No Booking Founds</div>
                        @endif
                    </div>
                </form>
            </div>
        @endif
        @if(sizeof($data['showbooking'])>0) 
            <div role="tabpanel" class="tab-pane @if(sizeof($data['showpatients'])==0) active @endif " id="book2">
                <form action="{{url('/appointments')}}" class="canceldoc" id="cancel-form-doctor" method="post" data-toggle="validator" onsubmit="return checklistappointmentvalid()">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" value="{{ app('request')->input('checkdate') }}"  type="text" name="checkdate" > 
                    <div class="cancel-reason-box">
                        <div class="form-group col-sm-12 col-md-12 pr">
                            <label for="cancelmsg" class="control-label">Cancellation Message/Reason For Cancellation</label>                                    
                            <textarea name="cancelmsg"  id="cancelmsg" class="form-control" placehoder="Cancellation Message/Reason for Cancelling"></textarea>
                            <span id='error-apppointmentlist-msg'  class="alert alert-info" style="display:none">Please Enter Cancellation Reason.</span>

                        </div>
                        
                        <div class="pull-right col-md-3"> 
                            <button class="btn btn-default "  name="cancelbypat" id="mybutton" type="submit" >Submit</button> 
                        </div>
                        <div class="pull-right col-md-1"> 
                            <button class="btn btn-default" id="back-booking-btn" onclick="rejectDoctorCancelBookingProcess()" >Back</button> 
                        </div>
                    </div>
                    <div class="cancel-booking-error-section">
                        <div class="col-md-8 pull-left" id="cancel-user-not-select-error"><p class="alert alert-danger">Please select bookings to cancel.</p></div>
                        <div class="pull-right col-md-4"> 
                            <button class="btn btn-default " id="cancel-booking-brn" type="button" onclick="checkDoctorBookingSelection()">Cancel Booking</button> 
                        </div>
                    </div>
                    
                    <div class="dd-grid-2-column dd-grid-style-two booking-list-section">
                        @if(!empty($data['showbooking']))
                        @php($i=0)
                        @foreach($data['showbooking'] as $showappointments)
                        @php ($userprofilepicreview = $data['userdatabyid']->getUserData(['id' => $showappointments->doctor_id]) )
                        <!-- user info foreach start-->
                        @foreach($userprofilepicreview as $userMetaDatapicreview)      
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="dd-grid-item @if($showappointments->status!=0) booking-cancelled @endif">
                                @if($showappointments->status!=0)
                                    <img src="/css/assets/img/cancelled-label.png" class="cancelled-label-img">
                                @endif
                                <figure class=" col-md-1 col-sm-1 col-xs-12 pad-0 appointment-prof-info">
                                    @if($showappointments->status==0)
                                        <input type="checkbox" id="myCheckboxp{{$i}}" name="cancelbypat[]"  value="{{$showappointments->id}}" title="Cancel"/>
                                    @endif
                                    <a  href="{{url('/search')}}/{{ $showappointments->patient_id}}/{{ $showappointments->patient_full_name}}">
                                        <div class="appointment-booked-prof">
                                            <img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}" title="{{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}">
                                            <p>{{ $userMetaDatapicreview->name}}</p>
                                        </div>
                                    </a>                                    
                                    @if($showappointments->status!=0)
                                        <label class="cancel-label">Cancelled</label>
                                    @endif
                                </figure>
                                <div class=" col-md-11 col-sm-11 col-xs-12">
                                    <ul class="list-group">
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-calendar" aria-hidden="true"></i> {{$showappointments->patient_dob}} </small>
                                        </li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-phone" aria-hidden="true"></i> {{$showappointments->phone_number}} </small>
                                        </li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small><i class="fa fa-envelope" aria-hidden="true"></i> {{$showappointments->patient_email}} </small>
                                        </li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><small>
                                            @if($showappointments->patient_type='new')
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            @else
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                            @endif
                                            {{ $showappointments->patient_type}}</small>
                                        </li>
                                    </ul>
                                    <ul class="list-group">
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Date Of Booking</b></li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"> {{$showappointments->created_at }}
                                                    </li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Appointment Date and Time</b></li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->booking_date}}  {{ $showappointments->booking_time}}</li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Reason for Visit</b></li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->reason_for_visit}}</li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Gender</b></li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_gender}}</li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Insurance Provider</b></li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12">{{ $showappointments->patient_insurance_provider}}</li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"><b>Appointment Status</b></li>
                                        <li class="list-group-item col-md-3 col-sm-3 col-xs-12"> @if($showappointments->status==1)<span class="cancel-label"> Cancelled By Patient</span> @elseif($showappointments->status==2)<span class="cancel-label"> Cancelled By  Doctor </span> @else Processing @endif</li>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @php($i++)
                        @endforeach
                        @else
                        <div class="text-center"> No Booking Founds</div>
                        @endif
                    </div>
                </form>
            </div> 
         @endif
    </div>
 @endif