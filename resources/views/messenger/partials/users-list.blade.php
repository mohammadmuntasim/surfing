<?php if($users->count() > 0): ?>
    <?php foreach($users as $user):
    //get connected user id 
    $userid=0;
    if($user->user_id==Auth::user()->id):
        $userid=$user->connect_user_id;
    else:
        $userid=$user->user_id;
    endif;

    $userdata=$data['userdatabyid']->getUserData(['id'=>$userid]);
    foreach ($userdata as $key => $valueuser):
            
    ?>
        <li class="bounceInDown">
            <a href="javascript:void(0);" class="clearfix" id="<?php echo str_replace(' ', '-', $valueuser->name ).'-'.$valueuser->id; ?>" onclick="openChatBox(this, '<?php echo $valueuser->name; ?>', '<?php echo $valueuser->id; ?>', '<?php echo Auth::user()->id; ?>');">

                <img src="{{isset($valueuser->avatar) ?  $valueuser->avatar : '/css/assets/img/profile-image.jpg' }}" alt="" class="img-circle">
                <div class="friend-name">   
                    <strong><?php echo $valueuser->name ?></strong>
                    <?php 
                        if ($userOnlineStatus->count() > 0) :
                            foreach ($userOnlineStatus as $key => $userOnline): 
                                if($userOnline->user_id == $valueuser->id): 
                    ?>
                         <span id="thread-user-is-active"><i class="fa fa-circle" aria-hidden="true"></i></span>
                    <?php 
                                endif;
                            endforeach;
                        endif;
                    ?>
                </div>                
                <div class="last-message text-muted">You are now connected.</div>                
            </a>
        </li> 


        <!-- <li class="bounceInDown">
            <a href=" <?php echo url('/messages/create?u=').$user->id; ?>" class="clearfix" id="">
                <img src="http://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
                <div class="friend-name">   
                    <strong><?php echo $user->name ?></strong>
                </div>                
                <div class="last-message text-muted">You are now connected.</div>
                
            </a>
        </li>  -->
    <?php endforeach;
    endforeach; ?>
<?php endif; ?> 