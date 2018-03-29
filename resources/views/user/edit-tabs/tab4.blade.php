 <style type="text/css">
 .user-insurance .form-group input[type="checkbox"] {
    display: none;
}
 .user-insurance label{float: left;}
 .user-insurance  .form-group.removeplans .btn{padding: 0 10px; }
.form-group.removeplans{margin: 0 auto !important; }
  .user-insurance .form-group input[type="checkbox"] + .btn-group > label span {
    width: 20px;height: 20px;
}

 .user-insurance .form-group input[type="checkbox"] + .btn-group > label span:first-child {
    display: none;
}
 .user-insurance .form-group input[type="checkbox"] + .btn-group > label span:last-child {
    display: inline-block;   
}

 .user-insurance .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
    display: inline-block;
}
 .user-insurance .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
    display: none;   
}
 </style>
  <div class="fudugo-tab-content {{ app('request')->input('tab') == 'insurance' ? 'active' : '' }}">
    <div class="col-lg-12 col-md-8 col-sm-12 clearfix-sm user-insurance">
      <!-- selected insurance -->
      @if(sizeof($data['userinsurance'])>0)
      



       <h2 class="profile-pages-hd">Selected Supported Insurances</h2>
        <div class="clearfix margin-0px ">
          <div id="accordion" class="panel-group">
            @foreach($data['userinsurance'] as $key=>$doctordatas)
            <div class="panel panel-default">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseplans{{$key}}">
                <div class="panel-heading">
                  <h4 class="panel-title">
                      {{ $doctordatas->insurance_name }}
                  </h4>
                </div>
              </a>
              <div id="collapseplans{{$key}}" class="panel-collapse collapse">
                  <div class="panel-body">
                      <p>
                        <ol class="list-group">
                        <?php
                            $valuess='';
                             $valuesk=unserialize($doctordatas->insurance_plan_name);
                               for ($i=0; $i<sizeof($valuesk); $i++) {
                                 $valuess.=' <li class="list-group-item">'.$valuesk[$i].' </li>';
                               }
                            
                             echo $valuess;

                            ?>
                        </ol> </p>
                  </div>
              </div>
            </div>
            @endforeach
          </div>     
               

          </div>
          @else
          <style type="text/css">
          .form-group.removeplans{display: none;}
          </style>
        @endif
      <h2 class="profile-pages-hd">Update Supported Insurances</h2>
      <p>Fill out the form below to update your supported insurances</p>
      <div class="update-profile-form update-forms bg-white border-radius-5">
        <div class="padding-30px-20px form-col-min-height clearfix insurances_container  basic_profile_container " >
          
         <form action="{{url('/profile/edit?tab=availability')}}" id="insurances" data-toggle="validator" class="profile-edit-form" method="post" >
            {{ csrf_field() }}
          <input type="hidden" name="info_insurance" value = "4">
            <div class="row clearfix margin-0px city_div2">
              <div class="city_div">
                <div class="col-md-6 col-sm-6 form-colmns">
                  <div class="form-group">
                    <label for="exampleInputEmail1" class="provider_label">INSURANCE PROVIDER</label>

                    <!-- <div class="custom-select selectInsuranceProvider"> -->
                    <select class="form-control selectpicker insurance_providers" required id="insurassnces" name="insuranceprovider[]" onchange="myshowss(this)" data-live-search="true" tabindex="-98">
                      <option selected="" disabled="" value="0">Select Insurance Provider</option>
                      @foreach($searchdropdown['insurances'] as $doctordatas)
                      @if($doctordatas=='No Insurance')
                      @else
                      <option value="{{ $doctordatas }}">{{ $doctordatas }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 form-colmns user-plans">
                  <div class="form-group">
                    <div class="with-icon">
                      <label for="exampleInputEmail1" class="plan_label">INSURANCE PLAN    </label>
                          <div class="form-group removeplans">
                            <input type="checkbox" name="removeplans[]" id="removeplans0" autocomplete="off" />
                            <div class="[ btn-group ]">
                                <label for="removeplans0" class="[ btn btn-primary ]">
                                    <span class="[ glyphicon glyphicon-ok ]"></span>
                                    <span> </span>
                                </label>
                                <label for="removeplans0" class="[ btn btn-default active ]">
                                    Remove Plans
                                </label>
                            </div>
                        </div>
                     
                      <!-- <div class="custom-select selectInsuranceProvider"> -->
                      <select class="form-control  selectpicker  insurance_plans insurassnces" required name="insuranceplan[0][]" multiple data-actions-box="true" data-live-search="true" id="insurance_plan_0">
                        <option selected="" value="" disabled>Select Insurance Plan</option>
                        <option  value="0">No Insurance Plan</option>
                      </select>
                      
                    </div>
                  </div>
                </div> 
              </div>
            </div>
            <div class="row clearfix margin-0px city_div2" id="p_scents"></div>
            <button type="button" id="addScnt" class="btn btn-success btn-add">
              <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Add More</button>

            <div class="col-md-12 col-sm-8">
            <input type="submit" name="submit" value="Save &amp; Continue" class="btn btn-primary">
          <!--   <button type="submit" name="submit" value="Save & Continue" class="btn btn-warning" href="javascript:;" id="save_supported_insurance"> <span id="save_supported_insurance_text">Save &amp; Continue</span> <i class="custom-loader"></i></button> 
            <span class="alert messages margin-left-5px" role="alert" id="save_supported_insurance_msg"></span>
 -->       </div>
         </form>
        </div>
      
      </div>
    </div>
  </div>