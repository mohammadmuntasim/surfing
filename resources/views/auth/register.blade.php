@extends('layouts.app')
@section('content')
<style type="text/css">
#registration label.control-label{display: none;}
.form-group.col-sm-6.col-md-6 {
    width: 50%;
    float: left;
}
</style>
    <!-- Content Start -->
    <section class="dd-login-page">
        <div class="dd-content">
            <div class="container" >
                <div class="row">
                    <div class="fw dd-block-text">
                        <div class="col-md-5 pull-right">
                            <div class="dd-signup-form">
                                <h3>Create A New Surf Health Account</h3>
                                <span>FREE FOR ALL!</span>
                             <div class="borderred"></div>
                                <form class="form-horizontal"  id="registration" data-toggle="validator"  role="form" method="POST" action="{{ url('/register') }}" onsubmit="return validateRegisterForm()">
                                     {{ csrf_field() }}
                                  <div class="form-group col-sm-6 col-md-6 pr">
                                    <label for="fname" class="control-label">First Name</label>
                                    <input type="text" class="form-control" id="fname" name="fname" minlength="3"   pattern="^[A-Za-z\s]+$" placeholder="Enter First Name " value="{{ old('fname') }}" data-error="Enter First Name" required autocomplete="off">
                                    <div class="help-block with-errors characterfname"></div>
                                    
                                  </div>
                                  <div class="form-group col-sm-6 col-md-6 pl">
                                    <label for="lname" class="control-label">Last Name</label>
                                    <input type="text" class="form-control" id="lname" name="lname"  minlength="3"  pattern="^[A-Za-z\s]+$" placeholder="Enter Last Name" value="{{ old('lname') }}" data-error="Enter Last Name"  required autocomplete="off">
                                    <div class="help-block with-errors characterlname"></div>

                                  </div>
                                    <div class="form-group col-sm-12 col-md-12">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email"  class="form-control" id="email" name="email"  minlength="6"  placeholder="Enter Email Address"  data-error="Enter Valid Email Address"  required autocomplete="off">
                                    <div class="help-block with-errors" id="email-error"></div>
                                    <div id="email-format-error"></div>
                                    <input type="hidden" id="email_exist" value="0">
                                    <div id="email-exist-error" style="color:#a94442"></div>
                                  </div>
                                  <div class="form-group col-sm-12 col-md-12">
                                    <label for="password" class="control-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"  minlength="6"  placeholder="Enter Password"  data-error="Enter Password"  required autocomplete="off">
                                    <div class="help-block with-errors" id="password-error"></div>
                                  </div>
                                   <div class="form-group col-sm-12 col-md-12">
                                    <label for="role" class="control-label">who</label>
                                    <select class="selectpicker form-control" name="role" id="role" required data-error="Select who you are ?">
                                            <option value="" selected disabled>Who are you?</option>
                                           @if ($roles->count())
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                    <div class="help-block with-errors"></div>
                                  </div>
                                  
                                    <div class="form-group dd-date col-md-12">
                                        <div class="col-md-3 padding">
                                            <label>Birthday :</label>
                                        </div>
                                        <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                        <label for="dobday" class="control-label">who</label>
                                        
                                        <select class="selectpicker form-control" name="day" id="dobday" data-live-search="true"  title="Day" required data-error="Select day">
                                            <!-- <option value=" " selected>Day</option> -->
                                                @for($i = 1; $i <= 31; $i++ )
                                                    <option value="{{sprintf('%02d', $i)}}">{{sprintf('%02d', $i)}}</option>
                                                @endfor
                                        </select>
                                        <div class="help-block with-errors"></div>
                                           </div>
                                        </div>
                                        <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                        <label for="dobmonth" class="control-label">who</label>
                                            <select class="selectpicker form-control" name="month" id="dobmonth" data-live-search="true" title="Month" required data-error="Select month" required>
                                               <!--  <option value="" selected>Month</option> -->
                                                @for($i = 1; $i <= 12; $i++ )
                                                    <?php 
                                                        $dateObj   = DateTime::createFromFormat('!m', $i);
                                                        $monthName = $dateObj->format('F'); 
                                                    ?>                                                    
                                                    <option value="{{sprintf('%02d', $i)}}">{{$monthName}}</option>
                                                @endfor
                                            </select>
                                        <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                        <div class="col-sm-4 col-md-3 pad-right-0">
                                         <div class="form-group">
                                            <label for="year" class="control-label">who</label>
                                            <select  class="selectpicker form-control date-picker-year show-tick" id="year" id="year"name="year" required data-error="Select year"  autofocus data-live-search="true"  title="Year">
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group dd-gendar col-md-12">
                                        <div class="col-md-3 padding">
                                            <label>Gender :</label>
                                        </div>
                                        <div class="col-md-9  gender-div">
                                            <div class="col-sm-4 col-md-3 pad-left-0">
                                                <input type="radio" name="gender" class="genders1" value="female" data-error="Select gender" required>Female                                            
                                            </div>                                        
                                            <div class="col-sm-4 col-md-3">
                                                <input type="radio" name="gender" class="genders1" value="male" required>Male
                                            </div>
                                            <div style="clear:both"></div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="col-md-12 dd-social-login">
                                        <span>OR Create Account using</span>
                                        <ul class="dd-icon-list">
                                            <li><a class="dd-icon" href="#"><i  class="fa fa-facebook-square"></i></a></li>
                                            <li><a class="dd-icon" href="#"><i class="fa fa-google-plus-square"></i></a></li>
                                            <li><a class="dd-icon" href="#"><i  class="fa fa-linkedin-square"></i></a></li>
                                        </ul>
                                    </div>
                                    

                                    <div class="col-md-12 dd-agree">
                                          <div class="form-group">
                                            <div class="checkbox">
                                              <label>
                                                <input type="checkbox" id="terms1" data-error="Please check terms of use" required>
                                                I HAVE READ AND AGREE TO SURFHEALTH <a href="/storage/documents/Terms-of-Use.DOC">TERMS OF USE</a> 
                                              </label>
                                              <div class="help-block with-errors"></div>
                                            </div>
                                          </div>
                                           <div class="form-group">
                                            <div class="checkbox">
                                              <label>
                                                <input type="checkbox" id="terms2" data-error="Please check terms of use" required>
                                                I HAVE READ AND AGREE TO SURFHEALTH <a href="/storage/documents/Policy.DOCX">PRIVACY/HIPAA AUTHORIZATION</a>
                                              </label>
                                              <div class="help-block with-errors"></div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="dd-signup"  >Create an account</button>
                                    </div>                                    
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7 pull-left">
                            <div class="dd-text-space">                                
                                @foreach($data as $data)
                                  @if($data->slug=='register')
                                    {!! $data->body !!}
                                    @endif
                                @endforeach     


                            </div>
                        </div>

                    </div>   
                </div>
            </div>
        </div>
    </section>
    <!-- Content End -->
@endsection