  <div class="fudugo-tab-content {{ app('request')->input('tab') == 'p-exp' ? 'active' : '' }}">
    <form action="{{url('/profile/edit?tab=p-exp')}}" class="profile-edit-form" method="post">
      {{ csrf_field() }}
       <input type="hidden" name="post_experience" value = "6">
          <h2 class="margin-top-0px">Update Past Experience</h2>
      <p>Fill out the form below to update your Past Experience</p>
     <div class="form-group">
        <label for="hospitalname" class="control-label">Hospital Name </label>
        <input type="text" class="form-control" id="hospitalname" name="hospitalname" placeholder="Hospital Name" required>
     </div>
     <div class="form-group">
        <label for="postition" class="control-label">Position  </label>
        <input type="text" class="form-control" id="postition" name="postition" placeholder="Postition Name" required>
     </div>
     <div class="form-group">
        <label for="work_city" class="control-label">City/Town  </label>
        <input type="text" class="form-control" id="work_city" name="work_city" placeholder="Work City Name" required>
     </div>
      <div class="form-group">
       <label for="work_city" class="control-label">Description  </label>
    
      <textarea name="past_experience" id="past_experience" class="form-control" placeholder="Enter your post experience">{{isset($userMeta['user_past_experience']) ? $userMeta['user_past_experience'] : '' }}</textarea>
      </div>
       <div class="form-group">
       <label for="work_city" class="control-label">Time Period
       <input class="currentCheckbox uiInputLabelInput uiInputLabelCheckbox" data-toggle="collapse" data-target="#workdate2" type="checkbox" name="date[current]" checked="1" id="u_11_c">
        <a href="#workdate" data-toggle="collapse" data-target="#workdate">+Add Date</a></label></div>
     
     <div class="form-group">
      <div id="workdate" class="collapse">
          
          <div class="col-md-6"><input type="text"  name="workfrom" id="workfrom" class="form-control datepicker" ></div> <label>to present </label>
         
      </div>
       <div id="workdate2" class="collapse">
          
          <div class="col-md-6"><input type="text"  name="workto" class="form-control datepicker" ></div>
         
      </div>
    </div>
     
      <div class="submit-btn-div">
        <input type="submit" name="submit" value="Save Changes" class="btn btn-primary">
        <a href="{{url('/profile')}}" class="btn btn-default">Cancel</a>
      </div>
    </form>
  </div>