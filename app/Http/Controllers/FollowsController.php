<?php

namespace App\Http\Controllers;

use View;
use Auth;
use File;
use Illuminate\Http\Request;
use App\UserMetum;
use App\User;
use App\UserConnection;
use App\Reviews;
use DB;
use App\Http\Controllers\RoleController;
use App\UserFollow;
use App\Notification;

class FollowsController extends Controller
{

    public function followings(Request $request)
    {
       
        /* Cover Image */
        $data['userMetaObj'] = new UserMetum();
        $data['userdatabyid']=new User();
         $data['user-role'] =new UserController(); 
        $data['searchview'] =new SearchViewController();
           $data['rolename']=new RoleController();
         $uid = Auth::user()->id;
           $userid=0;
//Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
        $data['userid']='';
         if(Auth::check()){
                    $uid=Auth::user()->id;
          }else{
                     $uid=$data['userid'];
          }
$data['countrequests']=0;
        $data['username']='';
        if($data['searchview']->getPhoto('cover',$uid)){
            $data['cover-image']= $data['searchview']->getPhoto('cover',$uid);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if($data['searchview']->getPhoto('profile', $userid)){
            $data['profile-image']= $data['searchview']->getPhoto('profile',$userid);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   
        
        $data['usergeneralinfo']  = $data['searchview']->getUserGeneralInfo($userid);
       $data['userlist']=UserConnection::where([['connect_user_id', '=',Auth::user()->id ],['status','=',1]])->orwhere([['user_id', '=',Auth::user()->id ],['status','=',1]])->get();
        $data['userAllMetaData']  = $data['searchview']->getUserInformation($userid);
        $data['userPostExperience']= $data['searchview']->getUserPostExperience($userid);  
        $data['userProfessionalStatement']= $data['searchview']->getUserProfessionalStatement($userid);  
        $countrequest=UserConnection::where([['user_id', '=', $uid],['user_id','=',$userid],['status','=',0]])->count();
        if($countrequest>0){
            $data['friendrequest']=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$userid]])->get();
        }else{

            $data['friendrequest']="no";
        }
        /****receiver***/
         $countrequest1=UserConnection::where([['user_id', '=', $userid],['connect_user_id','=',$uid]])->count();
        if($countrequest1>0){
            $data['friendrequest']=UserConnection::where([['user_id', '=', $userid],['connect_user_id','=',$uid]])->get();
        }
    $data['reviewss']='no';
        //$uid=Auth::user()->id;
    $uid=$data['userid'];
         $reviewscount=Reviews::where('user_id', '=', $uid)->count();
        if($reviewscount>0){

            $data['reviewss']=Reviews::where('user_id', '=', $uid)->get();
        }else{
            $data['reviewss']='no';
        }
      /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
     
        $data['userfollow']=new UserFollow();
         $data['userfollowing']=UserFollow::where('follow_user_id','=',Auth::user()->id)->get();
        return view('user.following',compact('data','searchdropdown'));
    }
 public function followers(Request $request)
    {
       
        /* Cover Image */
        $data['userMetaObj'] = new UserMetum();
        $data['userdatabyid']=new User();
         $data['user-role'] =new UserController(); 
        $data['searchview'] =new SearchViewController();
           $data['rolename']=new RoleController();
         $uid = Auth::user()->id;
//Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
           $userid=0;
        $data['userid']='';
         if(Auth::check()){
                    $uid=Auth::user()->id;
          }else{
                     $uid=$data['userid'];
          }
$data['countrequests']=0;
        $data['username']='';
        if($data['searchview']->getPhoto('cover',$uid)){
            $data['cover-image']= $data['searchview']->getPhoto('cover',$uid);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if($data['searchview']->getPhoto('profile', $userid)){
            $data['profile-image']= $data['searchview']->getPhoto('profile',$userid);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   
        
        $data['usergeneralinfo']  = $data['searchview']->getUserGeneralInfo($userid);
       $data['userlist']=UserConnection::where([['connect_user_id', '=',Auth::user()->id ],['status','=',1]])->orwhere([['user_id', '=',Auth::user()->id ],['status','=',1]])->get();
        $data['userAllMetaData']  = $data['searchview']->getUserInformation($userid);
        $data['userPostExperience']= $data['searchview']->getUserPostExperience($userid);  
        $data['userProfessionalStatement']= $data['searchview']->getUserProfessionalStatement($userid);  
        $countrequest=UserConnection::where([['user_id', '=', $uid],['user_id','=',$userid],['status','=',0]])->count();
        if($countrequest>0){
            $data['friendrequest']=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$userid]])->get();
        }else{

            $data['friendrequest']="no";
        }
        /****receiver***/
         $countrequest1=UserConnection::where([['user_id', '=', $userid],['connect_user_id','=',$uid]])->count();
        if($countrequest1>0){
            $data['friendrequest']=UserConnection::where([['user_id', '=', $userid],['connect_user_id','=',$uid]])->get();
        }
    $data['reviewss']='no';
        //$uid=Auth::user()->id;
    $uid=$data['userid'];
         $reviewscount=Reviews::where('user_id', '=', $uid)->count();
        if($reviewscount>0){

            $data['reviewss']=Reviews::where('user_id', '=', $uid)->get();
        }else{
            $data['reviewss']='no';
        }
      /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
     
        $data['userfollow']=new UserFollow();
   
        $data['userfollowers']=UserFollow::where('follower_user_id','=',Auth::user()->id)->get();
        return view('user.followers',compact('data','searchdropdown'));
    }
   
/****Follow user ***/
public function followuser(Request $request){
      
    $text='';
    $countfollow=UserFollow::where([['follow_user_id','=',Auth::user()->id],['follower_user_id','=',$request->getdata]])->count();
    if($countfollow>0){
        $countfollow=UserFollow::where([['follow_user_id','=',Auth::user()->id],['follower_user_id','=',$request->getdata]])->delete();
        $text="Request Follow";
    }else{
        $userrefer=new UserFollow();
        $userrefer->follow_user_id=Auth::user()->id;
        $userrefer->follower_user_id=$request->getdata;
        $userrefer->save();
        $text='Following';  
    }
    
return response()->json($text);
}

}