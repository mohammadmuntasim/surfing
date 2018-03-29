<div class="replies-section" >

    <div class="row" id="wholereply-{{$commentId}}">
       
        @if(Auth::User()->id == $uid)
        <div class="btn-group pull-right">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu">
                <div class="arrow" style="left: 50%;"></div>
                
               <li>
                    <a href="javascript:void(0);"  myreplyeditid="{{$commentId}}" onclick="editreplyfunction(this)" id="editreply" rel="editreply-{{$comment}}-{{$postId}}-{{$commentId}}"><i class="fa fa-pencil" aria-hidden="true"></i>  Edit</a>
                </li>
                <li>
                     <a href="javascript:void(0);" onclick="deletecommentorreply(this)" id="deletereply-{{$commentId}}-{{$postId}}"><i class="fa fa-trash" aria-hidden="true"></i>  Delete</a>
                </li>
            </ul>
        </div>
        @endif

        <figure class="dd-reply-avater-holder">
            <img src="<?php echo $userProf != '' ? $userProf : '/css/assets/img/profile-image.jpg' ?>" alt="<?php echo $userName; ?>" width="25" class="img-responsive media-object img-circle">
        </figure>
        <div class="replybox">
            <a href="/search/<?php echo $uid; ?>/<?php echo $userName; ?>"><?php echo $userName; ?></a>
            <br>  
                <span id="med-{{$commentId}}"><?php echo $comment; ?></span>
            <br> 
            <div class="dd-comment-footer fw">
                <ul>
                    <li>
                        <a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-<?php echo $commentId; ?>" data-like='{"p_id":"<?php echo $commentId; ?>","l_status":"1","p_uid":"<?php echo $postUserId; ?>"}'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>0 Likes</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="comment" onclick="subreplyhide(<?php echo $postId; ?>)"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;Reply</a>
                    </li>
                    <li>
                        Just Now
                    </li>
                </ul>
            </div>
        </div>
        <textarea  class="form-control" replyid="" post="{{$postUserId}}-{{$postId}}" id="editreplytextbox-{{$commentId}}" onclick="this.select()"  onKeyDown="if(event.keyCode==13)  editreply(this);"  placeholder="Write a Reply Here..." rows="1" name="comment" style="display:none"></textarea>
        </div>
</div>