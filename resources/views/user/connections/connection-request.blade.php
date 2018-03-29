<div class="col-md-6 pl">
                    <div class="dd-info-holder dd-card fw mg-b15">
                        <div class="dd-title-holder">
                            <h3>Received Request</h3></div>
                                                   
                        <div class="dd-info-list-holder">
                           @if(sizeof($data['userfriendlistpending'])>0)
                                @foreach($data['userfriendlistpending'] as $friendrequest )
                                 @if($friendrequest->user_id==$uid)
                                 @php($data['userid']=$friendrequest->connect_user_id)
                                 @else
                                 @php($data['userid']=$friendrequest->user_id)
                                @endif
                                @php($requestusername=$data['userMetaObj2']->getUserData(['id' =>$data['userid']]))
                                 @foreach($requestusername as $requestusernamevalue)
                                  <?php $urlnamesname = str_replace(' ', '-',$requestusernamevalue->name); ?>
                          <div class="whitebgrequest clearfix" class="userconnect-{{ $data['userid'] }}">
                                <div class="col-md-2 pad-right-0">                           
                                    <a  href="{{url('/search')}}/{{ $data['userid'] }}/{{ $urlnamesname }}"> 
                                    @if(!empty($data['userid']))
                                    @php($data['usergeneralinfo']=$data['userdatabyid']->getUserData(['id'=>$data['userid']]))
                                        @foreach($data['usergeneralinfo'] as   $myusersdatad) 
                                        <?php $cv=explode('/', $myusersdatad->avatar);
                                                            $paths='';
                                                                if($cv[0]=='users'){
                                                                    $paths='/storage/';
                                                                }else{
                                                                $paths='';
                                                                }
                                                                ?>                
                                        <img src="{{$paths}}{{ isset($myusersdatad->avatar) ?  $myusersdatad->avatar : '/css/assets/img/profile-image.jpg' }}" alt="surf health profile picture {{ isset($myusersdatad->name) ?  $myusersdatad->name : '' }}" id="profile-image-individiual">
                                        @endforeach
                                        @endif
                                </div>
                                <div class="col-md-10">
                                    <a  href="{{url('/search')}}/{{ $data['userid'] }}/{{$urlnamesname}}" class="pull-left">  <h5> {{ $requestusernamevalue->name }}  </h5></a>
                                    <div class="pull-right">
                                      @php($data['getConnectedornot']=$data['userConnections']->getConnnected(Auth::user()->id,$data['userid']))
                                      @if(sizeof($data['getConnectedornot'])==0)                            
      
                                 
                                        <button class="btn btn-primary dropdown-toggle sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"></i> Make Connection </button>                
                                   
                                     <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
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
                                                      <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                          <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove1-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                                           
                                                      </ul>
                                                  </div>
                                    
                                                   <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                                      <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}"  onclick="removeconnection(this)">Cancel request</a></li>
                                                      </ul>
                                                  </div> 
                                                  
                                        <button class="btn btn-primary dropdown-toggle sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"></i> Make Connection </button>         
                                <div class="dropdown " id="confirmrequest-{{ $data['userid'] }}" >
                                                      <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Respond to request
                                                      <span class="caret"></span></button>
                                                      <ul class="dropdown-menu option-class" role="menu" aria-labelledby="menu1">
                                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="confirm-{{ $data['userid'] }}" onclick="requestfunction(this)">Confirm</a></li>
                                                          <li role="presentation"><a role="menuitem" tabindex="-1" id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Delete request</a></li>  
                                                      </ul>
                                                  </div>

                              @else
                                <a href="javascript:void(0);" id="makeconnection-{{ $data['userid'] }}" class="requestbutton "  data-toggle="tooltip" data-  <button class="btn btn-primary dropdown-toggle sentrequest"  id="makeconnection-{{ $data['userid'] }}"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"></i> Make Connection </button> 
                                
                                                 
                                                   <div class="dropdown " id="sentrequest-{{ $data['userid'] }}">
                                                    <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Request sent
                                                    <span class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                                    </ul>
                                                </div> 




                                  
                                  @endif
                                  @elseif($frndrequest->status=='1')
                              
                                      <div class="dropdown " id="removeconnection-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> Connected
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1"  id="remove-{{ $data['userid'] }}" href="javascript:void(0);" onclick="removeconnection(this)">Remove connection</a></li>
                                               
                                          </ul>
                                      </div>
                                     
                                        <button class="btn btn-primary dropdown-toggle"  id="makeconnection-{{ $data['userid'] }}" class="requestbutton sentrequest"  data-toggle="tooltip" data-placement="bottom" title="Send connection request" onclick="addtoconnect(this)"></i> Make Connection </button>         
                                       <div class="dropdown sentrequest" id="sentrequest-{{ $data['userid'] }}">
                                          <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user-plus" aria-hidden="true"></i> request sent
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                              <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="cancel-{{ $data['userid'] }}" onclick="removeconnection(this)">Cancel request</a></li>
                                          </ul>
                                      </div> 

                                  @endif
                                  @endforeach
                                  @endif
                                   <!--  <a href="javascript:void(0)" onclick="deleterequest(this)" id="delete-{{ $data['userid'] }}">Delete Request</a>
                                    <a href="javascript:void(0)" onclick="acceptrequest(this)" id="accept-{{ $data['userid'] }}">Accept Request</a> -->
                                    </div>
                                </div>
                          </div>
                   
                        @endforeach
                                @endforeach

                          @else
                        No Request...
                           @endif
                           
                     </div>

                    </div>
                   
                </div>