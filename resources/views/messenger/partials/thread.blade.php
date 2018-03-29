<?php 
    if ($threads->count()>0) :
        foreach ($threads as $key => $thread) : 
?>
    <?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; 
    //get connected user id 
    $userid=0;
     
    $userdata=$messageController->getAvatarAttribute($thread->id);   
    
    ?>
    <li class="active bounceInDown">
        <!-- <a href="{{ route('messages.show', $thread->id) }}" class="clearfix"> -->
        <a href="javascript:void(0);" class="clearfix" id="<?php echo str_replace(' ', '-', $thread->participantsString(Auth::id()) ).'-'.$thread->latestMessage->user_id; ?>" onclick="openChatBox(this, '<?php echo $thread->participantsString(Auth::id()); ?>', '<?php echo $thread->latestMessage->thread_id; ?>', '<?php echo Auth::user()->id; ?>','<?php echo $thread->id;?>');">
            
            <img src="{{isset($userdata) ?  $userdata : '/css/assets/img/profile-image.jpg' }}" alt="" class="img-circle">
            <div class="friend-name">   
                <strong>{{ $thread->participantsString(Auth::id()) }}</strong>
                <?php 
                    if ($userOnlineStatus->count() > 0) :
                        foreach ($userOnlineStatus as $key => $userOnline): 
                            if($userOnline->user_id == $thread->getParticipantId($thread->id,Auth::id())): 
                ?>
                     <span id="thread-user-is-active"><i class="fa fa-circle" aria-hidden="true"></i></span>
                <?php 
                            endif;
                        endforeach;
                    endif;
                ?>
            </div>
            <?php $isDeleteMessage = $messageController->isMessageDelete($thread->latestMessage->id,$thread->latestMessage->thread_id); ?>
            <?php if(!$isDeleteMessage): ?>
                <div class="last-message text-muted">{{ $thread->latestMessage->body }}</div>
                <small class="time text-muted">{{ $thread->latestMessage->created_at->diffForHumans()}}</small>
            <?php endif; ?>
            @if($thread->userUnreadMessagesCount(Auth::id()))
                <span class="unread-msg chat-alert label label-danger">{{ $thread->userUnreadMessagesCount(Auth::id()) }}</span>
            @endif        
        </a>
    </li>
<?php     
        endforeach; 
    endif;
?>









<?php /* ?>


<div class="col-md-8 bg-white ">
    <div class="chat-message">
        <h4 class="media-heading">
            <a href="{{ route('messages.show', $thread->id) }}">
                {{ $thread->participantsString(Auth::id()) }}
                @if($thread->userUnreadMessagesCount(Auth::id()))
                    <span class="unread-msg chat-alert label label-danger">{{ $thread->userUnreadMessagesCount(Auth::id()) }}</span>
                @endif
            </a>
        </h4>
        <ul class="chat">
            <li class="left clearfix">
                <!-- <span class="chat-img pull-left">
                    <img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="primary-font">John Doe</strong>
                        <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div> -->
                <p>
                    {{ $thread->latestMessage->body }}
                </p>
                <!-- <p>
                    <small><strong>Creator:</strong> {{ $thread->creator()->name }}</small>
                </p>
                <p>
                    <small><strong>Participants:</strong> {{ $thread->participantsString(Auth::id()) }}</small>
                </p> -->
            </li>
                              
        </ul>

    </div>
</div>  

<?php */ ?>






