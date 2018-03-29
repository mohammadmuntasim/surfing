<?php

namespace App\Http\Controllers;
use DB;
use View;
use Illuminate\Contracts\Validation\Validator;
use App\TimelinePost;
use File;
use Exception;
use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\UserMetum;
use Mail;
use Voyager;
use App\ContactusInformation;
use App\User;
use App\Notification;
use App\UserFollow;
use App\UserConnection;
use App\Reviews;
use Response;
class ConnectionController  extends Controller
{

  public function index(Request $request)
    {
        
        $userid = Auth::user()->id;
        $userMetaObj = new UserMetum(); 
        $userMetaObj2 = new User();  
        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
        $data['encrypt']=new EndecryptController();
        $data['userConnections']=new UserConnection();
        $userController = new UserController(); 
        $data['userfollow']=new UserFollow();
       $data['rolename']=new RoleController();
    //Notification
        $data['userid']='';
         // current user id

       $searchcontroller = new SearchViewController();
            $data['currentUserid']=''; 
            if(isset($_GET['ref_app'])){
              if(!empty($_GET['ref_app'])){
                $val=$data['encrypt']->decryptIt($_GET['ref_app']);
                $data['currentUserid']=$val;
                $data['userid']=$val;
                $data['cover-image']='/css/assets/img/default-cover.jpg';
              }else{
                $data['currentUserid']=Auth::user()->id;
              }
              
            }else if(!empty($data['userid'])){
             $data['currentUserid']=$data['userid'];
              }else{
              $data['currentUserid']=Auth::user()->id;
            }
             $data['usergeneralinfo']  = $searchcontroller->getUserGeneralInfo($data['currentUserid']);
           $data['userAllMetaData']  = $searchcontroller->getUserInformation($data['currentUserid']);
         
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($userid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($userid);
        
        //$connectedUserArray = UserController::index($uid); 
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $userController->postCoverPhoto($request);
        }elseif($userController->getPhoto('cover',$data['currentUserid'])){
            $data['cover-image']= $userController->getPhoto('cover',$data['currentUserid']);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $userController->postProfilePhoto($request);
        }elseif($userController->getPhoto('profile',$data['currentUserid'])){
            $data['profile-image']= $userController->getPhoto('profile',$data['currentUserid']);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   

        $userid=$senderid= $request->uid;
        $uid =$data['currentUserid'];
         /****check friend request exist or not ***/
        $data['friendrequest']="";
        $data['countrequests']=0;
        $data['userfriendlist']="";
        $data['userfriendlistcount']=0;

        /****check status 0 means request pending ***/
       
        $data['userMetaObj']= $userMetaObj;
        $data['userMetaObj2']  =  $userMetaObj2;


               //get user connected or not
        $data['getConnectedornot']=$data['userConnections']->getConnnected(Auth::user()->id,$userid);

        /****show get connection list ***/
        $data['userfriendlist']=$data['userConnections']->getUserConnectionList($data['currentUserid']);
        $data['userfriendlistpending']=$data['userConnections']->getUserConnectionListPending($uid);

         $data['reviewss']='no';
        $uid=Auth::user()->id;
       //$uid=$data['userid'];
         $reviewscount=Reviews::where('user_id', '=', $uid)->count();
        if($reviewscount>0){

            $data['reviewss']=Reviews::where('user_id', '=', $uid)->get();
        }else{
            $data['reviewss']='no';
        }

        /**** search drop down ***/
        $searchdropdown=$userMetaObj2->getSearchDropdownList();
        $data['userdatabyid']=new User();
        $data['userfollow']=new UserFollow();
        $data['userfollowing']=UserFollow::where('follow_user_id','=',Auth::user()->id)->get();
        $data['userfollowers']=UserFollow::where('follower_user_id','=',Auth::user()->id)->get();

         return view('user.connections.connections',compact('data','searchdropdown'));
    }
//add connection
    public function ajaxrequests(Request $rt){
    $uid = Auth::user()->id;
    $senderid= $rt->id;    
    $timestamps = new DateTime();

    $catss='';
     $data['getNotification']=new Notification();
     $data['getuserConnection']=new UserConnection();
       
        $countrequest=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$senderid]])->count();
        if($countrequest>0){
            $catss="request already sent";
            $countrequest=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$senderid]])->pluck('id');
          
             $data['addNotification']=$data['getNotification']->deleteNotification($uid,$countrequest[0],1);
             $data['addNotification']=$data['getNotification']->deleteNotification($senderid,$countrequest[0],1);
             $deleterequest = $data['getuserConnection']->deleteUserConnection($countrequest[0]); 
             
        }else{
            $catss="no";          
             /****insert new share post ***/
              $addconnection= $data['getuserConnection']->setUserConnection($uid,$senderid);
              $last_id = $addconnection->id;
              $data['addNotification']=$data['getNotification']->createNotification($senderid,$last_id,1);
        }
       // return view::make('user.shortprofileview')->with('data',$catss);
        return Response::json($catss);
    //}
}
//remove user from my connection 
public function removeConnection(Request $raccept){
    $uid = Auth::user()->id;
    $senderid= $raccept->id;    
    $getremove='';
    $timestamps = new DateTime();
    $data['getNotification']=new Notification();
    $data['getuserConnection']=new UserConnection();
    $countrequest=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$senderid]])->orwhere([['user_id', '=', $senderid],['connect_user_id','=',$uid]])->pluck('id');
    if(sizeof($countrequest)>0){
    $getremove=$data['getNotification']->deleteNotification($uid,$senderid,1);

    $data['addNotification']=$data['getNotification']->deleteNotification($uid,$countrequest[0],1);
    $data['addNotification']=$data['getNotification']->deleteNotification($senderid,$countrequest[0],1);
    $deleterequest = $data['getuserConnection']->deleteUserConnection($countrequest[0]); 
    }
    return Response::json($getremove);
    
}

public function ajaxrequestsreposnse(Request $raccept){
    $uid = Auth::user()->id;
    $senderid= $raccept->uid;    
    $timestamps = new DateTime();
    $catss='';
    $breakdelete=explode('-', $senderid);
    $data['test']='';
     $data['getNotification']=new Notification();
    $data['getuserConnection']=new UserConnection();
      //check request exist or not
      $countrequest=UserConnection::where([['user_id', '=', $senderid],['connect_user_id','=',$uid],['status','=',0]])->get();
      //echo $countrequest;
      if(sizeof($countrequest)>0){
        $countrequest=UserConnection::where([['user_id', '=', $senderid],['connect_user_id','=',$uid],['status','=',0]])->pluck('id');
        $getremove=$data['getNotification']->deleteNotification($uid,$countrequest[0],1);
        $catss="yes";
        $data['test'] =UserConnection::where([['user_id', '=', $senderid],['connect_user_id','=',$uid],['status','=',0]])->update(  array(
          'status' => '1',
          'updated_at' =>$timestamps
          ));
          $getremove=$data['getNotification']->createNotification($senderid,$countrequest[0],1);
      }
      return Response::json( $data['test']);
}

/****connection list user ***/
public function connectionlist(Request $request){
    $senderid=Auth::user()->id;
    $doctorid=$request->doctorid;
    $results1='';
    $results='';
     $data['userfollow']=new UserFollow();
      $data['userlist']=UserConnection::where([['connect_user_id', '=',$senderid],['status','=',1]])->orwhere([['user_id', '=',$senderid],['status','=',1]])->get();
                    if(sizeof($data['userlist'])>0){
                    foreach($data['userlist'] as $userfriend){
                        $receiverid='';
                                if($userfriend->connect_user_id==$senderid){
                                    $receiverid=$userfriend->user_id;

                                }else{
                                    $receiverid=$userfriend->connect_user_id;
                                }
                                $displays='';
                                //hide doctor name 
                      if($receiverid==$doctorid){
                            $displays='style="display:none"';
                         }
                        $userinfo=User::where('id','=',$receiverid)->get();
                         foreach($userinfo as $showinfo){
                           
                        $results1= '<div class="col-md-6" '.$displays.'>
                        <div class="dd-grid-item">
                            <figure class="dd-grid-avater">';
                                 if($showinfo->avatar==''){
                              $results1.='<img src="'.url('/').'/css/assets/img/default-avater.png" alt="Surf Health Avater">';
                                }else{
                                $results1.=' <img src="'.url('/').$showinfo->avatar.'" alt="Surf Health Avater">';
                                }
                           $results1.='</figure><div class="dd-grid-content align-middle">';
                                
                                 $countsfollowing=UserFollow::where('follower_user_id','=',$receiverid)->count();
                               
                              $results1.= '<h4>'.$showinfo->name.'</h4>
                                <a class="btn btn-default" href="javascript:void(0)" onclick="ReferUser(this)" data-referuser="'.$receiverid.'">Refer</a>
                            </div>
                        </div>
                    </div>';
                   
                    }
                  $results.=$results1;
                    }
                  }else{
                    $results="No Connection List Found..";
                  }
                    return response()->json($results);
        

}
/****people Search by name **/
public function searchconnectname(Request $request)
    {
        $term=$request->refers;
       
        $doctorid=$request->doctorid;
        $results='';
         $data['userfollow']=new UserFollow();
         $displays='';
        $senderid=Auth::user()->id;
      $data['userlist']=UserConnection::where([['connect_user_id', '=',$senderid  ],['status','=',1]])->orwhere([['user_id', '=',$senderid  ],['status','=',1]])->get();
                    foreach($data['userlist'] as $userfriend){
                         $receiverid='';
                                if($userfriend->connect_user_id==$senderid){
                                    $receiverid=$userfriend->user_id;
                                }else{
                                     $receiverid=$userfriend->connect_user_id;
                                }

                            if($receiverid==$doctorid){
                            $displays='style="display:none"';
                            }
                    $userinfo=User::where([['name','LIKE','%'.$term.'%'],['id','=',$receiverid]])->get();
                    foreach($userinfo as $showinfo){

                   $results= '<div class="col-md-6" '.$displays.'>
                        <div class="dd-grid-item">
                            <figure class="dd-grid-avater">';
                                 if($showinfo->avatar==''){
                              $results.='<img src="'.url('/').'/css/assets/img/default-avater.png" alt="Surf Health Avater">';
                                }else{
                                $results.=' <img src="'.url('/').$showinfo->avatar.'" alt="Surf Health Avater">';
                                }
                               $results.='</figure><div class="dd-grid-content align-middle">';
                                
                               $countsfollowing=UserFollow::where('follower_user_id','=',$receiverid)->count();
                               
                              $results.= '<h4>'.$showinfo->name.'</h4>
                                <a class="btn btn-default" href="javascript:void(0)" onclick="ReferUser(this)" data-referuser="'.$receiverid.'">Refer</a>
                            </div>
                        </div>
                    </div>';
                    }
                    }

        return response()->json($results);
}
}