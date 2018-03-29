<?php

namespace App\Http\Controllers;

use File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;
use Auth;
use DB;
use App\Http\Requests;
use DateTime;
use View;
use Response;
use Input;
use App\UserMetum;
use App\UserConnection;
use App\User;
use App\Reviews;
use App\UserRefer;
use App\UserFollow;
use App\UserMedia;
use App\Notification;
use App\TimelinePost;
use App\UserComment;
use App\ConnectionTimelinePost;
use App\TimelinePostLike;
use App\TimelineSharePost;
use App\UserAlbum;
class AjaxControllerRequest extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
             
    }
 public function index(Request $request)
    {
        $uid = Auth::user()->id;
        $userid = Auth::user()->id;
        $userMetaObj = new UserMetum(); 
        $userMetaObj2 = new User();  
        $data['encrypt']=new EndecryptController();
    //Notification
        $data['userid']='';
         // current user id
        $usercontroller = new UserController();
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
         // current user id
            $data['currentUserid']=''; 
            if(isset($_GET['ref_app'])){
              if(!empty($_GET['ref_app'])){
                $val=$data['encrypt']->decryptIt($_GET['ref_app']);
                $data['currentUserid']=$val;
              }else{
                $data['currentUserid']=Auth::user()->id;
              }
              
            }else if(!empty($data['userid'])){
             $data['currentUserid']=$data['userid'];
              }else{
              $data['currentUserid']=Auth::user()->id;
            }
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
        $userController = new UserController(); 
        $data['userfollow']=new UserFollow();
       $data['rolename']=new RoleController();
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
         /****check friend request exist or not ***/
        $data['friendrequest']="";
        $data['countrequests']=0;
        $data['userfriendlist']="";
        $data['userfriendlistcount']=0;

        /****check status 0 means request pending ***/
        $countrequest1=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->count();
        $data['userMetaObj']= $userMetaObj;
        $data['userMetaObj2']  =  $userMetaObj2;
        if($countrequest1>0){
            $data['friendrequest']=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->orderBy('id', 'DESC')->get();
             $data['countrequests']=$countrequest1;
        }else{
             $data['countrequests']=0;
        }


        /****show friend list ***/
        $countrequest2=DB::table('user_connections')->where('status', '=', '1')->where(
        function ($query) use($uid) { 
            $query->where('user_id', '=', $uid)->orWhere('connect_user_id', '=', $uid);
        })->count();
    
        if($countrequest2>0){
            $data['userfriendlist']=DB::table('user_connections')->where('status', '=', '1')->where(
        function ($query) use($uid) { 
            $query->where('user_id', '=', $uid)->orWhere('connect_user_id', '=', $uid);
        })->get();
             $data['userfriendlistcount']=$countrequest2;
        }else{
             $data['userfriendlistcount']=0;
        }
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

         return view('user.viewrequest',compact('data','searchdropdown'));
    }

/****people Search by name **/
public function autocomplete(Request $request)
    {
        $term=$request->term;
        $data = User::where('name','LIKE','%'.$term.'%')->where('id','<>',1)
        ->take(15)
        ->get();
        $a1=array();
        $a2=array();
        foreach ($data as $key => $v){
        $a1[]=['value' =>$v->name];
        }

        return response()->json($a1);
}


/****refer user ***/
public function referuser(Request $request){
   
    //print_r($receivid);
    $text='';
    $userrefer=new UserRefer();
    $userrefer->sender_user_id=Auth::user()->id;
    $userrefer->receiver_user_id=$request->getdata;
    $userrefer->refer_user_id=$request->docid;
    $userrefer->save();
    $last_id=$userrefer->id;
    $docname=User::where('id','=',$request->docid)->get();
    foreach ($docname as $docnamevalue) {
        $text='You are Refer Dr. '.$docnamevalue->name;
    }
       $userrefer= $userrefer->id;
            $images='';
            if(Auth::user()->avatar==''){
              $images='css/assets/img/default-avater.png';
            }else{
              $images=Auth::user()->avatar;
            }
    //Notification
       $data['getNotification']=new Notification();
            $getname=User::where('id','=',$request->docid)->get();
            $name='';
            foreach( $getname as $username){
            $name=$username->name;
            }
              $messagess='<figure class="dd-note-avater">
                          <img src="'.$images.'" alt="'.Auth::user()->name.'">
                          </figure>
                          <div class="dd-note-content">
                          <a href="search/'.Auth::user()->id.'/'.Auth::user()->name.'">'.Auth::user()->name.'</a> has referred you to <a href="search/'.$request->docid.'/'.$name.'">'.$name.'</a></div> ';
          $data['addNotification']=$data['getNotification']->createNotification($request->getdata,$last_id,4);

return response()->json($text);
}

/****Delete Media Image user ***/
public function deletemediaimage(Request $request){
     
    $text='';

    $getpostid=TimelinePost::where('media_id','=',$request->imgid)->get();
    $postid=0;
    foreach ($getpostid as $key => $getpostidvalue) {
      $postid=$getpostidvalue->id;
     
      $removeimage=UserComment::where('content_id','=',$postid)->delete();
      $removeimage=TimelinePostLike::where('content_id','=',$postid)->delete();
      $removeimage=TimelineSharePost::where('post_id','=',$postid)->delete();
      $removeimage=ConnectionTimelinePost::where('post_id','=',$postid)->delete();
    }
     $removeimage=TimelinePost::where('media_id','=',$request->imgid)->delete();
     $getimage=0;
     //delete image from media table
    $removeimage=UserMedia::where('id','=',$request->imgid)->get();
    if(sizeof($removeimage)>0){
        
        
        foreach ($removeimage as $key => $valueImage) {
           //check if album have last image
            $getimage=UserMedia::where('album_id','=',$valueImage->album_id)->count();
            if($getimage==1){
              //delete all post if album deleted 
             
              $text=1;
              $albumId=$valueImage->album_id;
              $getpostid=TimelinePost::where('media_id','=',$albumId)->where('post_type','=',1)->get();
              $postid=0;
              foreach ($getpostid as $key => $getpostidvalue) {
                $postid=$getpostidvalue->id;
               
                $removeimage=UserComment::where('content_id','=',$postid)->delete();
                $removeimage=TimelinePostLike::where('content_id','=',$postid)->delete();
                $removeimage=TimelineSharePost::where('post_id','=',$postid)->delete();
                $removeimage=ConnectionTimelinePost::where('post_id','=',$postid)->delete();
              }
               $removeimage=TimelinePost::where('media_id','=',$albumId)->where('post_type','=',1)->delete();
               $removeimage=UserAlbum::where('id','=',$albumId)->delete();
               $getimage=UserMedia::where('album_id','=',$valueImage->album_id)->delete();
              

            }
        }
        $removeimage=UserMedia::where('id','=',$request->imgid)->delete();
       
    }
    
    return response()->json($text);
  
  }
}
