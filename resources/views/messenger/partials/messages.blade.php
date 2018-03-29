<?php if(sizeof($data['thread']->messages)>0):
    foreach ($data['thread']->messages as $key => $message) {
        $isMessageDelete = $data['messageController']->isMessageDelete($message->id,$message->thread_id);
        if($message->user_id == Auth::user()->id && $message->body != '' && !$isMessageDelete){ 
?>
            <div class="row msg_container base_sent">
                <div class="col-md-10 col-xs-10 pad-0">
                    <div class="messages msg_sent">
                        <p>{{ $message->body }}</p>
                        <time datetime="{{ $message->created_at->diffForHumans() }}">{{ $message->created_at->diffForHumans() }}</time>
                        @if($message->is_read)
                            <p id="read-message">
                                <span class="fa-stack text-success">
                                    <i class="fa fa-check check-1"></i>
                                    <i class="fa fa-check check-2"></i>
                                </span>
                            </p>
                        @else
                            <p id="unread-message">
                                <span class="fa-stack">
                                    <i class="fa fa-check check-1"></i>
                                    <i class="fa fa-check check-2"></i>
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 col-xs-2 avatar pad-0">        
                    <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=64" alt="{{ $message->user->name }}" class="img-responsive" width="30px">
                </div>
            </div>
        <?php }elseif($message->body != '' && !$isMessageDelete){ ?>
            <div class="row msg_container base_receive">
                <div class="col-md-2 col-xs-2 avatar pad-0">
                    <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                </div>
                <div class="col-md-10 col-xs-10 pad-0">
                    <div class="messages msg_sent">
                        <p>{{ $message->body }}</p>
                        <time datetime="{{ $message->created_at->diffForHumans() }}">{{ $message->created_at->diffForHumans() }}</time>                
                    </div>
                </div>
            </div>
        <?php } ?>
<?php } 
    endif;
?>