
@if($notifys->post_id!=0)
@php($checktype=$notifys->notifiable_type)
 <li class="dd-note-list"> 


                             <!--  <span class="dd-notification-title">Connection Notifications</span> -->
                            @if($checktype==3)
                                
                              @include('user.notifications.bookingNotify')
                            @elseif($checktype==2)   
                              <!-- refer user to doctor start -->                           
                              @include('user.notifications.referNotify')
                              <!-- refer user to doctor end -->  
                            @else
                            
                                @php($cnuser=$data['getNotification']->getUserConnectionSingle($notifys->post_id))
                                @php($requestusername='')
                                @foreach($cnuser as $uservalue)
                                
                                  @if($uservalue->user_id!=Auth::user()->id)
                                  @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->user_id]))
                                  @else
                                  @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->connect_user_id]))
                                  @endif
                                 <strong> {{$requestusername[0]->name }}</strong>
                                  
                                   
                                @endforeach

                            
                            @endif
                           
                             
</li>
@endif