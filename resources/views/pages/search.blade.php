

@extends('layouts.app')
    @section('content')
    <section class="dd-content-holder ">
        <div class="container">
            <div class="row">
                <div class="searchdoctors searchlist col-md-12">
                    <div class="overlay searchpage ">
                            
                        @if(Auth::guest())

                        <div class="transparentsbg well "  >
                            @include('pages.searchform',['url'=>'search','link'=>'search'])
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
.searhlist .registeruser .col-md-9.col-sm-9.col-xs-12 {
    position: inherit;
}
.sh-spe-list>strong {
    width: 100%;
    float: left;
}
.dd-search-holder .dd-button-holder .dropdown {
height: 35px;
width: 100%;
float: left;
margin-bottom: 10px;
}
.dd-search-holder .dd-button-holder .dd-icon-btn {
width: 100%;
float: left;
}
.sentrequest{display: none;}
</style>
    <section class="searhlist">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    
                    <div class="dd-search-holder fw">
                        
                        @if($usertablename!='no')
                        @foreach($usertablename as $usertableview) 
                        <?php
                            if(Auth::check())
                            {
                                $Myid = Auth::user()->id;
                            }
                            else
                            {
                                $Myid=0;
                            }
                            $srid = $usertableview->id;
                        ?>
                        @if($srid !='1')
                        <div class="dd-single-search-holder fw">
                            <div class="dd-search-avater-holder">
                                <?php $urlnamess = str_replace(' ', '-',$usertableview->name); ?>
                                @if($data['userdatabyid']->claimProfile($usertableview->id)==0)
                                @if(Auth::guest())
                                <a  href="{{url('/email-resend-verification')}}?claim=true">
                                    @endif
                                    @else
                                <a href="{{url('/search')}}/{{ $usertableview->id }}/{{ $urlnamess }}">
                                    @endif
                                    @php ($uids = $usertableview->id )
                                  
                                     <figure class="dd-round-avater" style="background-image:url({{url('/')}}{{ isset($usertableview->avatar) ?  $usertableview->avatar : '/css/assets/img/profile-image.jpg' }})">                                
                                    </figure>
                                </a>
                            </div>
                            <div class="dd-search-content-holder">
                                <h3>
                                   
                                <a href="{{url('/search')}}/{{ $usertableview->id }}/{{ $urlnamess }}">
                                   
                                    {{ $usertableview->name }}</a></h3>
                                @php ($usereducation = $userMetaObj->getUserMeta(['user_id' => $uids,'user_meta_key'=>'user_number']) )
                                @if(!empty($usereducation))
                                @foreach($usereducation as $userMetaDataedu)
                                <span class="dd-phone-number"><a href="tel:{{ $userMetaDataedu->user_meta_value }}"><i class="fa fa-phone-square" aria-hidden="true"></i>  {{ $userMetaDataedu->user_meta_value }}</a></span>
                                @endforeach
                                @endif
                                @php($checkrole = $data['rolename']->SearchedUserRole($uids))
                                @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')
                                @php ($userspecialties = $userMetaObj->getUserMeta(['user_id' => $uids,'user_meta_key'=>'user_specialties']) )
                                @if(!empty($userspecialties))
                                <ul class="dd-ddesignation-list">                                    
                                <?php
                                    $counter=1;
                                        if(count($userspecialties)>5)
                                        {
                                            foreach($userspecialties as $userMetaDataspcial)
                                            {   
                                                if($counter<=5)
                                                {
                                                  echo "<li>";
                                                  echo "<span class='dd-ddesignation'>" ;
                                                  echo  $userMetaDataspcial->user_meta_value;
                                                  echo "</span>";
                                                  echo "</li>"; 
                                                }
                                                $counter++;
                                            }   


                                            echo "<button type='button' class='btn btn-default btn-sm' data-toggle='modal' data-target='#mySpcl$usertableview->id'>View More</button>";
                                             
                                        }
                                        else
                                        {
                                            foreach($userspecialties as $userMetaDataspcial)
                                            {   
                                               echo "<li>";
                                                  echo "<span class='dd-ddesignation'>" ;
                                                  echo  $userMetaDataspcial->user_meta_value;
                                                  echo "</span>";
                                                  echo "</li>"; 
                                            }   
                                        } 
                                    ?>
                                </ul>
                                @endif
                                @endif
                                <div class="dd-rating-star">
                                @if($data['getreviews']->countReviews(['user_id'=>$uids])==0)
                                    <ul>
                                        <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                    </ul>
                                    @else
                                    <?php   $rew=0; $ir=0;  ?>
                                    @php($data['reviewss']=$data['getreviews']->getReviews(['user_id'=> $uids]))
                                    <ul>
                                        @foreach($data['reviewss'] as $allreviews1)
                                        <?php 
                                            $rew=$rew+$allreviews1->overall; 
                                            $rew=$rew+$allreviews1->punctuality;
                                            $rew=$rew+$allreviews1->knowledge;
                                            $rew=$rew+$allreviews1->staff;
                                            $ir++;
                                            ?>
                                        @endforeach
                                        <?php 
                                            $numberofcount=$ir*20;
                                            
                                            $trtr=$rew/$numberofcount;
                                            $trt=$trtr*5;
                                            ?>
                                        @for ($i = 0; $i < 5; $i++) 
                                        @if($i<(int)$trt)
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        @elseif($i<$trt)
                                        <li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
                                        @else
                                        <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        @endif
                                        @endfor
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="dd-button-holder">
                                @if($data['userdatabyid']->claimProfile($usertableview->id)==0)
                                @if(Auth::guest())
                                <a class="dd-icon-btn btn-1" href="{{url('/email-resend-verification')}}?claim=true"><span><i class="fa fa-unlock" aria-hidden="true"></i></span> Claim your profile</a>
                                @endif
                                @else
                                <a class="dd-icon-btn btn-1" href="{{url('/search')}}/{{ $usertableview->id }}/{{ $urlnamess }}"><span><i class="fa fa-user" aria-hidden="true"></i></span> Profile</a>
                                
                                 @if(Auth::check())
                                 @if($Myid != $srid)
                                 @php($data['getConnectedornot']=$data['userConnections']->getConnnected(Auth::user()->id,$uids))
                                 @php($data['userid']=$uids)
                                    @if(sizeof($data['getConnectedornot'])==0)                            
      
                                 
                                    <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>                
                                   
                                    <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                        </ul>
                                    </div> 
                                     
                                   
                                   
                                    @else
                                  
                                      @foreach($data['getConnectedornot'] as $frndrequest)
                                      @if($frndrequest->status=='0')
                                      @if($frndrequest->connect_user_id==Auth::user()->id)

                                        <div class="dropdown  sentrequest" id="removeconnection-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                              <span class="caret"></span></button>
                                              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                  <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove1-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                                   
                                              </ul>
                                        </div>
                                        
                                        <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                            <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}"  onclick="removeconnection(this)">Cancel request</a></li>
                                            </ul>
                                        </div> 
                                                      
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>         
                                        <div class="dropdown " id="confirmrequest-{{ $data['userid'] }}" >
                                            <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Respond to request
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="confirm-{{ $data['userid'] }}" onclick="requestfunction(this)">Confirm</a></li>
                                                <li role="presentation"><a role="menuitem" tabindex="-1" id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Delete request</a></li>  
                                            </ul>
                                        </div>

                                      @else
                                                              
                                 
                                      <div class="dropdown " id="sentrequest-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                          </ul>
                                      </div> 


                                      <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>               

                                
                                      @endif
                                  @elseif($frndrequest->status=='1')
                              
                                      <div class="dropdown " id="removeconnection-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                               
                                          </ul>
                                      </div>
                                     
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 sentrequest"  id="makeconnection-{{ $data['userid'] }}" class="requestbutton sentrequest"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>         
                                       <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> request sent
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                          </ul>
                                      </div> 

                                  @endif
                                  @endforeach
                                  @endif
                                  @endif
                                  @else
                                   <a class="dd-icon-btn btn-2" href="{{url('/login')}}" ><span><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With</a>
                                  @endif
                                <!-- show appintment button if role is  doctor -->
                                @php($checkrole = $data['rolename']->SearchedUserRole($usertableview->id))
                                @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.' || $checkrole=='H.')

                                @if(Auth::guest())
                                <a class="dd-icon-btn btn-1" href="{{url('register')}}"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> Make Appointment</a>
                                @else
                                <!-- if I search my self then don't show make appointment -->
                                @if($Myid == $srid)
                                 <a class="dd-icon-btn btn-1" href="{{url('appointments')}}"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> My Appointment</a>
                                @else
                                <a class="dd-icon-btn btn-1" href="{{url('appointments')}}?ref_app={{$data['encrypt']->encryptIt($usertableview->id)}}"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> Make Appointment</a>
                                @endif
                                @endif
                                @endif

                                @endif

                            </div>
                            <div id="mySpcl{{$usertableview->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">

                                            <div>
                                                <h4>
                                                    {{ $usertableview->name }}'s Specialties: 
                                                
                                                </h4>
                                            </div>

                                        </h4>
                                      </div>
                                      <div class="modal-body">
                                        <ul class="sh-spe-list">
                                            
                                            @php ($userspecialties = $userMetaObj->getUserMeta(['user_id' =>$usertableview->id,'user_meta_key'=>'user_specialties']) )
                                            @if(!empty($userspecialties))
                                            
                                            @foreach($userspecialties as $userMetaDataspcial)
                                                
                                            <li class="list-inline" style="display: inline-block;width: 33.333333%;padding: 5px;">
                                              <button type='button' class='btn btn-primary' style='border-radius:5px;width: 100%;'> 
                                                  
                                              {{ $userMetaDataspcial->user_meta_value}}

                                              </button>
                                            </li>
                                                
                                            @endforeach
                                            @endif
                                        </ul>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>

                                  </div>
                            </div>
                        </div> 
                          @else
                        <!-- <div class="text-center">
                                We couldn't find it? Try another.
                        </div> -->
                        @endif
                        @endforeach
                        {{ $usertablename->appends(request()->input())->links() }}
                        @endif
                    </div>
                    <!-- DONT TOUCH HERE -->


                   
      <div class="dd-search-holder fw">
                    
                        
                       @if(!empty($searchresult))
                        @foreach($searchresult as $myseachvalues)
                            
                        @php($userdetails = $data['userdatabyid']->getUserData(['id'=> $myseachvalues->user_id]))
                        <?php
                            if(Auth::check())
                            {
                                $Myid = Auth::user()->id;
                            }
                            else
                            {
                                $Myid=0;
                            }
                            $srid = $myseachvalues->user_id;
                        ?>
                        @if($srid !='1')
                         @foreach($userdetails as $userdetails)
                        
                            <div class="dd-single-search-holder fw">
                                <div class="dd-search-avater-holder">
                                    <?php $urlnamess = str_replace(' ', '-',$userdetails->name); ?>
                                     
                                    <a href="{{url('/search')}}/{{ $userdetails->id }}/{{ $urlnamess }}">
                                       
                                        @php ($uids = $userdetails->id )
                                        <figure class="dd-round-avater" style="background-image:url({{url('/')}}{{ isset($userdetails->avatar) ?  $userdetails->avatar : '/css/assets/img/profile-image.jpg' }})">                                
                                        </figure>
                                       
                                    </a>
                                </div>
                                <div class="dd-search-content-holder">
                                    <h3>

                                    <a href="{{url('/search')}}/{{ $userdetails->id }}/{{ $urlnamess }}">
                                       
                                        {{ $userdetails->name }}</a></h3>

                                    @php ($usereducation = $userMetaObj->getUserMeta(['user_id' => $uids,'user_meta_key'=>'user_number']) )
                                    @if(!empty($usereducation))
                                    @foreach($usereducation as $userMetaDataedu)
                                    <span class="dd-phone-number"><a href="tel:{{ $userMetaDataedu->user_meta_value }}"><i class="fa fa-phone-square" aria-hidden="true"></i>  {{ $userMetaDataedu->user_meta_value }}</a></span>
                                    @endforeach
                                    @endif
                                    @php($checkrole = $data['rolename']->SearchedUserRole($uids))
                                   @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.')
                                    @php ($userspecialties = $userMetaObj->getUserMeta(['user_id' => $uids,'user_meta_key'=>'user_specialties']) )
                                    @if(!empty($userspecialties))
                                    <ul class="dd-ddesignation-list">
                                    <?php
                                        $counter=1;
                                            if(count($userspecialties)>5)
                                            {
                                                foreach($userspecialties as $userMetaDataspcial)
                                                {   
                                                    if($counter<=5)
                                                    {
                                                      echo "<li>";
                                                      echo "<span class='dd-ddesignation'>" ;
                                                      echo  $userMetaDataspcial->user_meta_value;
                                                      echo "</span>";
                                                      echo "</li>"; 
                                                    }
                                                    $counter++;
                                                }   

                                                $uuid = $userdetails->id;
                                                echo "<button type='button' class='btn btn-default btn-sm' data-toggle='modal' data-target='#mySpcl$uuid'>View More</button>";
                                                 
                                            }
                                            else
                                            {
                                                foreach($userspecialties as $userMetaDataspcial)
                                                {   
                                                   echo "<li>";
                                                      echo "<span class='dd-ddesignation'>" ;
                                                      echo  $userMetaDataspcial->user_meta_value;
                                                      echo "</span>";
                                                      echo "</li>"; 
                                                }   
                                            } 
                                        ?>
                                    </ul>
                                    @endif
                                    @endif
                                    <div class="dd-rating-star">
                                    @if($data['getreviews']->countReviews(['user_id'=>$uids])==0)
                                        <ul>
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        </ul>
                                        @else
                                        <?php   $rew=0; $ir=0;  ?>
                                        @php($data['reviewss']=$data['getreviews']->getReviews(['user_id'=> $uids]))
                                        <ul>
                                            @foreach($data['reviewss'] as $allreviews1)
                                            <?php 
                                                $rew=$rew+$allreviews1->overall; 
                                                $rew=$rew+$allreviews1->punctuality;
                                                $rew=$rew+$allreviews1->knowledge;
                                                $rew=$rew+$allreviews1->staff;
                                                $ir++;
                                                ?>
                                            @endforeach
                                            <?php 
                                                $numberofcount=$ir*20;
                                                
                                                $trtr=$rew/$numberofcount;
                                                $trt=$trtr*5;
                                                ?>
                                            @for ($i = 0; $i < 5; $i++) 
                                            @if($i<(int)$trt)
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            @elseif($i<$trt)
                                            <li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
                                            @else
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                            @endif
                                            @endfor
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="dd-button-holder">
                                @if($data['userdatabyid']->claimProfile($userdetails->id)==0)
                                @if(Auth::guest())
                                <a class="dd-icon-btn btn-1" href="{{url('/email-resend-verification')}}?claim=true"><span><i class="fa fa-unlock" aria-hidden="true"></i></span> Claim your profile</a>
                                @endif
                                @else
                                 <a class="dd-icon-btn btn-1" href="{{url('/search')}}/{{ $userdetails->id }}/{{ $urlnamess }}"><span><i class="fa fa-user" aria-hidden="true"></i></i></span> Profile</a>
                                   
                                    @if(Auth::check())
                                     @if($Myid != $srid)
                                     @php($data['getConnectedornot']=$data['userConnections']->getConnnected(Auth::user()->id,$uids))
                                     @php($data['userid']=$uids)
                                      @if(sizeof($data['getConnectedornot'])==0)                            
      
                                 
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 "  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>                
                                   
                                     <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                        </ul>
                                    </div> 
                                     
                                   
                                   
                                  @else
                                 
                                  @foreach($data['getConnectedornot'] as $frndrequest)
                                  @if($frndrequest->status=='0')
                                  @if($frndrequest->connect_user_id==Auth::user()->id)

                                <div class="dropdown  sentrequest" id="removeconnection-{{ $data['userid'] }}">
                                                      <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                          <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove1-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                                           
                                                      </ul>
                                                  </div>
                                    
                                                   <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                                      <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}"  onclick="removeconnection(this)">Cancel request</a></li>
                                                      </ul>
                                                  </div> 
                                                  
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>         
                                <div class="dropdown " id="confirmrequest-{{ $data['userid'] }}" >
                                                      <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Respond to request
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="confirm-{{ $data['userid'] }}" onclick="requestfunction(this)">Confirm</a></li>
                                                          <li role="presentation"><a role="menuitem" tabindex="-1" id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Delete request</a></li>  
                                                      </ul>
                                                  </div>

                              @else
                                    <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                    </ul>
                                </div> 


                                 <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>     
                                  
                                  @endif
                                  @elseif($frndrequest->status=='1')
                              
                                      <div class="dropdown " id="removeconnection-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                               
                                          </ul>
                                      </div>
                                     
                                        <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2 sentrequest"  id="makeconnection-{{ $data['userid'] }}" class="requestbutton sentrequest"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With </button>         
                                       <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle dd-icon-btn btn-2" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> request sent
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                          </ul>
                                      </div> 

                                  @endif
                                  @endforeach
                                  @endif
                                   @endif
                                  @else
                                   <a class="dd-icon-btn btn-2" href="{{url('/login')}}"  ><span><i class="fa fa-user-plus" aria-hidden="true"></i></span> Connect With</a>
                                   @endif
                                <!-- show appintment button if role is  doctor -->
                                @php($checkrole = $data['rolename']->SearchedUserRole($userdetails->id))
                                @if($checkrole=='Dr.' || $checkrole=='D' || $checkrole=='W' || $checkrole=='EC' || $checkrole=='C.' || $checkrole=='H.')
                                @if(Auth::guest())
                                <a class="dd-icon-btn btn-1" href="{{url('register')}}"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> Make Appointment</a>
                                @else
                                 <!-- if I search my self then don't show make appointment -->
                                @if($Myid == $srid)
                                 <a class="dd-icon-btn btn-1" href="{{url('appointments')}}"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> My Appointment</a>
                                @else
                                <a class="dd-icon-btn btn-1" href="{{url('appointments')}}?ref_app={{$data['encrypt']->encryptIt($userdetails->id)}}"><span><i class="fa fa-calendar" aria-hidden="true"></i></span> Make Appointment</a>
                                @endif
                                @endif
                                @endif

                                @endif
                                   
                                   
                                </div>
                                <div id="mySpcl{{$userdetails->id}}" class="modal fade" role="dialog">
                                      <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">

                                                <div>
                                                    <h4>
                                                        {{ $userdetails->name }}'s Specialties: 
                                                    
                                                    </h4>
                                                </div>

                                            </h4>
                                          </div>
                                          <div class="modal-body">
                                            <ul class="sh-spe-list">                     
                                                @php ($userspecialties = $userMetaObj->getUserMeta(['user_id' =>$userdetails->id,'user_meta_key'=>'user_specialties']) )
                                                @if(!empty($userspecialties))
                                                
                                                @foreach($userspecialties as $userMetaDataspcial)
                                                    
                                                <li class="list-inline" style="display: inline-block;width: 33.333333%;padding: 5px;">
                                                  <button type='button' class='btn btn-primary' style='border-radius:5px;width: 100%;'> 
                                                      
                                                  {{ $userMetaDataspcial->user_meta_value}}

                                                  </button>
                                                </li>
                                                    
                                                @endforeach
                                                @endif
                                            </ul>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>

                                      </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <!-- <div class="text-center">
                                We couldn't find it? Try another.
                        </div> -->
                        @endif
                        @endforeach
                        {{ $searchresult->appends(request()->input())->links() }}
                       
                        @endif

                    </div>
                   
                   
                
                      
                   @if((empty($searchresult) && $usertablename =='no') ||  count($usertablename) ==0)
                       
                            <div class="text-center">
                                <div class="alert alert-danger fade in">
                                    
                                    <strong>Oops!</strong> We couldn't find it? Try another.
                                </div>
                               
                            </div>
                        
                    @endif
                </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                @include('user.sidebar')
            </div>
        </div>
        </div>
    </section>
    <div class="modal fade" id="myModalMap" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">My Address</h4>
                </div>
                <div class="modal-body" style="min-height:50px">
                    <div id="map-canvas"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endsection