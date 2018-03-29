<div class="row"  id="old-comment-hide-after-edit{{$commentId}}"> 
    @if(Auth::User()->id == $uid)
                    <div class="btn-group pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu">
                        <div class="arrow" style="left: 50%;"></div>
                    
                        <li>
                            <a href="javascript:void(0);" onclick="editcommentfunction(this)" id="editcomment" rel="editcomment-{{$commentId}}"><i class="fa fa-pencil" aria-hidden="true"></i>  Edit</a>
                        </li>
                        <li>
                             <a href="javascript:void(0);" onclick="deletecomment(this)" id="deletecomment-{{$commentId}}-{{$postId}}"><i class="fa fa-trash" aria-hidden="true"></i>  Delete</a>
                        </li>
                    </ul>
                    </div>
   @endif

    <figure class="dd-comment-avater-holder">
        <img src="<?php echo $userProf != '' ? $userProf : '/css/assets/img/profile-image.jpg' ?>" alt="" width="30" class="img-responsive media-object img-circle">
    </figure>
    <div class="comment-info" style="">
        <input type="hidden" value="{{$comment}}" id="updatedcomment{{$commentId}}">
        <a href="/search/<?php echo $uid; ?>/<?php echo $userName; ?>" gold=""><?php echo $userName; ?></a><br>
          
            <span id="myeditcomment{{$commentId}}">  <?php echo $comment; ?></span>
        <br>

        <div class="dd-comment-footer fw">
            <ul>
                <li>
                    <a href="javascript:void(0);" onclick="likepostfunct(this);" id="likepost-<?php echo $commentId; ?>" data-like='{"p_id":"<?php echo $commentId; ?>","l_status":"1","p_uid":"<?php echo $postUserId; ?>"}'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>0 Like</a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="comment" id="mainrepy-<?php echo $commentId; ?>" onclick="subreplyhide2({{$commentId}})"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;0 Reply</a>
                       </li>
                <li>
                    Just Now
                </li>
            </ul>
        </div>


        <div class="dd-comment-footer fw">
            <input type="hidden" value="{{$postId}}" id="Postid-of-Edited-Comment-{{$commentId}}">
            <textarea class="form-control" post="{{$postId}}" id="editcomment-{{$commentId}}" onclick="this.select()" onKeyDown="if(event.keyCode==13)  editcomments(this);" placeholder="Write a Reply Here..." rows="1" name="comment" style="display:none">{{$comment}}</textarea>
        </div>

        <br> <br>
            <!-- REPLEIS SECTOION OF COMMENT -->
            <div id="replybox-<?php echo $commentId; ?>" style="display:none">
            <textarea class="form-control" replyid="" post="{{$postId}}" id="<?php echo $commentId; ?>" onclick="this.select()" onkeydown="if(event.keyCode==13)  homereply(this);" placeholder="Write a Reply Here..." rows="1" name="comment"></textarea>
            </div>
        </div>
</div>