<div role="tabpanel" class="tab-pane " id="tab2">
                      <div class="dd-timeline-posts-holder fw">
                          
                          <div class="dd-content-inner fw dd-card">
                            <div class="dd-common-inner-title">
                                <h3>Followers ({{$data['userfollow']->CountFollowing(['follower_user_id'=>Auth::user()->id])}})</h3>
                              </div>
                            <div class="dd-grid-2-column dd-grid-style-two">
                                  @if(!empty($data['userfollowers']))
                                  @foreach($data['userfollowers'] as $followersid)
                                   @php($userinfo=$data['userdatabyid']->getUserData(['id'=>$followersid->follow_user_id]))
                                    @foreach($userinfo as $userdata)
                                  <div class="col-md-6">
                                      <div class="dd-grid-item">
                                          <figure class="dd-grid-avater">
                                              <img src="{{ isset($userdata->avatar) ?  $userdata->avatar : '/css/assets/img/profile-image.jpg' }}" alt="{{ isset($userdata->name) ?  $userdata->name : 'Surf Health Avatar' }}">
                                          </figure>
                                          <div class="dd-grid-content align-middle">

                                              <h4>{{ isset($userdata->name) ?  $userdata->name : '' }}</h4>
                                              <span>{{$data['userfollow']->CountFollowing(['follower_user_id'=>$userdata->id])}} followers</span>

                                              <a class="btn btn-default" href="javascript:void(0);" onclick="followusers(this)" data-followuser="{{$userdata->id}}" >
                                                  @if($userdata->follow_user_id==Auth::user()->id) Following @else Follow 
                                                  @endif</a>
                                          </div>
                                      </div>
                                  </div>
                                  @endforeach
                                  @endforeach
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane " id="tab3">
                      <div class="dd-timeline-posts-holder fw">
                          
                          <div class="dd-content-inner fw dd-card">
                            <div class="dd-common-inner-title">
                                <h3>Following ({{$data['userfollow']->CountFollowing(['follow_user_id'=>Auth::user()->id])}})</h3>

                              </div>
                            <div class="dd-grid-2-column dd-grid-style-two">
                                   @if(!empty($data['userfollowing']))
                                  @foreach($data['userfollowing'] as $followersid)
                                   @php($userinfo=$data['userdatabyid']->getUserData(['id'=>$followersid->follower_user_id]))
                                    @foreach($userinfo as $userdata)
                                  <div class="col-md-6">
                                      <div class="dd-grid-item">
                                          <figure class="dd-grid-avater">
                                              <img src="{{url('/')}}/{{ isset($userdata->avatar) ?  $userdata->avatar : 'css/assets/img/profile-image.jpg' }}" alt="{{ isset($userdata->name) ?  $userdata->name : 'Surf Health Avatar' }}">
                                          </figure>
                                          <div class="dd-grid-content align-middle">

                                              <h4>{{ isset($userdata->name) ?  $userdata->name : '' }}</h4>
                                              <span>{{$data['userfollow']->CountFollowing(['follower_user_id'=>$userdata->id])}} followers</span>
                                              <a class="btn btn-default" href="javascript:void(0);"  onclick="followusers(this)"  data-followuser="{{$userdata->id}}">Unfollow</a>
                                          </div>
                                      </div>
                                  </div>
                                  @endforeach
                                  @endforeach
                                  @endif
                                 
                                 
                              </div>
                          </div>
                      </div>
                  <div>