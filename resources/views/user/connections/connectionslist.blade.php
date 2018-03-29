 @if(sizeof($data['userfriendlist'])>0)
 
<div class="dd-reffers-holder dd-card fw mg-b15 user-connection">
    <div class="dd-title-holder ">
        <h3>Connections</h3>
    </div>
    <div class="dd-reffer-list-holder">
        <div class="dd-group-list-holder">
            @foreach($data['userfriendlist'] as $friendlist )
            @if($friendlist->user_id==$data['currentUserid'])
             @php($data['userid']=$friendlist->connect_user_id)
             @else
             @php($data['userid']=$friendlist->user_id)
            @endif
            @php($requestusernamelist=$data['userdatabyid']->getUserData(['id' =>$data['userid']]))
            @foreach($requestusernamelist as $requestusernamevaluelist)
            <?php $urlnameslist = str_replace(' ', '-',$requestusernamevaluelist->name); ?>

 @if(empty(app('request')->input('ref_app')))

            <div class="col-md-3 listimage">
                @else
                 <div class="col-md-2 listimage other-user">
                @endif
                <a  href="{{url('/search')}}/{{ $data['userid']}}/{{ $urlnameslist }}"> 
                    @if(!empty($data['userid']))
                    @php($data['usergeneralinfo']=$data['userdatabyid']->getUserData(['id'=>$data['userid']]))
            @foreach($data['usergeneralinfo'] as   $myusersdatad) 
            <?php $cv=explode('/', $myusersdatad->avatar);
                                $paths='';
                                    if($cv[0]=='users'){
                                        $paths='/storage/';
                                    }else{
                                    $paths='';
                                    }
                                    ?>                
            <img src="{{$paths}}{{ isset($myusersdatad->avatar) ?  $myusersdatad->avatar : '/css/assets/img/profile-image.jpg' }}" alt="surf health profile picture {{ isset($myusersdatad->name) ?  $myusersdatad->name : '' }}" id="profile-image-individiual">
            @endforeach
            @endif
            <div class="hovertext">
                    <h5>{{$requestusernamevaluelist->name}}</h5>
                    </div>
                </a>
            </div>

            @endforeach
            @endforeach
            
        </div>
    </div>
</div>
@else

<div class="dd-reffers-holder dd-card fw mg-b15 user-connection">
    <div class="dd-title-holder ">
        <h3>Connections</h3>
    </div>
    <div class="dd-reffer-list-holder">
        <div class="dd-group-list-holder">
            <div class="alert alert-danger">
               Don't have any connection.
            </div>
         </div>
    </div>
</div>

@endif