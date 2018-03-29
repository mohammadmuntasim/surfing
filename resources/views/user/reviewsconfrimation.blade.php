@extends('layouts.app')

@section('content')
<section class="main-content">
    <div class="dd-userport">
        <div class="container">
            <div class="row"> 
                @include('user.profilehead')
            </div>
        </div>
    </div>
</section>

<section class="reviewssection">
     
        <div class="container">
        <div class="row">

            <div class=" col-xs-12 col-sm-8 col-md-8  reviewsconfirm">
                
                                <h3>Reviews</h3>
                            
                 @if($data['reviewss']=='no')
                 <div class="text-center">
                 No Reviews
                
                   </div>                    
                 @else
                <ul class="event-list">
                    @php($i=1)
                    @foreach($data['reviewss'] as $allreviews)
                    <?php $date=$allreviews->created_at; ?>
                    @php ( $uids = $allreviews->sender_id )                          
                    @php ($userprofilepicreview = $data['userdatabyid']->getUserData(['id' => $allreviews->sender_id]) )
                    <!-- user info foreach start-->
                          @foreach($userprofilepicreview as $userMetaDatapicreview)                                                                                   
                    @if($i%2==0)
                    <li class="reviews{{$allreviews->id}}">
                        <time datetime="{{$allreviews->updated_at}}">
                            
                            <span class="day"> {{ date('d', strtotime($date)) }} </span>
                            <span class="month">{{ date('M', strtotime($date)) }}</span>
                            <span class="year">{{ date('Y', strtotime($date)) }}</span>
                            <span class="time">{{ date('h:i A', strtotime($date)) }}</span>
                        </time>
                        <div class="info">                          
                                
                            <figure class="col-md-2">
                              <img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="">
                              <h2 class="title"><!-- display role name -->
                               {{ $data['rolename']->getRoleName(['id'=>$userMetaDatapicreview->role_id])}}
                                {{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}
                              </h2>
                            </figure>
                            <div class="desc col-md-10">
                                 
                                                    <div class=" dd-rating-star pull-right">
                                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                     <strong>Overall Ratings</strong>
                                                                      <div class="static-rating">
                                                                        <div class="rating-container rating-xs rating-animate">        
                                                                          @for ($i = 0; $i < 5; $i++) 
                                                                             @if($i<(int)$allreviews->overall)
                                                                           <i class="fa fa-star" aria-hidden="true"></i>
                                                                          @elseif( $i<$allreviews->overall)
                                                                           <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                           @else
                                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                           
                                                                           @endif
                                                                            @endfor
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                     <strong>Punctuality</strong>
                                                                     <ul class="confrims" style="display:none;"><li><a href="javascript:void(0)" onclick="deletereviews(this);" id="{{$allreviews->id}}"><i class="fa fa-window-close-o" aria-hidden="true"></i></a></li>
                                                                      <li><a href="javascript:void(0)" onclick="approvereviews(this);" id="{{$allreviews->id}}"><i class="fa fa-check-square" aria-hidden="true"></i></a></li>
                                                                    </ul>
                                                                      <div class="static-rating">
                                                                        <div class="rating-container rating-xs rating-animate">
                                                                          @for ($i = 0; $i < 5; $i++) 
                                                                             @if($i<(int)$allreviews->punctuality)
                                                                           <i class="fa fa-star" aria-hidden="true"></i>
                                                                          @elseif( $i<$allreviews->punctuality)
                                                                           <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                           @else
                                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                           
                                                                           @endif
                                                                            @endfor
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                      <strong>Knowledge/Helpfulness</strong>
                                                                      <div class="static-rating">
                                                                        <div class="rating-container rating-xs rating-animate">
                                                                            @for ($i = 0; $i < 5; $i++) 
                                                                             @if($i<(int)$allreviews->knowledge)
                                                                           <i class="fa fa-star" aria-hidden="true"></i>
                                                                          @elseif( $i<$allreviews->knowledge)
                                                                           <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                           @else
                                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                           
                                                                           @endif
                                                                            @endfor
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                      <strong>Staff </strong>
                                                                      <div class="static-rating">
                                                                        <div class="rating-container rating-xs rating-animate">
                                                                          @for ($i = 0; $i < 5; $i++) 
                                                                             @if($i<(int)$allreviews->staff)
                                                                           <i class="fa fa-star" aria-hidden="true"></i>
                                                                          @elseif( $i<$allreviews->staff)
                                                                           <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                           @else
                                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                           
                                                                           @endif
                                                                            @endfor
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                     </div>
                               <p> {{$allreviews->body}}</p>
                             </div>
                        </div>
                        <!-- Review Comment section -->
                      <div class="dd-review-reply review-action" id="review-comment-div-{{$allreviews->id}}">
                        <a href="javascript:void(0);" id="review-reply-{{$allreviews->id}}" onclick="showReplyReviewForm(<?php echo $allreviews->id; ?>)" class="review-docprofile-reply-btn review-reply-btn"><i class="fa fa-comment-o" aria-hidden="true"></i>  <span id="comment-count-{{$allreviews->id}}">{{isset($data['review_comments'][$allreviews->id]) ? count($data['review_comments'][$allreviews->id]) : '0' }}</span> Comment{{count(isset($data['review_comments'][$allreviews->id])) > 1 ? 's' : ''}}</a>
                        <!-- Modal -->
                        <div class="review-reply">
                           <div id="review-modal-{{$allreviews->id}}" style="display:none;"> 
                              <div id="review-reply-form-{{$allreviews->id}}">
                                <form action="{{ url('/profile/review-reply') }}" method="POST" data-toggle="validator" >
                                  {{ csrf_field() }}
                                  <input type="hidden" name="review_id"  value="{{$allreviews->id}}">
                                  <input type="hidden" name="dr_id"  value="{{$allreviews->user_id}}" id="dr_id">
                                  <input type="hidden" name="sender_id"  value="{{Auth::user()->id}}" id="sender_id">
                                  <div class="form-group">
                                                          <textarea class="form-control review-comment" id="{{$allreviews->id}}" onclick="this.select()" onkeydown="if(event.keyCode==13)  reviewReply(this);" placeholder="Reply on Revieew Here..." rows="1" name="comment"></textarea>
                                                          <div id="review-error-{{$allreviews->id}}"></div>
                                                      </div>                        
                                </form>
                              </div>            
                            </div>

                            <div id="new-review-comment-{{$allreviews->id}}"></div>
                            @if($allreviews->count()>0)
                            @if($allreviews->is_reply)
                              @if(isset($data['review_comments'][$allreviews->id]))
                                @foreach($data['review_comments'][$allreviews->id] as $reviewComment)
                                  
                                <?php $profPic = $reviewComment['userProf'] != '' ? $reviewComment['userProf'] : '/css/assets/img/profile-image.jpg'; ?>
                                  <div class="review-comment-row" id="review-comment-row-{{$reviewComment['id']}}">
                                      <figure class="dd-comment-avater-holder">
                                          <img src="<?php echo $profPic ?>" alt="" width="30" class="img-responsive media-object">
                                      </figure>

                                      <div class="comment-info" style="">
                                          <a href="/search/<?php echo $reviewComment['uid']; ?>/<?php echo $reviewComment['userName']; ?>" gold=""><?php echo $reviewComment['userName']; ?></a><br>

                                              <?php echo $reviewComment['comment']; ?>
                                          <br>
                                          <div class="dd-comment-footer fw">
                                              <ul>                
                                                  <li>          
                                                      <?php echo $reviewComment['commentTime']; ?>
                                                  </li>
                                              </ul>
                                          </div>
                                          <br> 
                                    </div>
                                  </div>
                                @endforeach 
                              @endif  
                              <p><a href="javascript:void(0);" id="loadMore-review-comment-{{$allreviews->id}}"> Show More..</a></p>  
                              <p><a href="#review-div-{{$allreviews->id}}" id="write-review-comment-link-{{$allreviews->id}}" style="display: none;"> Write Comment..</a></p>
                            @endif
                            @endif
                        </div>  
                      </div>
                      <!-- End Review Comment -->  
                    </li>
                    @else
                   <li class="reviews{{$allreviews->id}}">
                        <time datetime="{{$allreviews->updated_at}}">
                             <span class="day"> {{ date('d', strtotime($date)) }} </span>
                            <span class="month">{{ date('M', strtotime($date)) }}</span>
                            <span class="year">{{ date('Y', strtotime($date)) }}</span>
                            <span class="time">{{ date('h:i A', strtotime($date)) }}</span>
                        </time>                     
                        <div class="info">                            
                            <figure class="col-md-2">
                               <img src="{{ isset($userMetaDatapicreview->avatar) ?  $userMetaDatapicreview->avatar : '/css/assets/img/profile-image.jpg' }}" alt="">
                               <h2 class="title"><!-- display role name -->
                               {{ $data['rolename']->getRoleName(['id'=>$userMetaDatapicreview->role_id])}}
                                {{ isset($userMetaDatapicreview->name) ?  $userMetaDatapicreview->name : 'Surf Health' }}
                               </h2>
                            </figure>
                            <div class="desc col-md-10 ">
                               <div class=" dd-rating-star pull-right">
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                   <strong>Overall Ratings</strong>
                                    <div class="static-rating">
                                      <div class="rating-container rating-xs rating-animate">        
                                        @for ($i = 0; $i < 5; $i++) 
                                           @if($i<(int)$allreviews->overall)
                                         <i class="fa fa-star" aria-hidden="true"></i>
                                        @elseif( $i<$allreviews->overall)
                                         <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                         @else
                                                  <i class="fa fa-star-o" aria-hidden="true"></i>
                                         
                                         @endif
                                          @endfor
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                   <strong>Punctuality</strong>
                                   <ul class="confrims" style="display:none"><li><a href="javascript:void(0)" onclick="deletereviews(this);" id="{{$allreviews->id}}"><i class="fa fa-window-close-o" aria-hidden="true"></i></a></li> <li><a href="javascript:void(0)" onclick="approvereviews(this);" id="{{$allreviews->id}}"><i class="fa fa-check-square" aria-hidden="true"></i></a></li></ul>
                                    <div class="static-rating">
                                      <div class="rating-container rating-xs rating-animate">
                                        @for ($i = 0; $i < 5; $i++) 
                                           @if($i<(int)$allreviews->punctuality)
                                         <i class="fa fa-star" aria-hidden="true"></i>
                                        @elseif( $i<$allreviews->punctuality)
                                         <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                         @else
                                                  <i class="fa fa-star-o" aria-hidden="true"></i>
                                         
                                         @endif
                                          @endfor
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <strong>Knowledge/Helpfulness</strong>
                                    <div class="static-rating">
                                      <div class="rating-container rating-xs rating-animate">
                                          @for ($i = 0; $i < 5; $i++) 
                                           @if($i<(int)$allreviews->knowledge)
                                         <i class="fa fa-star" aria-hidden="true"></i>
                                        @elseif( $i<$allreviews->knowledge)
                                         <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                         @else
                                                  <i class="fa fa-star-o" aria-hidden="true"></i>
                                         
                                         @endif
                                          @endfor
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <strong>Staff </strong>
                                    <div class="static-rating">
                                      <div class="rating-container rating-xs rating-animate">
                                        @for ($i = 0; $i < 5; $i++) 
                                           @if($i<(int)$allreviews->staff)
                                         <i class="fa fa-star" aria-hidden="true"></i>
                                        @elseif( $i<$allreviews->staff)
                                         <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                         @else
                                                  <i class="fa fa-star-o" aria-hidden="true"></i>
                                         
                                         @endif
                                          @endfor
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <p>{{$allreviews->body}}</p></div>
                        </div>
                          <!-- Review Comment section -->
                      <div class="dd-review-reply review-action" id="review-comment-div-{{$allreviews->id}}">
                        <a href="javascript:void(0);" id="review-reply-{{$allreviews->id}}" onclick="showReplyReviewForm(<?php echo $allreviews->id; ?>)" class="review-docprofile-reply-btn review-reply-btn"><i class="fa fa-comment-o" aria-hidden="true"></i>  <span id="comment-count-{{$allreviews->id}}">{{isset($data['review_comments'][$allreviews->id]) ? count($data['review_comments'][$allreviews->id]) : '0' }}</span> Comment{{count(isset($data['review_comments'][$allreviews->id])) > 1 ? 's' : ''}}</a>
                        <!-- Modal -->
                        <div class="review-reply">
                            <div id="review-modal-{{$allreviews->id}}" style="display:none;"> 
                          <div id="review-reply-form-{{$allreviews->id}}">
                            <form action="{{ url('/profile/review-reply') }}" method="POST" data-toggle="validator" >
                              {{ csrf_field() }}
                              <input type="hidden" name="review_id"  value="{{$allreviews->id}}">
                              <input type="hidden" name="dr_id"  value="{{$allreviews->user_id}}" id="dr_id">
                              <input type="hidden" name="sender_id"  value="{{Auth::user()->id}}" id="sender_id">
                              <div class="form-group">
                                                      <textarea class="form-control review-comment" id="{{$allreviews->id}}" onclick="this.select()" onkeydown="if(event.keyCode==13)  reviewReply(this);" placeholder="Reply on Review Here..." rows="1" name="comment"></textarea>
                                                      <div id="review-error-{{$allreviews->id}}"></div>
                                                  </div>                        
                            </form>
                          </div>            
                            </div>

                            <div id="new-review-comment-{{$allreviews->id}}"></div>
                            @if($allreviews->is_reply)
                          @if(isset($data['review_comments'][$allreviews->id]))
                            @foreach($data['review_comments'][$allreviews->id] as $reviewComment)
                              
                            <?php $profPic = $reviewComment['userProf'] != '' ? $reviewComment['userProf'] : '/css/assets/img/profile-image.jpg'; ?>
                              <div class="review-comment-row" id="review-comment-row-{{$reviewComment['id']}}">
                                  <figure class="dd-comment-avater-holder">
                                      <img src="<?php echo $profPic ?>" alt="" width="30" class="img-responsive media-object">
                                  </figure>

                                  <div class="comment-info" style="">
                                      <a href="/search/<?php echo $reviewComment['uid']; ?>/<?php echo $reviewComment['userName']; ?>" gold=""><?php echo $reviewComment['userName']; ?></a><br>

                                          <?php echo $reviewComment['comment']; ?>
                                      <br>
                                      <div class="dd-comment-footer fw">
                                          <ul>                
                                              <li>          
                                                  <?php echo $reviewComment['commentTime']; ?>
                                              </li>
                                          </ul>
                                      </div>
                                      <br> 
                                </div>
                              </div>
                            @endforeach 
                          @endif  
                          <p><a href="javascript:void(0);" id="loadMore-review-comment-{{$allreviews->id}}"> Show More..</a></p>  
                          <p><a href="#review-div-{{$allreviews->id}}" id="write-review-comment-link-{{$allreviews->id}}" style="display: none;"> Write Comment..</a></p>
                            @endif  
                        </div>   
                      </div>
                      <!-- End Review Comment -->

                        
                    </li>
                    @endif
                    
                    @php($i++)
                     @endforeach
                    @endforeach
                    
                </ul>
                @endif
            </div>
             <div class=" col-xs-12 col-sm-4 col-md-4 ">
                 @include('user/sidebar')
             </div>
        </div>
    </div>
    
    
    

</section>

@endsection