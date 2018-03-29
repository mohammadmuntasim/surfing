<div class="review-comment-row" id="review-comment-row-{{$commentId}}">
    <figure class="dd-comment-avater-holder">
        <img src="<?php echo $userProf != '' ? $userProf : '/css/assets/img/profile-image.jpg' ?>" alt="" width="30" class="img-responsive media-object">
    </figure>
    <div class="comment-info" style="">
        <a href="/search/<?php echo $uid; ?>/<?php echo $userName; ?>" gold=""><?php echo $userName; ?></a><br>
            <?php echo $comment; ?>
        <br>

        <div class="dd-comment-footer fw">
            <ul>                
                <li>
                    Just Now
                </li>
            </ul>
        </div>
        <br> 
    </div>
</div>