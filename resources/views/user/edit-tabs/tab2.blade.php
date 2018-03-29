
  <div class="fudugo-tab-content {{ app('request')->input('tab') == 'educated' ? 'active' : '' }}">
    <div class="col-md-8 col-sm-7 col-lg-12">
      <h2 class="margin-top-0px">Update Education Profile</h2>
       <p>Fill out the form below to update your educational information</p>
        <div class="update-profile-form update-forms bg-white border-radius-5">
          <div class="padding-30px-20px clearfix education_container">
                    
  
            <div class="control-group" id="fields">
                <div class="controls"> 
                    <form action="{{url('/profile/edit?tab=p-detail')}}" id="basicinfor" data-toggle="validator" class="profile-edit-form" method="post" >
                      {{ csrf_field() }}
                      <input type="hidden" name="educations" value = "2">
                      <div class="voca">                             
                        <div class="col-lg-6 col-md-12 col-sm-12 form-colmns">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Education type</label>                  
                            <select class="form-control  education_types" selected="" data-live-search="true" required name="education_types[]" >
                              <option value="">Select Education Type</option>
                              <option  value="Medical School">Medical School</option>
                              <option value="Residency">Residency</option>
                              <option value="Internship">Internship</option>
                              <option value="Fellowship">Fellowship</option>
                              <option value="Education Type 1">Education Type 1</option>
                            </select>                 
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 form-colmns">
                          <div class="form-group">
                            <label for="exampleInputEmail1">SCHOOL / UNIVERSITY / INSTITUTE / HOSPITAL</label>
                            <input class="form-control user_institute" pattern="^[a-zA-Z ]+$" name="user_institute[]" type="text"  required placeholder="Enter institute name" value="{{isset($userMeta['user_institute']) ? $userMeta['user_institute'] : '' }}">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 form-colmns">
                          <div class="form-group">
                            <label for="exampleInputEmail1">FROM YEAR</label>
                            <input class="form-control from_year" type="text" pattern="^[0-9]{1,}$" maxlength="4" required placeholder="Enter year" name="from_year[]" value="{{isset($userMeta['edu_from_year']) ? $userMeta['edu_from_year'] : '' }}">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 form-colmns">
                          <div class="form-group">
                            <label for="exampleInputEmail1">TO YEAR</label>
                            <input class="form-control to_year" type="text" pattern="^[0-9]{1,}$" maxlength="4"  required placeholder="Enter year" name="to_year[]" value="{{isset($userMeta['edu_to_year']) ? $userMeta['edu_to_year'] : '' }}">
                          </div>
                        </div>            
                              <button type="button" class="btn btn-success btn-add" >
                                  <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add more
                              </button>
                      </div>
                         
                          
                </div>   
                 <div class="col-md-12 col-sm-6 form-colmns"> 
                  <input type="submit" name="submit" value="Save &amp; Continue" class="btn btn-primary">   <br>
                  <span class="alert messages margin-left-5px" role="alert" id="save_basic_profile_msg"></span>
                </div>                  
                    </form>   
                         
            </div>

        </div>
     </div>
    </div>
  </div>