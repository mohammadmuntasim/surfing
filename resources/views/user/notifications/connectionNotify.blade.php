@if($notifys->post_id!=0)

 <li class="dd-note-list"> 
                                @php($cnuser=$data['getNotification']->getUserConnectionSingle($notifys->post_id))
                                @php($requestusername='')
                                @if(!empty($cnuser))
                                @foreach($cnuser as $uservalue)

                                 
                                  @if($uservalue->user_id!=Auth::user()->id)
                                  @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->user_id]))
                                  @else
                                  @php($requestusername=$data['userdatabyid']->getUserData(['id' =>$uservalue->connect_user_id]))
                                  @endif
                                  @if($uservalue->status==0)
                                  <figure class="dd-note-avater">
                                    <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt=""></a>
                                  </figure>
                                  <div class="dd-note-content">
                                    <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a>
                                    <div class="btn-group pull-right user-connection-request">
                                        <button type="button" class="btn btn-primary" onclick="deleteRequestnotify(this)" id="deleteRequestnotify-{{ $uservalue->user_id}}"><i class="fa fa-trash" aria-hidden="true"></i> Delete </button>
                                        <button type="button" class="btn btn-primary blues" onclick="acceptRequestnotify(this)" id="acceptRequestnotify-{{ $uservalue->user_id }}"><i class="fa fa-check-square" aria-hidden="true"></i> Confirm</button>
                                        
                                    </div>
                                    <?php $datedd=$notifys->created_at;   ?>
                                     <br>
                                    @include('user.timeline.getTimes')
                                     
                                  </div>
                                  @else
                                  <figure class="dd-note-avater">
                                    <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><img src="{{ isset($requestusername[0]->avatar) ?  $requestusername[0]->avatar : '/css/assets/img/default-avater.png' }}" alt=""></a>
                                  </figure>
                                  <div class="dd-note-content">
                                    <a href="{{url('/')}}/search/{{$requestusername[0]->id }}/{{$requestusername[0]->name }}"><strong>{{$requestusername[0]->name }}</strong></a>
                                    accept your request.
                                    <?php $datedd=$notifys->created_at;   ?>
                                     <br>
                                    @include('user.timeline.getTimes')
                                     
                                  </div>

                                  @endif
                                @endforeach
                                @endif

                            
                          
                           
                             
</li>
@endif

