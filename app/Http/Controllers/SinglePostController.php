<?php

namespace App\Http\Controllers;

use DB;
use View;
use Auth;
use Illuminate\Http\Request;
use App\TimelinePost;
use App\UserMetum;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\TimelinePostController;
use App\UserConnection;
use App\TimelineSharePost;
use App\User;
use App\TimelinePostLike;
use App\UserMedia;
use App\UserFollow;
use App\Notification;
use Redirect;
class SinglePostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
        $uid = Auth::user()->id;  
        $userMetaObj = new UserMetum(); 
        $roleController = new RoleController(); 
        $userController = new UserController(); 
        $timelinePostController = new TimelinePostController();
        $data['myphotos'] = new UserMedia();
        //add new post
         $newpost='';
        if(empty($request->shareid)){
            if (!empty($request->content) || !empty($request->post_image)) {
                $newpost = $timelinePostController->createNewPost($request); 
            }
        }
        $postblog = $timelinePostController->getAllPost($uid); 
        
        $data['sharedpost']=new TimelineSharePost();
        $data['userdatabyid']=new User();
        $data['countlike']=new TimelinePostLike();
        $data['checkconnection']=new UserConnection();
       //Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
        $userInfoObj = $userController->getUserInformation();
         $userpic=new User();
      $comments =  $timelinePostController->getComment($postblog);

        $specialist = '';        
        $hospital = '';        
        if (!empty($userInfoObj) && Auth::user()->role_id != 3) {            
            //$specialist = $userInfoObj['user_specialties'];
            //$hospital = $userInfoObj['user_hospital'];            
        }             
        $data['profile-pic']    = $userController->getPhoto('profile',Auth::user()->id);       
        $data['user-role']      = $roleController->getRoleName(Auth::user()->role_id);
        $data['specialist']     = $specialist;
        $data['hospital']       = $hospital;
           /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
          $data['userfollow']=new UserFollow();
          $data['rolename']=new RoleController();
           $data['timlinepost']=new TimelinePost();
          /*****loadmore ***/
         $postblog['timeline_posts']=TimelinePost::where('id','=',$request->postid)->get();
                $html='';
               /* if(!empty($postblog['timeline_post'])){
        foreach($postblog['timeline_posts'] as $key => $postvalues){
          $usert=$postvalues->user_id;
          $uid=Auth::user()->id;
          $check1=array('user_id'=>$uid,'connect_user_id'=>$usert,'status'=>1 );
          $check2=array('user_id' => $usert,'connect_user_id'=>$uid,'status'=>1 );
             $data['checkconnected']=$data['checkconnection']->getConnnected($check1,$check2);           
             
             $mylikes=0;
             $totallikes = $userController->getUserPostLikeById(['content_id'=>$postvalues->id]);
             $totallikesme = $userController->getPostLikeByMe(['user_id'=>$uid,'content_id'=>$postvalues->id]);                             
             $sharepost=$data['sharedpost']->getPostShareData(['post_id'=>$postvalues->id]);  
             $parentPostCreatedTime = $userController->getParentPostCreatedTime($postvalues->id,$uid);
            $html.=view('user.timeline.timeline-ajax-post',compact('data','sharepost','uid','postvalues','userController','userpic','comments','timelinePostController','parentPostCreatedTime'));
         
        }
        
      }
*/

            return view('user.timeline.singlePost',compact('data','postblog','userMetaObj','userController','searchdropdown','userpic','comments','timelinePostController','notification'));  
        
       
        
    }

   
}
