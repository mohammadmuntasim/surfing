<?php if($message->user_id == Auth::user()->id){     ?>

    <div class="row msg_container base_sent">
        <div class="col-md-10 col-xs-10 pad-0">
            <div class="messages msg_sent">
                <p>{{ $message->body }}</p>
                <time datetime="{{ $message->created_at->diffForHumans() }}">{{ $message->created_at->diffForHumans() }}</time>
            </div>
        </div>
        <div class="col-md-2 col-xs-2 avatar pad-0">        
            <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=64" alt="{{ $message->user->name }}" class="img-responsive" width="30px">
        </div>
    </div>
<?php }else{ ?>
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