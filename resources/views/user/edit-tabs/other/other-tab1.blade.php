 <div class="fudugo-tab-content {{ app('request')->input('tab') == 'info' ? 'active' : '' }}">
  <div class="dd-info-list-holder">
  <form action="{{url('/profile/edit?tab=info')}}" class="profile-edit-form" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="user_info_edit_form" value = "1">
    <ul class="dd-info-list">
      <li>
        <div class="col-md-2 pad-left-0"><label>Name</label></div>
        <div class="col-md-10">
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Name" value="{{$name}}">
        <div>
      </li>
      <li>
        <div class="col-md-2 pad-left-0"><label>Address</label></div>
        <div class="col-md-10">
        <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" value="{{isset($userMeta['user_address']) ? $userMeta['user_address'] : '' }}">
        <div>
      </li>
                
      <li><div class="col-md-2 pad-left-0"><label>Phone</label></div> <div class="col-md-10"><input type="text" name="number" id="number" class="form-control" data-fv-phone="true" minlength='13' maxlength="13"  onkeypress="return isNumber(event)" placeholder="(xxx)xxx-xxxx" value="{{isset($userMeta['user_number']) ? $userMeta['user_number'] : '' }}" required><div></li>
      <li><div class="col-md-2 pad-left-0"><label>Company</label></div> <div class="col-md-10"><input type="text" name="company" id="company" class="form-control" placeholder="Enter Company" value="{{isset($userMeta['user_company']) ? $userMeta['user_company'] : '' }}"><div></li>
      <li><div class="col-md-2 pad-left-0"><label>Website</label></div> <div class="col-md-10"><input type="text" name="website" id="website" class="form-control" placeholder="Enter Website" value="{{isset($userMeta['user_website']) ? $userMeta['user_website'] : '' }}"><div></li>
    </ul>
    <div class="submit-btn-div">
    <input type="submit" name="submit" value="Save Changes" class="btn btn-primary">
    <a href="{{url('/profile')}}" class="btn btn-default">Cancel</a>
    </div>                          
  </form>
  </div>
  </div>