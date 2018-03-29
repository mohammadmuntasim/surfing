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
    <div class="main-content-holder">
        <div class="container">
            <div class="row">
                <div class="col-md-8 pl-pr dd-scroll-contents">
                    <div class="dd-timeline-posts-holder fw">
                        <div class="dd-write-post dd-card">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a class="type-article" href="#post-type-article" aria-controls="article" role="tab" data-toggle="tab">Post Article</a>
                                </li>
                                <li role="presentation">
                                    <a class="type-photo" href="#post-type-photo" aria-controls="photo" role="tab" data-toggle="tab">Post Photo</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                 <div role="tabpanel" class="tab-pane active" id="post-type-article">
                                <div class="dd-post-write-holder">
                                     <form class="form-horizontal" role="form"   id="upload_form" method="POST" action="{{ url('/timeline-post') }}">
                                         {{ csrf_field() }}
                                        
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-default">Post</button>
                                    </form>
                                </div>  
                            </div>
                                <div role="tabpanel" class="tab-pane" id="post-type-photo">
                                    <div class="dd-post-write-holder">
                                         <form class="form-horizontal" role="form"  id="upload_form" method="POST" action="{{ url('/timeline-post') }}"  enctype="multipart/form-data">
                                             {{ csrf_field() }}                                         

                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content"></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                            <figure class="dd-cover-changer">  
                                                <a href="#" class="removedpost"><i class="fa fa-remove" aria-hidden="true"></i></a>                   
                                            <img src="" alt="surf health cover " id="cover-image-individiual">     
                                             </figure>
                                            </div>
                                            <div class="form-group margin-top-10">

                                                <input id="file-1" class="inputfile inputfile-1 file" type="file" name="post_image" multiple data-overwrite-initial="false" data-min-file-count="1" id="imagedatagetimagedata(document.getElementById('imagedata'))">
                                               <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span>Choose a file…</span></label>
                                                 <button type="submit" class="btn btn-default" >Post</button>

                                            </div>
                                           
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                       
                                
                        <div class="dd-post-holder fw">
                            <input type="hidden" id="base_url" value="{{url('/timeline-post')}}">
                            <div id="mytimelinepost">
                            @if(!empty($postblog['timeline_post']))
                                @foreach($postblog['timeline_post'] as $key => $values)
@php($uid=Auth::user()->id)
                                @foreach($values as $postvalues)
                               @php ($totallikes = $userController->getUserPostLikeById(['content_id'=>$postvalues->id]) )
                              @php ($totallikesme = $userController->getPostLikeByMe(['user_id'=>$uid,'content_id'=>$postvalues->id]) )                              
                               @php($sharepost=$data['sharedpost']->getPostShareData(['post_id'=>$postvalues->id]))     
                                    <div class="dd-single-post-holder" >
                                        <div class="dd-post-header fw">
                                            <figure class="dd-post-avater-holder">
                                                @php ( $uids = $postvalues->user_id )  
                                                 @php($userprofilepic=$data['userdatabyid']->getUserData(['id'=>$uids]))
                                                    @foreach($userprofilepic as $userMetaDatapic)
                                                    <figure class="dd-post-avater-holder">
                                                    @if(empty($userMetaDatapic->avatar))     
                                                        <img src="/css/assets/img/dummy-img-10.jpg" alt="">
                                                    @else
                                                       <img src="{{ $userMetaDatapic->avatar }}" alt="Image" class="img-responsive media-object">
                                                    @endif
                                                    
                                                   </figure>
                                                
                                            </figure>
                                            <div class="dd-post-user-holder">
                                              
                                              <ul><li><h5><a href="{{url('/search')}}/{{$userMetaDatapic->id}}/{{$userMetaDatapic->name}}">
                                              <!-- display role name -->
                                                 {{ $data['rolename']->getRoleName(['id'=>$userMetaDatapic->role_id])}} {{$userMetaDatapic->name}}</a></h5></li>
                                                @if(!empty($sharepost))
                                              @foreach($sharepost as $postsharedata2)   
                                              @php($userdatapost2=$data['userdatabyid']->getUserData(['id'=>$postsharedata2->post_user_id]))  
                                               @foreach($userdatapost2 as $userdatapostname) 
                                               @php($checkgender=$userdatapostname->gender)

                                                @if($userdatapostname->id!=$uid)  
                                               <li> <span> shared </span></li><li><h5><a href="{{url('/search')}}/{{$userdatapostname->id}}/{{$userdatapostname->name}}"> 
                                               <!-- display role name -->
                                                 {{ $data['rolename']->getRoleName(['id'=>$userdatapostname->role_id])}}{{ $userdatapostname->name }} </a></h5></li><li> post.</li>
                                               @else
                                                <li>shared @if($userdatapostname=='Female')her @else his @endif post.</li>
                                                @endif
                                               @endforeach
                                              @endforeach
                                             </ul>
                                              @endif
                                            
                                            @endforeach
                                            <span>
                                            <?php
                                           date_default_timezone_set('Asia/Kolkata');
                                            $datedd=$postvalues->updated_at;
                                            $date1 = date('Y-m-d H:i:s', strtotime($datedd));
                                            $date2 = date("Y-m-d H:i:s");
                                           
                                            $diff = abs(strtotime($date2) - strtotime($date1));

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                            $times=abs(strtotime($date2)-strtotime($date1));
                                            $gettimepost = date('h:i A', strtotime($date1));
                                            if($days==0){
                                                $days=$times;
                                                if($times<60)
                                                {
                                                    $days=$times." seconds";
                                                }elseif($times<3600){
                                                    $checkminuts=floor($times/60);
                                                    if($checkminuts<59){
                                                            $days=$checkminuts."  minutes";
                                                    }else{
                                                    $days="about an hours";
                                                   }

                                                }else{
                                                    $checkminuts=floor($times/3600);
                                                    $days=$checkminuts." hrs";
                                                }
                                                
                                            }elseif($days==1) {
                                                   $days='Yesterday at '.$gettimepost;
                                            }elseif($days>1){
                                                    if($years==0){
                                                    $days=date('d M', strtotime($date1))." at ".$gettimepost;
                                                   }else{
                                                    $days=date('d-m-y h:i A', strtotime($date1))." at ".$gettimepost;
                                                   }
                                                }
                                             ?>
                                            {!! $days !!} </span>
                                        </div>
                                        </div>
                                        

                                        <div class="dd-post-content fw" id="timeline-post-content">
                                            <p>{!! $postvalues->content !!}</p>
                                             <!-- get user data who created post  -->
                                        @if(!empty($sharepost))
                                          @foreach($sharepost as $postsharedata)
                                          @php($userdatapost=$data['userdatabyid']->getUserData(['id'=>$postsharedata->post_user_id]))
                                            @foreach($userdatapost as $usersdatapost)
                                            <figure class="dd-post-avater-holder">
                                            @if(empty($usersdatapost->avatar))     
                                                <img src="/css/assets/img/dummy-img-10.jpg" alt="">
                                            @else
                                               <img src="{{ $usersdatapost->avatar }}" alt="Image" class="img-responsive media-object">
                                            @endif
                                            
                                           </figure>
                                            <div class="dd-post-user-holder">        
                                             <h5><a href="{{url('/search')}}/{{$usersdatapost->id}}/{{$usersdatapost->name}}"> 
                                              <!-- display role name -->
                                                 {{ $data['rolename']->getRoleName(['id'=>$usersdatapost->role_id])}} {{$usersdatapost->name}} </a></h5>
                                            <span>
                                                <?php 
                                            $datedd2=$usersdatapost->created_at;
                                            $date1 = date('Y-m-d H:i:s', strtotime($datedd2));
                                            $date2 = date("Y-m-d H:i:s");
                                           
                                            $diff = abs(strtotime($date2) - strtotime($date1));

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                            $times=abs(strtotime($date2)-strtotime($date1));
                                            $gettimepost = date('h:i A', strtotime($date1));
                                            if($days==0){
                                                $days=$times;
                                                if($times<60)
                                                {
                                                    $days=$times." seconds";
                                                }elseif($times<3600){
                                                    $checkminuts=floor($times/60);
                                                    if($checkminuts<59){
                                                            $days=$checkminuts."  minutes";
                                                    }else{
                                                    $days="about an hours";
                                                   }

                                                }else{
                                                    $checkminuts=floor($times/3600);
                                                    $days=$checkminuts." hrs";
                                                }
                                                
                                            }elseif($days==1) {
                                                   $days='Yesterday at '.$gettimepost;
                                            }elseif($days>1){
                                                    if($years==0){
                                                    $days=date('d M', strtotime($date1))." at ".$gettimepost;
                                                   }else{
                                                    $days=date('d-m-y h:i A', strtotime($date1))." at ".$gettimepost;
                                                   }
                                                }
                                                ?>
                                              {!! $days !!} </span>
                                           </div>
                                            @endforeach
                                          @endforeach
                                        @endif
                                        </div>
                                        <div class="dd-post-footer fw">
                                            <ul>
                                                <li><a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-{{$postvalues->id}}" data-like='{"p_id":"<?php echo $postvalues->id ?>","l_status":"0","p_uid":"<?php echo $uids ?>"}'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp; Like</a></li>
                                                <li><a href="#." id="maincomment-{{$postvalues->id}}"  onclick="chide(this)"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;@php($commentcount = $timelinePostController->totalcomment(['commetid'=>$postvalues->id]))

                                                {{$commentcount}}Comment</a></li>
                                                 <li><a href="javascript:void(0);" data-toggle="popover" data-animation="true" data-html="true" data-placement="bottom" data-content="<ul><li><a href='javascript:void(0);' onclick='SharePost(this)' id='sharenow-{{$postvalues->id}}'>Share Now </a></li><li><a href='javascript:void(0);'  id='share-{{$postvalues->id}}'  data-toggle='modal' data-target='#sharewithcontent' onclick='getpostid(this)' >Share </a></li></ul>" class="onclickpohover" title="Share"><i class="fa fa-share-square-o" aria-hidden="true" ></i>&nbsp;Share</a></li>
                                       
                                            </ul>
                                        </div>
                                        
                                        <div class="dd-comments-holder postid{{$postvalues->id}}">
                                            <div class="dd-show-likes">
                                                <a href="#."><i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;{{ $totallikes }} Likes</a>
                                            </div>
                                        </div> 
                                        <div class="dd-comments-holder postid{{$postvalues->id}}" id="commentbox-{{$postvalues->id}}" style="display:none">
                                           
                                            <div class="dd-write-comment"> 
                                               

                                               @for($i=0;$i<sizeof($comments);$i++)
                                                
                                                    @foreach ($comments[$i] as $value) 
                                                        
                                                        @if($postvalues->id == $value->content_id)
                                                           
                                                                @php ($userinfo = $data['userdatabyid']->getUserData(['id'=>$value->comment_userid]))
                                                                    <!-- {{$userinfo}} -->
                                                                    <div class="row" >
                                                                        @foreach($userinfo as $xys)
                                                                            <figure class="dd-comment-avater-holder">
                                                                                    @if($xys->avatar=='')     
                                                                                        <img src="/css/assets/img/profile-image.jpg" alt="" width="60">
                                                                                   
                                                                                    @else
                                                                                   
                                                                                       
                                                                                        <img src="{{ $xys->avatar }}" alt="Image" class="img-responsive media-object img-circle" width=60>
                                                                                     
                                                                                    @endif   
                                                                            </figure>  
                                                                            <div  class="comment-info" style="width:655px;">                                                                                        
                                                                                <a href="{{url('/search')}}/{{$xys->id}}/{{$xys->name}}"  >
                                                                                  <!-- display role name -->
                                                                                  {{ $data['rolename']->getRoleName(['id'=>$xys->role_id])}}{{$xys->name}}</a><br> 

                                                                                    {{$value->comment}}   <br> 
                                                                                     @php($countlikepost=$data['countlike']->TotalLikeByPostId(['content_id'=>$value->id,'type'=>1]))
                                                                                     <div class="dd-comment-footer fw"> 
                                                                                        <ul>
                                                                                            <li><a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-{{$value->id}}"  data-like='{"p_id":"<?php echo $value->id ?>","l_status":"1","p_uid":"<?php echo $uids ?>"}'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>{{$countlikepost}} Like</a></li>
                                                                                            <li><a href="#." class="comment"  id="mainrepy-{{$value->id}}"  onclick="rhide(this)"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;@php($replycount= $timelinePostController->replycount(['commetid'=>$value->id]))

                                                {{$replycount}} Reply</a></li>
                                                                                            <li>
                                                                                                    <?php $commentdate=$value->updated_at;
                                                                                                                $cdate1 = date('Y-m-d H:i:s', strtotime($commentdate));
                                                                                                                $cdate2 = date("Y-m-d H:i:s");
                                                                                                                $cdiff = abs(strtotime($cdate2) - strtotime($cdate1));

                                                                                                                $cyears = floor($cdiff / (365*60*60*24));
                                                                                                                $cmonths = floor(($cdiff - $cyears * 365*60*60*24) / (30*60*60*24));
                                                                                                                $cdays = floor(($cdiff - $cyears * 365*60*60*24 - $cmonths*30*60*60*24)/ (60*60*24));
                                                                                                                $ctimes=abs(strtotime($cdate2)-strtotime($cdate1));
                                                                                                                $cgettimepost = date('h:i A', strtotime($cdate1));
                                                                                                                if($cdays==0){
                                                                                                                    $cdays=$ctimes;
                                                                                                                    if($ctimes<60)
                                                                                                                    {
                                                                                                                        $cdays=$ctimes." seconds ago";
                                                                                                                    }elseif($ctimes<3600){
                                                                                                                        $checkminuts=floor($ctimes/60);
                                                                                                                        if($checkminuts<59){
                                                                                                                                $cdays=$checkminuts."  minutes ago";
                                                                                                                        }else{
                                                                                                                        $cdays="about an hours afo";
                                                                                                                       }

                                                                                                                    }else{
                                                                                                                        $checkminuts=floor($ctimes/3600);
                                                                                                                        $cdays=$checkminuts." hrs ago";
                                                                                                                    }
                                                                                                                    
                                                                                                                }elseif($cdays==1) {
                                                                                                                       $cdays='Yesterday at'." ".$gettimepost;
                                                                                                                }elseif($cdays>1){
                                                                                                                        if($cyears==0){
                                                                                                                        $cdays=date('d M', strtotime($cdate1))." at ".$cgettimepost;
                                                                                                                       }else{
                                                                                                                        $cdays=date('d-m-y h:i A', strtotime($cdate1))." at ".$cgettimepost;
                                                                                                                       }
                                                                                                                    }
                                                                                                                 ?>
                                                                                                                {!! $cdays !!}
                                                                                               
                                                                                            </li>                    
                                                                                           </ul>   
                                                                                    </div>   
                                                                                     <br> <br>
                                                                                     <!-- REPLEIS SECTOION OF COMMENT -->
                                                                                 <div id="replybox-{{$value->id}}" style="display:none" >
                                                                                    @foreach($comments as $replies)
                                                                                        @foreach($replies as $allreplies)
                                                                                            @if($value->id == $allreplies->content_id)
                                                                                             @php($countlikereply=$data['countlike']->TotalLikeByPostId(['content_id'=>$allreplies->id,'type'=>1]))
                                                                                                <div>
                                                                                                    @php ($replyuserinfo = $data['userdatabyid']->getUserData(['id'=>$value->comment_userid]))
                                                                                                    <div class="row" >
                                                                                                        @foreach($replyuserinfo as $replyuser)
                                                                                                            <figure class="dd-reply-avater-holder">
                                                                                                                    @if($replyuser->avatar=='')     
                                                                                                                        <img src="/css/assets/img/profile-image.jpg" alt="" width="30">
                                                                                                                   
                                                                                                                    @else
                                                                                                                   
                                                                                                                       
                                                                                                                        <img src="{{ $xys->avatar }}" alt="Image" class="img-responsive media-object img-circle" width='30'>
                                                                                                                     
                                                                                                                    @endif   
                                                                                                            </figure>  
                                                                                                            <div  class="replybox">                                                                                        
                                                                                                                <a href="{{url('/search')}}/{{$xys->id}}/{{$xys->name}}">
                                                                                                                  <!-- display role name -->
                                                                                  {{ $data['rolename']->getRoleName(['id'=>$xys->role_id])}} {{$xys->name}}</a><br>  
                                                                                                               {{$allreplies->comment}} <br> 

                                                                                                                 <div class="dd-comment-footer fw"> 
                                                                                                                    <ul>
                                                                                                                        <li><a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-{{$allreplies->id}}"  data-like='{"p_id":"<?php echo $allreplies->id ?>","l_status":"1","p_uid":"<?php echo $uids ?>"}'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>{{ $countlikereply }} Likes</a></li>
                                                                                                                        <li><a href="#." class="comment" onclick="subreplyhide({{$value->id}})"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;Reply</a></li>
                                                                                                                         <li>
                                                                                                                                <?php $commentdate=$allreplies->updated_at;
                                                                                                                                            $cdate1 = date('Y-m-d H:i:s', strtotime($commentdate));
                                                                                                                                            $cdate2 = date("Y-m-d H:i:s");
                                                                                                                                            $cdiff = abs(strtotime($cdate2) - strtotime($cdate1));

                                                                                                                                            $cyears = floor($cdiff / (365*60*60*24));
                                                                                                                                            $cmonths = floor(($cdiff - $cyears * 365*60*60*24) / (30*60*60*24));
                                                                                                                                            $cdays = floor(($cdiff - $cyears * 365*60*60*24 - $cmonths*30*60*60*24)/ (60*60*24));
                                                                                                                                            $ctimes=abs(strtotime($cdate2)-strtotime($cdate1));
                                                                                                                                            $cgettimepost = date('h:i A', strtotime($cdate1));
                                                                                                                                            if($cdays==0){
                                                                                                                                                $cdays=$ctimes;
                                                                                                                                                if($ctimes<60)
                                                                                                                                                {
                                                                                                                                                    $cdays=$ctimes." seconds ago";
                                                                                                                                                }elseif($ctimes<3600){
                                                                                                                                                    $checkminuts=floor($ctimes/60);
                                                                                                                                                    if($checkminuts<59){
                                                                                                                                                            $cdays=$checkminuts."  minutes ago";
                                                                                                                                                    }else{
                                                                                                                                                    $cdays="about an hours ago";
                                                                                                                                                   }

                                                                                                                                                }else{
                                                                                                                                                    $checkminuts=floor($ctimes/3600);
                                                                                                                                                    $cdays=$checkminuts." hrs";
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            }elseif($cdays==1) {
                                                                                                                                                   $cdays='Yesterday at'." ".$gettimepost;
                                                                                                                                            }elseif($cdays>1){
                                                                                                                                                    if($cyears==0){
                                                                                                                                                    $cdays=date('d M', strtotime($cdate1))." at ".$cgettimepost;
                                                                                                                                                   }else{
                                                                                                                                                    $cdays=date('d-m-y h:i A', strtotime($cdate1))." at ".$cgettimepost;
                                                                                                                                                   }
                                                                                                                                                }
                                                                                                                                             ?>
                                                                                                                                            {!! $cdays !!}
                                                                                                                           
                                                                                                                        </li>                 
                                                                                                                    </ul>   
                                                                                                                </div>  
                                                                                                            </div> 
                                                                                                        @endforeach
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif    
                                                                                        @endforeach        
                                                                                    @endforeach
                                                                                    <textarea  class="form-control" id="{{$value->id}}" onclick="this.select()"  onKeyDown="if(event.keyCode==13)  reply(this);"  placeholder="Write a Reply Here..." rows="1" name="comment" ></textarea>
                                                                                   </div>
                                                                            </div>

                                                                         @endforeach 
                                                                    </div>                                                                                                                                                
                                                        @endif
                                                    @endforeach
                                                @endfor    
                                                
                                                <div >
                                                    <textarea  class="form-control commentarea"  id="{{$postvalues->id}}" onclick="this.select()"  onKeyDown="if(event.keyCode==13)  comments(this);"  placeholder="Write a comment..." rows="1" name="comment" ></textarea>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                @endforeach
                                @endforeach
                            @else
                            
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4 pl-pr dd-scroll-contents text-center">
                    @include('user.sidebar')
                </div3
        </div>
    </div>
</section>

@endsection

