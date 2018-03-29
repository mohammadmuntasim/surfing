<style type="text/css">

/* Switch button */
.btn-default.btn-on.active{background-color: #5BB75B;color: white;}
.btn-default.btn-off.active{background-color: #DA4F49;color: white;}
 label.btn.btn-default {
    padding: 6px 5px;
    border-radius: 4px;
}
.profilestime{padding: 10px 15px;}

</style>
 <div class="fudugo-tab-content {{ app('request')->input('tab') == 'availability' ? 'active' : '' }}">
    <div class="col-md-12 col-sm-12">
    <form action="{{url('/profile/edit?tab=p-exp')}}" id="timeslot"  class="profile-edit-form" method="post" >
            {{ csrf_field() }}
            <input type="hidden" name="patient" value = "5">
     
              @if(sizeof($myavali)>0)
      <h3 class="margin-top-0px">Current Availability Schedule</h3>
          <div class="avalaiblity">
              
              @foreach($myavali as $valueavail)
                 <div  class="avaails col-md-4"><label class="title">{{$valueavail->opening_days}}              </label>

                  <div class="btn-group" id="{{$valueavail->opening_days}}-{{$valueavail->id}}" data-toggle="buttons">
                        <label class="btn btn-default btn-on active" id="your-{{$valueavail->id}}" onclick="availableTime(this);">
                        <input type="radio" value="0" name="multifeatured[]" checked="checked">Available</label>
                        <label class="btn btn-default btn-off" id="my-{{$valueavail->id}}" onclick="notAvailable(this);">
                        <input type="radio" value="{{$valueavail->id}}"  name="multifeatured[]">Not Available</label>
                  </div>


            </div>
            <div  class="availtime col-md-8" >
                   <div id="availtime-{{$valueavail->id}}">
                <ul class="availtimes">
                <?php 
                $valtime=unserialize($valueavail->opening_time);
                for ($i=0; $i <sizeof($valtime); $i++) { 
                 
                    echo '<li class="alert alert-success">'.$valtime[$i].'</li>';
                 
                }
                ?>
                </ul>
                 </div>
                <div class="notavail-{{$valueavail->id}}" style="display:none">
                  <div class="alert  alert-danger profilestime" role="alert">
                      
                      <strong>Warning!</strong> Please click to save button to update records
                     
                          
                 </div>
              </div>

              </div>
              
              @endforeach
             
           
          </div>
           @endif
             <h2 class="margin-top-0px">Update Availability Schedule</h2>
      <p>Fill out the form below to update your availability schedule</p>
      <div class="update-profile-form update-forms  bg-white border-radius-5">
        <div class="padding-30px-20px clearfix availablity_container">
          
           

            <div class="row margin-0px day_rows" data-day="1" data-day-title="Monday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Monday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Monday">
            <select class="form-control available_times selectpicker" name="timemonday[]" multiple="" data-actions-box="true"  data-day="1" data-day-title="Monday" data-live-search="true" tabindex="-98">
                  <option value="" disabled>Not Selected</option>
                  
                  <option value="09:00 AM">09:00 AM</option>
                  <option value="09:15 AM">09:15 AM</option>
                  <option value="09:30 AM">09:30 AM</option>
                  <option value="09:45 AM">09:45 AM</option>
                  <option value="10:00 AM">10:00 AM</option>
                  <option value="10:15 AM">10:15 AM</option>
                  <option value="10:30 AM">10:30 AM</option>
                  <option value="10:45 AM">10:45 AM</option>
                  <option value="11:00 AM">11:00 AM</option>
                  <option value="11:15 AM">11:15 AM</option>
                  <option value="11:30 AM">11:30 AM</option>
                  <option value="11:45 AM">11:45 AM</option>
                  <option value="12:00 PM">12:00 PM</option>
                  <option value="12:15 PM">12:15 PM</option>
                  <option value="12:30 PM">12:30 PM</option>
                  <option value="12:45 PM">12:45 PM</option>
                  <option value="01:00 PM">01:00 PM</option>
                  <option value="01:15 PM">01:15 PM</option>
                  <option value="01:30 PM">01:30 PM</option>
                  <option value="01:45 PM">01:45 PM</option>
                  <option value="02:00 PM">02:00 PM</option>
                  <option value="02:15 PM">02:15 PM</option>
                  <option value="02:30 PM">02:30 PM</option>
                  <option value="02:45 PM">02:45 PM</option>
                  <option value="03:00 PM">03:00 PM</option>
                  <option value="03:15 PM">03:15 PM</option>
                  <option value="03:30 PM">03:30 PM</option>
                  <option value="03:45 PM">03:45 PM</option>
                  <option value="04:00 PM">04:00 PM</option>
                  <option value="04:15 PM">04:15 PM</option>
                  <option value="04:30 PM">04:30 PM</option>
                  <option value="04:45 PM">04:45 PM</option>
                  <option value="05:00 PM">05:00 PM</option>
                  <option value="05:15 PM">05:15 PM</option>
                  <option value="05:30 PM">05:30 PM</option>
                  <option value="05:45 PM">05:45 PM</option>
                  <option value="06:00 PM">06:00 PM</option>
                  <option value="06:15 PM">06:15 PM</option>
                  <option value="06:30 PM">06:30 PM</option>
                  <option value="06:45 PM">06:45 PM</option>
                  <option value="07:00 PM">07:00 PM</option>
                  <option value="07:15 PM">07:15 PM</option>
                  <option value="07:30 PM">07:30 PM</option>
                  <option value="07:45 PM">07:45 PM</option>
                  <option value="08:00 PM">08:00 PM</option>
                  <option value="08:15 PM">08:15 PM</option>
                  <option value="08:30 PM">08:30 PM</option>
                  <option value="08:45 PM">08:45 PM</option>
                  <option value="09:00 PM">09:00 PM</option>
                  <option value="09:15 PM">09:15 PM</option>
                  <option value="09:30 PM">09:30 PM</option>
                  <option value="09:45 PM">09:45 PM</option>
                  <option value="10:00 PM">10:00 PM</option>
                  <option value="10:15 PM">10:15 PM</option>
                  <option value="10:30 PM">10:30 PM</option>
                  <option value="10:45 PM">10:45 PM</option>
                  <option value="11:00 PM">11:00 PM</option>
                  <option value="11:15 PM">11:15 PM</option>
                  <option value="11:30 PM">11:30 PM</option>
            </select>

            </div>
            </div>

                  
            </div>
            </div>
            </div>
            <div class="row margin-0px day_rows" data-day="2" data-day-title="Tuesday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Tuesday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Tuesday">
            <select class="form-control available_times selectpicker" name="timetuesday[]" multiple="" data-actions-box="true" data-day="2" data-day-title="Tuesday" data-live-search="true" tabindex="-98">
            <option value="" disabled>Not Selected</option>
            
            <option value="09:00 AM">09:00 AM</option>
            <option value="09:15 AM">09:15 AM</option>
            <option value="09:30 AM">09:30 AM</option>
            <option value="09:45 AM">09:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="01:15 PM">01:15 PM</option>
            <option value="01:30 PM">01:30 PM</option>
            <option value="01:45 PM">01:45 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="02:15 PM">02:15 PM</option>
            <option value="02:30 PM">02:30 PM</option>
            <option value="02:45 PM">02:45 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="03:15 PM">03:15 PM</option>
            <option value="03:30 PM">03:30 PM</option>
            <option value="03:45 PM">03:45 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="04:15 PM">04:15 PM</option>
            <option value="04:30 PM">04:30 PM</option>
            <option value="04:45 PM">04:45 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="05:15 PM">05:15 PM</option>
            <option value="05:30 PM">05:30 PM</option>
            <option value="05:45 PM">05:45 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            <option value="06:15 PM">06:15 PM</option>
            <option value="06:30 PM">06:30 PM</option>
            <option value="06:45 PM">06:45 PM</option>
            <option value="07:00 PM">07:00 PM</option>
            <option value="07:15 PM">07:15 PM</option>
            <option value="07:30 PM">07:30 PM</option>
            <option value="07:45 PM">07:45 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:15 PM">08:15 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="08:45 PM">08:45 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="09:15 PM">09:15 PM</option>
            <option value="09:30 PM">09:30 PM</option>
            <option value="09:45 PM">09:45 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:15 PM">10:15 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="10:45 PM">10:45 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:15 PM">11:15 PM</option>
            <option value="11:30 PM">11:30 PM</option>
            </select>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="row margin-0px day_rows" data-day="3" data-day-title="Wednesday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Wednesday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Wednesday">
            <select class="form-control available_times selectpicker" name="timewednesday[]" multiple="" data-actions-box="true" data-day="3" data-day-title="Wednesday" data-live-search="true" tabindex="-98">
            <option value="" disabled>Not Selected</option>
            
            <option value="09:00 AM">09:00 AM</option>
            <option value="09:15 AM">09:15 AM</option>
            <option value="09:30 AM">09:30 AM</option>
            <option value="09:45 AM">09:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="01:15 PM">01:15 PM</option>
            <option value="01:30 PM">01:30 PM</option>
            <option value="01:45 PM">01:45 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="02:15 PM">02:15 PM</option>
            <option value="02:30 PM">02:30 PM</option>
            <option value="02:45 PM">02:45 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="03:15 PM">03:15 PM</option>
            <option value="03:30 PM">03:30 PM</option>
            <option value="03:45 PM">03:45 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="04:15 PM">04:15 PM</option>
            <option value="04:30 PM">04:30 PM</option>
            <option value="04:45 PM">04:45 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="05:15 PM">05:15 PM</option>
            <option value="05:30 PM">05:30 PM</option>
            <option value="05:45 PM">05:45 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            <option value="06:15 PM">06:15 PM</option>
            <option value="06:30 PM">06:30 PM</option>
            <option value="06:45 PM">06:45 PM</option>
            <option value="07:00 PM">07:00 PM</option>
            <option value="07:15 PM">07:15 PM</option>
            <option value="07:30 PM">07:30 PM</option>
            <option value="07:45 PM">07:45 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:15 PM">08:15 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="08:45 PM">08:45 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="09:15 PM">09:15 PM</option>
            <option value="09:30 PM">09:30 PM</option>
            <option value="09:45 PM">09:45 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:15 PM">10:15 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="10:45 PM">10:45 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:15 PM">11:15 PM</option>
            <option value="11:30 PM">11:30 PM</option>
            </select>
            </div>
            </div>
            </div>
            </div>
            </div>

            <div class="divider3 form-row-divider"></div>
            <div class="row margin-0px day_rows"  data-day="4" data-day-title="Thursday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Thursday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Thursday">
            <select class="form-control available_times selectpicker" name="timethursday[]" multiple="" data-actions-box="true" data-day="4" data-day-title="Thursday" data-live-search="true" tabindex="-98">
            <option value="" disabled>Not Selected</option>
            
            <option value="09:00 AM">09:00 AM</option>
            <option value="09:15 AM">09:15 AM</option>
            <option value="09:30 AM">09:30 AM</option>
            <option value="09:45 AM">09:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="01:15 PM">01:15 PM</option>
            <option value="01:30 PM">01:30 PM</option>
            <option value="01:45 PM">01:45 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="02:15 PM">02:15 PM</option>
            <option value="02:30 PM">02:30 PM</option>
            <option value="02:45 PM">02:45 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="03:15 PM">03:15 PM</option>
            <option value="03:30 PM">03:30 PM</option>
            <option value="03:45 PM">03:45 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="04:15 PM">04:15 PM</option>
            <option value="04:30 PM">04:30 PM</option>
            <option value="04:45 PM">04:45 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="05:15 PM">05:15 PM</option>
            <option value="05:30 PM">05:30 PM</option>
            <option value="05:45 PM">05:45 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            <option value="06:15 PM">06:15 PM</option>
            <option value="06:30 PM">06:30 PM</option>
            <option value="06:45 PM">06:45 PM</option>
            <option value="07:00 PM">07:00 PM</option>
            <option value="07:15 PM">07:15 PM</option>
            <option value="07:30 PM">07:30 PM</option>
            <option value="07:45 PM">07:45 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:15 PM">08:15 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="08:45 PM">08:45 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="09:15 PM">09:15 PM</option>
            <option value="09:30 PM">09:30 PM</option>
            <option value="09:45 PM">09:45 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:15 PM">10:15 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="10:45 PM">10:45 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:15 PM">11:15 PM</option>
            <option value="11:30 PM">11:30 PM</option>
            </select>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="row margin-0px day_rows" data-day="5" data-day-title="Friday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Friday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Friday">
            <select class="form-control available_times selectpicker" name="timefriday[]" multiple="" data-actions-box="true" data-day="5" data-day-title="Friday" data-live-search="true" tabindex="-98">
            <option value="" disabled>Not Selected</option>
            
            <option value="09:00 AM">09:00 AM</option>
            <option value="09:15 AM">09:15 AM</option>
            <option value="09:30 AM">09:30 AM</option>
            <option value="09:45 AM">09:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="01:15 PM">01:15 PM</option>
            <option value="01:30 PM">01:30 PM</option>
            <option value="01:45 PM">01:45 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="02:15 PM">02:15 PM</option>
            <option value="02:30 PM">02:30 PM</option>
            <option value="02:45 PM">02:45 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="03:15 PM">03:15 PM</option>
            <option value="03:30 PM">03:30 PM</option>
            <option value="03:45 PM">03:45 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="04:15 PM">04:15 PM</option>
            <option value="04:30 PM">04:30 PM</option>
            <option value="04:45 PM">04:45 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="05:15 PM">05:15 PM</option>
            <option value="05:30 PM">05:30 PM</option>
            <option value="05:45 PM">05:45 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            <option value="06:15 PM">06:15 PM</option>
            <option value="06:30 PM">06:30 PM</option>
            <option value="06:45 PM">06:45 PM</option>
            <option value="07:00 PM">07:00 PM</option>
            <option value="07:15 PM">07:15 PM</option>
            <option value="07:30 PM">07:30 PM</option>
            <option value="07:45 PM">07:45 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:15 PM">08:15 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="08:45 PM">08:45 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="09:15 PM">09:15 PM</option>
            <option value="09:30 PM">09:30 PM</option>
            <option value="09:45 PM">09:45 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:15 PM">10:15 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="10:45 PM">10:45 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:15 PM">11:15 PM</option>
            <option value="11:30 PM">11:30 PM</option>
            </select>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="row margin-0px day_rows" data-day="6" data-day-title="Saturday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Saturday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Saturday">
            <select class="form-control available_times selectpicker" name="timesaturday[]" multiple="" data-actions-box="true" data-day="6" data-day-title="Saturday" data-live-search="true" tabindex="-98">
            <option value="" disabled>Not Selected</option>
            
            <option value="09:00 AM">09:00 AM</option>
            <option value="09:15 AM">09:15 AM</option>
            <option value="09:30 AM">09:30 AM</option>
            <option value="09:45 AM">09:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="01:15 PM">01:15 PM</option>
            <option value="01:30 PM">01:30 PM</option>
            <option value="01:45 PM">01:45 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="02:15 PM">02:15 PM</option>
            <option value="02:30 PM">02:30 PM</option>
            <option value="02:45 PM">02:45 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="03:15 PM">03:15 PM</option>
            <option value="03:30 PM">03:30 PM</option>
            <option value="03:45 PM">03:45 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="04:15 PM">04:15 PM</option>
            <option value="04:30 PM">04:30 PM</option>
            <option value="04:45 PM">04:45 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="05:15 PM">05:15 PM</option>
            <option value="05:30 PM">05:30 PM</option>
            <option value="05:45 PM">05:45 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            <option value="06:15 PM">06:15 PM</option>
            <option value="06:30 PM">06:30 PM</option>
            <option value="06:45 PM">06:45 PM</option>
            <option value="07:00 PM">07:00 PM</option>
            <option value="07:15 PM">07:15 PM</option>
            <option value="07:30 PM">07:30 PM</option>
            <option value="07:45 PM">07:45 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:15 PM">08:15 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="08:45 PM">08:45 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="09:15 PM">09:15 PM</option>
            <option value="09:30 PM">09:30 PM</option>
            <option value="09:45 PM">09:45 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:15 PM">10:15 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="10:45 PM">10:45 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:15 PM">11:15 PM</option>
            <option value="11:30 PM">11:30 PM</option>
            </select>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="row margin-0px day_rows" data-day="7" data-day-title="Sunday">
            

<div class="col-md-4 col-sm-12 day_rows_inner">
            <div class="form-group margin-bottom-0px">
            <label class="day_label">Sunday Availability</label>                                    
            </div>
            </div>
            <div class="rows_append_div">
            <div class="col-md-8 col-sm-12 form-colmns row_main_div">
            <div class="form-group">
            <div class="with-icon" id="Sunday">
            <select class="form-control available_times selectpicker" name="timesunday[]" multiple="" data-actions-box="true" data-day="7" data-day-title="Sunday" data-live-search="true" >
            <option value="" disabled>Not Selected</option>
            
            <option value="09:00 AM">09:00 AM</option>
            <option value="09:15 AM">09:15 AM</option>
            <option value="09:30 AM">09:30 AM</option>
            <option value="09:45 AM">09:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="01:15 PM">01:15 PM</option>
            <option value="01:30 PM">01:30 PM</option>
            <option value="01:45 PM">01:45 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="02:15 PM">02:15 PM</option>
            <option value="02:30 PM">02:30 PM</option>
            <option value="02:45 PM">02:45 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="03:15 PM">03:15 PM</option>
            <option value="03:30 PM">03:30 PM</option>
            <option value="03:45 PM">03:45 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="04:15 PM">04:15 PM</option>
            <option value="04:30 PM">04:30 PM</option>
            <option value="04:45 PM">04:45 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="05:15 PM">05:15 PM</option>
            <option value="05:30 PM">05:30 PM</option>
            <option value="05:45 PM">05:45 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            <option value="06:15 PM">06:15 PM</option>
            <option value="06:30 PM">06:30 PM</option>
            <option value="06:45 PM">06:45 PM</option>
            <option value="07:00 PM">07:00 PM</option>
            <option value="07:15 PM">07:15 PM</option>
            <option value="07:30 PM">07:30 PM</option>
            <option value="07:45 PM">07:45 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:15 PM">08:15 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="08:45 PM">08:45 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="09:15 PM">09:15 PM</option>
            <option value="09:30 PM">09:30 PM</option>
            <option value="09:45 PM">09:45 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="10:15 PM">10:15 PM</option>
            <option value="10:30 PM">10:30 PM</option>
            <option value="10:45 PM">10:45 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="11:15 PM">11:15 PM</option>
            <option value="11:30 PM">11:30 PM</option>
            </select>
            </div>
            </div>
            </div>
            </div>
            </div>
          <!-- <div class="col-md-12 col-sm-12">
            <a class="btn btn-warning" href="javascript:;" id="save_availability_schedule"> <span id="save_availability_schedule_text">Save &amp; Continue</span> <i class="custom-loader"></i></a> 
            <span class="alert messages margin-left-5px" role="alert" id="save_availability_schedule_msg"></span>
          </div> -->
            <div class="col-md-12 col-sm-6 form-colmns"> 
              <input type="submit" name="submit" value="Save &amp; Continue" class="btn btn-primary">   <br>
              <span class="alert messages margin-left-5px" role="alert" id="save_basic_profile_msg"></span>
            </div>
          
      </div>
    </div>
    </form>
        </div>
  </div>