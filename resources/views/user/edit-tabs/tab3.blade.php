 <div class="fudugo-tab-content {{ app('request')->input('tab') == 'p-detail' ? 'active' : '' }}">
    <div class="col-md-8 col-sm-12 col-lg-12">
      <h2 class="profile-pages-hd">Update Professional Details</h2>
      <p>Fill out the form below to update your professional details</p>
      <form action="{{url('/profile/edit?tab=insurance')}}" id="basicinfor" data-toggle="validator" class="profile-edit-form" method="post" >
            {{ csrf_field() }}
      <div class="update-professional-form update-forms form-rows-spacing bg-white border-radius-5">
        <div class="padding-30px-20px clearfix professional_container clearfix ">
            
            <input type="hidden" name="professional_details" value = "3">
              <div class="row margin-0px suggestion-row z-index-15">
                <div class="col-md-12 col-sm-12 form-colmns">
                  <div class="form-group magic-suggest-tags">
                    <label for="exampleInputEmail1">Procedures</label>
                    <div class="ms-ctn form-controlss " style="">
                      <span class="ms-helper " ></span>
                      <div class="ms-sel-ctn">
                        <input type="text" class="form-control " name="proceduretags" placeholder="Start typing procedure name"  multiple data-role="tagsinput">
                        
                      </div>
                      <div class="ms-trigger">
                        <div class="ms-trigger-ico"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @if(!empty($userMeta['user_procedure']))
              <?php $getunserial=$data['userMetaObj']->getUserMeta(['user_id' =>$uid,'user_meta_key'=>'user_procedure']); ?>
              <div class="row tagsly" id="procedures_area">
              <?php  foreach($getunserial as $procedurevalue) { ?>
              <span class="tag procedures_row" tabindex="-1" id="tags{{$procedurevalue->id}}"> {{$procedurevalue->user_meta_value}}
              <a class="fa fa-trash remove_procedures_btn" data-id="{{$procedurevalue->id}}" data-speciality_id="{{$procedurevalue->id}}" onclick="removetags(this)" href="javascript:;" tabindex="-1"></a></span>
              <?php  }?>             

              </div>
             @endif
          <div class="row tagsly padding-top-0px" id="procedures_area_suggestion">
          </div>
         
          <div class="row margin-0px suggestion-row z-index-10">
            <div class="col-md-12 col-sm-12 form-colmns">
              <div class="form-group magic-suggest-tags">
                <label for="exampleInputEmail1">CONDITIONS</label>
                <div class="ms-ctn form-controlss " style="">
                  <div class="ms-sel-ctn">
                    <input type="text" name="conditionstag" class="form-control " multiple data-role="tagsinput" placeholder="Start typing condition name"  multiple data-role="tagsinput">
                  </div>
                </div>
              </div>
            </div>
          </div>
              @if(!empty($userMeta['user_conditions']))
              <?php $getunserial=$data['userMetaObj']->getUserMeta(['user_id' =>$uid,'user_meta_key'=>'user_conditions']); ?>
              <div class="row tagsly" id="condition_area">
              <?php  foreach($getunserial as $procedurevalue) { ?>
              <span class="tag procedures_row" tabindex="-1" id="tags{{$procedurevalue->id}}"> {{$procedurevalue->user_meta_value}}
              <a class="fa fa-trash remove_procedures_btn" data-id="{{$procedurevalue->id}}" data-speciality_id="{{$procedurevalue->id}}" onclick="removetags(this)" href="javascript:;" tabindex="-1"></a></span>
              <?php  }?>             

              </div>
              @endif
          <!-- <div class="row tagsly" id="conditions_area"><span class="tag conditions_row" tabindex="-1" data-id="7" data-speciality_id="2">Rheumatoid Arthritis<a class="fa fa-trash remove_conditions_btn" href="javascript:;" tabindex="-1"></a></span><span class="tag conditions_row" tabindex="-1" data-id="8" data-speciality_id="2">Sleep Apnea<a class="fa fa-trash remove_conditions_btn" href="javascript:;" tabindex="-1"></a></span><span class="tag conditions_row" tabindex="-1" data-id="9" data-speciality_id="2">Knee Problems<a class="fa fa-trash remove_conditions_btn" href="javascript:;" tabindex="-1"></a></span><span class="tag conditions_row" tabindex="-1" data-id="10" data-speciality_id="2">Pregnancy<a class="fa fa-trash remove_conditions_btn" href="javascript:;" tabindex="-1"></a></span></div> -->
          <div class="row tagsly padding-top-0px" id="conditions_area_suggestion">                        
          </div>
         
          <div class="row margin-0px">
            <div class="col-md-6 col-sm-12 form-colmns clearfix-mobile ">
              <div class="form-group margin-bottom-0px"> 
                <label for="exampleInputEmail1" class="affiliation_label">Hospital Affiliations</label>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 form-colmns clearfix-mobile" class="first_affiliation_div" style="display: block;">
              <div class="form-group">
                <input type="text" class="form-control hospital_affiliations" name="hospaffir" value="{{isset($userMeta['user_hospital_ffiliations']) ? $userMeta['user_hospital_ffiliations'] : '' }}" placeholder="Enter hospital affiliations" required>
              </div>
            </div>
          </div>
         
          <div class="row margin-0px">
            <div class="col-md-6 col-sm-12 form-colmns clearfix-mobile">
              <div class="form-group margin-bottom-0px"> 
                <label for="exampleInputEmail1" class="certifications_label">Board Certifications</label>
              </div>
            </div>
            
            <div class="col-md-6 col-sm-12 form-colmns clearfix-mobile">
              <div class="form-group">
                <input type="text" name="borad_cerft" class="form-control board_certifications"  value="{{isset($userMeta['user_hospital_ffiliations']) ? $userMeta['user_board_certification'] : '' }}" placeholder="Enter board certification" required>
              </div>
            </div>
          </div>
         
          <div class="row margin-0px">
            <div class="col-md-6 col-sm-12 form-colmns clearfix-mobile">
              <div class="form-group margin-bottom-0px"> 
                <label for="exampleInputEmail1" class="memberships_label">Professional Memberships</label>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 form-colmns clearfix-mobile">
              <div class="form-group">
                <input type="text" name="prof_memb" class="form-control professional_memberships"  placeholder="Enter professional memberships"  value="{{isset($userMeta['user_memberships']) ? $userMeta['user_memberships'] : '' }}">
              </div>
            </div>
          </div>
         
          <div class="row margin-0px suggestion-row">
            <div class="col-md-12 col-sm-12 form-colmns clearfix-mobile" style="padding:15px;">
              <div class="form-group">
                <label for="professional_statement">Professional Statement</label>
                <textarea class="form-control custom-textarea" name="prof_stat" id="professional_statement" >{{isset($userMeta['user_professional_statement']) ? $userMeta['user_professional_statement'] : '' }}</textarea>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
         <div class="col-md-12 col-sm-6 form-colmns"> 
              <input type="submit" name="submit" value="Save &amp; Continue" class="btn btn-primary">   <br>
              <span class="alert messages margin-left-5px" role="alert" id="save_basic_profile_msg"></span>
            </div>  
      </div>  
            </form>  
    </div>
  </div>