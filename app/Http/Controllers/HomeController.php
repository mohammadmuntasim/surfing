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
use App\ConnectionTimelinePost;
use App\UserComment;
class HomeController extends Controller
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
        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
        $data['userMetaObj'] = new UserMetum(); 
        $roleController = new RoleController(); 
        $userController = new UserController(); 
        $timelinePostController = new TimelinePostController();
        $data['myphotos'] = new UserMedia();
        $data['otherUserTimelinePosted']=new ConnectionTimelinePost();
        //add new post
         $newpost='';
        if(empty($request->shareid)){
            if (!empty($request->content) || !empty($request->post_image)) {
                $newpost = $timelinePostController->createNewPost($request); 
            }
        }
        $postblog = $timelinePostController->getAllPost($uid); 
        
        $data['sharedpost']=new TimelineSharePost();
        $data['countlike']=new TimelinePostLike();
        $data['checkconnection']=new UserConnection();
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
         //$postblog['timeline_post']=TimelinePost::orderBy('id','desc')->paginate(4);
                $html='';
                if(!empty($postblog['timeline_post'])){
        foreach($postblog['timeline_post'] as $key => $postvalues){
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
             $data['userComment']= New UserComment();
            $html.=view('user.timeline.timeline-ajax-post',compact('data','sharepost','uid','postvalues','userController','userpic','comments','timelinePostController','parentPostCreatedTime'))->render();
         
        }
        
      }

       
        if ($request->ajax()) {
            return $html;
        }elseif ($newpost!='') {
        return redirect()->back();
        } else{
            return view('home',compact('data','postblog','userMetaObj','userController','searchdropdown','userpic','comments','timelinePostController','notification'));  
        }
       
        
    }

    public function timelinepost()
    {  
        $uid = Auth::user()->id;  
        $userMetaObj = new UserMetum(); 
        $roleController = new RoleController(); 
        $userController = new UserController(); 
        $timelinePostController = new TimelinePostController();
        $postblog = $timelinePostController->getPostByUid($uid);    
        $comments =  $timelinePostController->getComment($postblog);
        $data['userdatabyid']=new User();
        $data['userfollow']=new UserFollow();
        $data['rolename']=new RoleController();


       //Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
        $data['countlike']=new TimelinePostLike();
        $data['sharedpost']=new TimelineSharePost();
        $userInfoObj = $userController->getUserInformation();
        $specialist = '';        
        $hospital = '';        
        if (!empty($userInfoObj) && Auth::user()->role_id != 3) { 
            //$specialist = $userInfoObj['user_specialties'];
            //$hospital = $userInfoObj['user_hospital'];            
        }   
        /* Cover Image */
        if($userController->getPhoto('cover',Auth::user()->id)){
            $data['cover-image']= $userController->getPhoto('cover',Auth::user()->id);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if($userController->getPhoto('profile',Auth::user()->id)){
            $data['profile-image']= $userController->getPhoto('profile',Auth::user()->id);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   
       $data['userid']='';
       $data['countrequests']=0;
     /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
    /****check friend request exist or not ***/
        $data['friendrequest']="";
        $data['countrequests']=0;
        /****check status 0 means request pending ***/
        $countrequest1=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->count();
        if($countrequest1>0){
            $data['friendrequest']=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->get();
             $data['countrequests']=$countrequest1;
        }else{
             $data['countrequests']=0;
        }

        return view('user.timeline-post',compact('data','postblog','userMetaObj','userController','searchdropdown','comments','timelinePostController' ));
    }


    /*Common Page Call*/
    public function pages($slug = 'test')
    {
         if($slug != '')
         {
            $data['data'] = DB::table('pages')->where('slug', '=', $slug)->get();
            if ($data['data']->isEmpty()) 
            {
              return view::make('errors/404');
            }
            else{
                 $data['faqs'] = DB::table('faqs')->orderBy('faq_order', 'ASC')->get();
                 $data['soc']  = DB::table('socialicons')->where('status', '=', 'ACTIVE')->orderBy('order', 'ASC')->get();
                 return view::make('page_template')->with('data',$data);
            }
         }
         else{
             return view::make('errors/404');

         }         
    }
    
}
