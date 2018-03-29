
  <div class="fudugo-tab-content {{ app('request')->input('tab') == 'info' ? 'active' : '' }}">
    <div class="col-md-8 col-sm-12 col-lg-12">
      <h2 class="profile-pages-hd">Update Basic Profile</h2>
      <p>Fill out the form below to update your basic profile information </p>
      <div class="update-profile-form update-basic-profile bg-white border-radius-5">
        <div class="padding-30px-20px clearfix basic_profile_container">
          <form action="{{url('/profile/edit?tab=educated')}}" id="basicinfor" data-toggle="validator" class="profile-edit-form" method="post" >
            {{ csrf_field() }}
            <input type="hidden" name="info_edit_form" value = "1">
            
            <div class="row clearfix padding-0px margin-0px">
              <div class="col-md-6 col-sm-6 form-colmns" id="user_title_div">
                <div class="form-group">
                  <label for="exampleInputEmail1">Speciality </label>
                  <!-- <div class="custom-select"> -->                                
                  <select class="form-control selectpicker" id="specialties" name="specialties[]" multiple data-actions-box="true"  required data-live-search="true" data-live-search-placeholder="Search Speciality">
                    <option  value="" disabled>Choose Speciality </option>
                    <!-- seperate specialities by role -->
                    @php($getrole=Auth::user()->role_id)
                    @php($userSpeciality=0)
                    

                    @php($addvalue='0')
                     <!--  get slected specialities -->
                     
                    @php($val=$data['userMetaObj']->getUserMeta(['user_id' =>$uid,'user_meta_key'=>'user_specialties']) )
                    
                   
                    @php($spec='0')
                               <?php
                              switch ($getrole) {
                                    case 2:
                                        foreach($searchdropdown['docspeciality'] as $key=>$doctordatas){
                             
                                           $spec=$doctordatas->speciality;
                                             
                                              if(!empty($userMeta['user_specialties'])){
                                              foreach ($val as $key => $valsp) {
                                                $valk=$valsp->user_meta_value;
                                                if($valk==$spec){
                                                  $addvalue='selected="seleted"';
                                                }else{
                                                  $addvalue='';
                                                }
                                              }
                                              }
                                        ?>
                               
                                          <option value="{{ $spec }}" {{$addvalue}}>{{ $spec }} </option> 
                                          <?php
                                        }
                                        break;
                                    case 5:
                                        foreach($searchdropdown['wellnessspeciality'] as $key=>$doctordatas){
                             
                                           $spec=$doctordatas->well_speciality;
                                             
                                              if(!empty($userMeta['user_specialties'])){
                                              foreach ($val as $key => $valsp) {
                                                $valk=$valsp->user_meta_value;
                                                if($valk==$spec){
                                                  $addvalue='selected="seleted"';
                                                }else{
                                                  $addvalue='';
                                                }
                                              }
                                              }
                                        ?>
                               
                                          <option value="{{ $spec }}" {{$addvalue}}>{{ $spec }} </option> 
                                          <?php
                                        }
                                        break;
                                    case 6:
                                        foreach($searchdropdown['denspeciality'] as $key=>$doctordatas){
                             
                                           $spec=$doctordatas->denspeciality;
                                             
                                              if(!empty($userMeta['user_specialties'])){
                                              foreach ($val as $key => $valsp) {
                                                $valk=$valsp->user_meta_value;
                                                if($valk==$spec){
                                                  $addvalue='selected="seleted"';
                                                }else{
                                                  $addvalue='';
                                                }
                                              }
                                              }
                                        ?>
                               
                                          <option value="{{ $spec }}" {{$addvalue}}>{{ $spec }} </option> 
                                          <?php
                                        }
                                        break;
                                         case 7:
                                        foreach($searchdropdown['eldercarespeciality'] as $key=>$doctordatas){
                             
                                           $spec=$doctordatas->elder_speciality;
                                             
                                              if(!empty($userMeta['user_specialties'])){
                                              foreach ($val as $key => $valsp) {
                                                $valk=$valsp->user_meta_value;
                                                if($valk==$spec){
                                                  $addvalue='selected="seleted"';
                                                }else{
                                                  $addvalue='';
                                                }
                                              }
                                              }
                                        ?>
                               
                                          <option value="{{ $spec }}" {{$addvalue}}>{{ $spec }} </option> 
                                          <?php
                                        }
                                        break;
                                    default:
                                       echo '';
                                }
                   

                               ?>
                                    
                                  
                    
                   
                    
                   
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns" id="user_fullname_div">
                <div class="form-group">
                  <label for="fname">FULL NAME</label>
                  <input type="text" name="fname" id="fname" required class="form-control" placeholder="Enter Full Name" value="{{Auth::user()->name}}">
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns" id="professional_certification_div">
                <div class="form-group">
                  <label for="exampleInputEmail1">Professional certification</label>
                  <input type="text" name="certification" id="certification" name="certification" class="form-control" placeholder="Enter Certification" value="{{isset($userMeta['user_certification']) ? $userMeta['user_certification'] : '' }}" required >
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns" id="user_website_div">
                <div class="form-group">
                  <label for="exampleInputEmail1">Website</label>   <span class="urlerror"></span>
                 
                  <input class="form-control" type="text" id="user_website" name="user_website" onkeypress="isurl()" placeholder="Enter website" value="{{isset($userMeta['user_website']) ? $userMeta['user_website'] : '' }}" >
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns">
                <div class="form-group">
                  <label for="exampleInputEmail1">EMAIL ADDRESS</label>
                  <input class="form-control" type="text" id="user_email_address" name="user_email_address" placeholder="{!! Auth::user()->email !!}" disabled="" value="{!! Auth::user()->email !!}" required >
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns" >
                <div class="form-group">
                  <label for="exampleInputEmail1">GENDER</label>
                  <!-- <div class="custom-select" > -->
                  <select class="form-control selectpicker" id="user_gender" name="user_gender" required>
                    <option value="" disabled=""  >Select Your Gender</option>
                    <option value="male"  @if(!empty($userMeta['user_gender'])) @if($userMeta['user_gender']=='male') selected @endif @endif  >Male</option>                                 
                    <option value="female" @if(!empty($userMeta['user_gender']))  @if($userMeta['user_gender']=='female') selected @endif @endif >Female</option>                                
                  </select>
                  <!-- <span class="text-center"><i class="caret"></i></span> </div> -->
                </div>
              </div>
            </div>
            
            <div class="row clearfix margin-0px">
              <div class="col-md-6 col-sm-6 form-colmns">
                <div class="form-group">
                  <label for="exampleInputEmail1">PHONE NUMBER</label>
                  <input type="text" name="number" id="number" class="form-control" data-fv-phone="true" minlength="13" maxlength="13"  onkeypress="return isNumber(event)" placeholder="(xxx)xxx-xxxx" value="{{isset($userMeta['user_number']) ? $userMeta['user_number'] : '' }}" required >
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns">
                <div class="form-group">
                  <label for="exampleInputEmail1">FAX NUMBER</label>
                  <input type="text" name="fax" id="fax" class="form-control" placeholder="xxx-xxx-xxxx" minlength="12" maxlength="12" onkeypress="return isNumber(event)" value="{{isset($userMeta['user_fax_number']) ? $userMeta['user_fax_number'] : '' }}" >
                </div>
              </div>
            </div>
            
            <div class="row clearfix margin-0px">
              <div class="col-md-6 col-sm-6" id="user_location_title_div">
                <div class="form-group">
                  <label for="exampleInputEmail1">LOCATION TITLE</label>
                  <input class="form-control" type="text" id="user_location_title" name="user_location_title" value="{{isset($userMeta['user_location']) ? $userMeta['user_location'] : '' }}" placeholder="Enter location title" required >
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns" id="user_address_div">
                <div class="form-group">
                  <label for="exampleInputEmail1">STREET ADDRESS</label>
                  <input class="form-control" type="text" id="user_address" name="user_address" value="{{isset($userMeta['user_address']) ? $userMeta['user_address'] : '' }}" placeholder="Enter your street address" required >
                </div>
              </div>
              <!-- </div> -->
              <!-- <div class="row clearfix margin-0px"> -->
              <div class="col-md-6 col-sm-6 form-colmns">
                <div class="form-group">
                  <label for="exampleInputEmail1">STATE<i id="state_spinner"></i></label>
                  <!-- <div class="custom-select user_states_div"> -->
                  <select class="form-control selectpicker" id="user_state" name="user_state" data-live-search="true" required >
                    @foreach($searchdropdown['states'] as $states)
                    <option value="{{$states}}" selected >{{ $states}}</option>
                    @endforeach
                  </select>
                  <!-- <span class="text-center"><i class="caret"></i></span> </div> -->
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns clearfix-mobile" >
                 <div  class="county_div2"  >
                <div class="form-group">
                  <label for="exampleInputEmail1">County <i id="county_spinner"></i></label>
                  <div class="custom-select user_county_div">
                    <select class="form-control selectpicker user_county" name="user_county" data-live-search="true" required >
                      <option value="{{isset($userMeta['user_county']) ? $userMeta['user_county'] : '' }}">{{isset($userMeta['user_county']) ? $userMeta['user_county'] : 'Select Your County' }}</option>
                      @foreach($searchdropdown['county'] as $states)
                      <option value="{{$states}}" >{{ $states}}</option>
                      @endforeach
                      </select>
                  </div>
                  <!-- <button type="button" class="btn btn-success btn-add" id="add_more_county" >
                        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add more county
                    </button> -->
                  <!-- <span class="text-center"><i class="caret"></i></span> </div> -->
                </div>
                 </div>
              </div>
            </div>
              <!-- </div> -->
              <!-- <div class="row clearfix margin-0px"> -->
              <div class="row clearfix margin-0px city_div24">
              <div class="city_div4">
              <div class="col-md-6 col-sm-6 form-colmns " id="city_div" style="{{isset($userMeta['user_city']) ?  : 'none' }}">
                <div class="form-group">
                  <label for="exampleInputEmail1">CITY <i id="city_spinner"></i></label>
                  <div class="custom-select user_city_div" >
                    <select class="form-control selectpicker  user_city" data-live-search="true" name="user_city" required>
                      <option value="{{isset($userMeta['user_city']) ? $userMeta['user_city'] : '' }}">{{isset($userMeta['user_city']) ? $userMeta['user_city'] : 'Select Your City' }}</option>
                    </select>
                  </div>
                  <!-- <span class="text-center"><i class="caret"></i></span> </div> -->
                </div>
              </div>
              <div class="col-md-6 col-sm-6 form-colmns user_zipcode" style="{{isset($userMeta['user_zipcode']) ?  : 'none' }}">
                <div class="form-group">
                  <label for="exampleInputEmail1">Zip code</label>
                  <input class="form-control" type="text" id="user_zipcode" minlength="4" maxlength="6" name="user_zipcode" placeholder="Enter your zipcode" value="{{isset($userMeta['user_zipcode']) ? $userMeta['user_zipcode'] : '' }}" required>
                </div>
              </div>
              <!-- <button type="button" class="btn btn-success btn-add" id="add_more_city" >
                        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add more city
                    </button> -->
            </div>
            </div>
            <div  id="county_div" >
            </div>
            <div class="col-md-12 col-sm-6 form-colmns"> 
              <input type="submit" name="submit" value="Save &amp; Continue" class="btn btn-primary next-step">   <br>
              <span class="alert messages margin-left-5px" role="alert" id="save_basic_profile_msg"></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>