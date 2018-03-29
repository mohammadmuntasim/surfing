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
use App\UserFollow;
use App\Notification;
use App\AppointmentSetting;
use DateTime;
use App\TimelineSharePost;
use App\TimelinePostLike;
use App\UserMedia;
use App\Http\Controllers\UserController;
use App\TimelinePost;
use App\ConnectionTimelinePost;
class SearchViewController  extends Controller
{

    public function index(Request $request, $userid)
    {

                   
        
        /* Cover Image */
         $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
        $data['userMetaObj'] = new UserMetum();
        $data['user-role'] =new UserController(); 
        $data['myphotos'] = New UserMedia();
        $data['userConnections']=new UserConnection();
        $data['rolename']=new RoleController();
        $data['userfollow']=new UserFollow();
        $data['encrypt']=new EndecryptController();
        $data['sharedpost']=new TimelineSharePost();
        $myappoint = New AppointmentSetting();
        $timelinePostController = new TimelinePostController();
        $data['timlinepost']=new TimelinePost();
        //Notification
        $data['getNotification']=new Notification();
        $data['showNotification']=$data['getNotification']->getAllNotify($userid);
        $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($userid);
        //$uid = Auth::user()->id;
        $data['userid']=$userid;
        $data['otherUserTimelinePosted']=new ConnectionTimelinePost();
        $uid=$data['userid'];
         
        $data['username']=User::where('id', '=', $userid)->select('name')->get();
        if($data['user-role']->getPhoto('cover',$userid)){
            $data['cover-image']= $data['user-role']->getPhoto('cover',$userid);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if($data['user-role']->getPhoto('profile', $userid)){
            $data['profile-image']= $data['user-role']->getPhoto('profile',$userid);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   
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
        
        $data['usergeneralinfo']  = $this->getUserGeneralInfo($userid);
        $data['userAllMetaData']  = $this->getUserInformation($userid);
        $data['countlike']=new TimelinePostLike();
         
         
         //add new post
        $newpost='';
        if(empty($request->shareid)){
            if (!empty($request->content) || !empty($request->post_image)) {
                $newposts = $timelinePostController->createNewConnectionPost($request,$data['currentUserid']);
                
            }
        }
        $userpic=new User();
        $postblog = $timelinePostController->getPostByUid($userid); 
        $comments =  $timelinePostController->getComment($postblog);

        if(Auth::check()){
        //get user connected or not
        $data['getConnectedornot']=$data['userConnections']->getConnnected(Auth::user()->id,$userid);
        }else{
            $data['getConnectedornot']=0;
        }
        /****show get connection list ***/
        $data['userfriendlist']=$data['userConnections']->getUserConnectionList($uid);

        $data['reviewss']='no';
        //$uid=Auth::user()->id;
        $uid=$data['userid'];
        $reviewscount=Reviews::where('user_id', '=', $uid)->count();
        if($reviewscount>0){$userController = new UserController();
            $data['reviewss']=Reviews::where('user_id', '=', $uid)->orderBy('id', 'desc')->get();
            foreach ($data['reviewss'] as $key => $reviews) {
                if ($reviews->is_reply) {
                   $data['review_comments'][$reviews->id] = $userController->getReviewComments($reviews->id);
                }
            }
            /*echo "<pre>";
            print_r($data['review_comments']);
            echo "</pre>";
            exit();*/
        }else{
        $data['reviewss']='no';
        }
        



             /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
          $userController = new UserController(); 
          if(Auth::check()){
            $html='';
             $data['checkconnection']=new UserConnection();
                if(!empty($postblog['timeline_post'])){

           foreach($postblog['timeline_post'] as $key => $postvalues){
            //if($uid==$postvalues->user_id){
                //if(sizeof($data['getConnectedornot'])==1){
                // echo $postvalues->user_id;
                $totallikes = $userController->getUserPostLikeById(['content_id'=>$postvalues->id]);
                $totallikesme = $userController->getPostLikeByMe(['user_id'=>$uid,'content_id'=>$postvalues->id]);                             
                $sharepost=$data['sharedpost']->getPostShareData(['post_id'=>$postvalues->id]);         
                $parentPostCreatedTime = $userController->getParentPostCreatedTime($postvalues->id,$uid);
                $html.=view('user.timeline.timeline-ajax-post',compact('data','postvalues','sharepost','uid','userController','userpic','comments','timelinePostController','parentPostCreatedTime'));
            //}
           // }
        }
       
      }
    }

         if ($request->ajax()) {
            return $html;
        }elseif ($newpost!='') {
        return redirect()->back();
        }elseif(Auth::check()){
            if($userid==Auth::user()->id){
            return redirect()->action('UserController@index');
           }else{
            return view('user.shortprofileview',compact('myappoint','userpic','postblog','timelinePostController','comments','data','searchdropdown'));
           }
        }else{
        return view('user.shortprofileview',compact('myappoint','userpic','postblog','timelinePostController','comments','data','searchdropdown'));
        
     }
    }


   



   

    /* Get user Information */
    public function getUserGeneralInfo($userid)
    {
        /* Get user Data */
        $uid = $userid;
        $userMetaObj = new User();
       $userData = '';
        
            $userData = User::where('id', '=', $uid)->get();
        

          /* $userAllMetaData  = $userMetaObj->getUserMeta(['user_id' => $uid,'user_meta_key'=>'user_post_experience']);
        foreach ($userAllMetaData as $key => $userMetaData) {                
            $userData['user_post_experience'] = $userMetaData->user_meta_value;
        }     */
       
        return $userData;
    }

    /* Get user Information */
    public function getUserInformation($userid)
    {
        /* Get user Data */
        $uid = $userid;
        $userMetaObj = new UserMetum();
        $editArray = array('user_gender','user_fax_number','user_specialties','user_website','user_practice','user_location','user_address','user_city','user_state','user_county','user_zipcode','user_number','user_education','user_hospital','user_certification','user_memberships','user_company','user_website');
        $userData = '';
        foreach ($editArray as $key => $editDataKey) {            
            $userAllMetaData  = $userMetaObj->getUserMeta(['user_id' => $uid,'user_meta_key'=>$editDataKey]);
           // print_r($userAllMetaData);
            //exit();
            if($userAllMetaData=='[]'){
            foreach ($userAllMetaData as $key => $userMetaData) {                
                if ($editDataKey == $userMetaData->user_meta_key) {
                    $userData[$editDataKey] = $userMetaData->user_meta_value;
                }                
            }
        }
        }
        return $userData;
    }

    /* Get user Information */
    public function getUserPostExperience($userid)
    {
        /* Get user Data */
        $uid = $userid;
        $userMetaObj = new UserMetum();        
        $userData = '';                  
        $userAllMetaData  = $userMetaObj->getUserMeta(['user_id' => $uid,'user_meta_key'=>'user_post_experience']);
        if($userAllMetaData=='[]'){
        foreach ($userAllMetaData as $key => $userMetaData) {  

            $userData['user_post_experience'] = $userMetaData->user_meta_value;
        }   }
           
        return $userData;
    }
    /* Get user Professional Statement  */
    public function getUserProfessionalStatement($userid)
    {
        /* Get user Data */
        $uid = $userid;
        $userMetaObj = new UserMetum();        
        $userData = '';                  
        $userAllMetaData  = $userMetaObj->getUserMeta(['user_id' => $uid,'user_meta_key'=>'user_professional_statement']);
        if($userAllMetaData=='[]'){
        foreach ($userAllMetaData as $key => $userMetaData) {                
            $userData['user_professional_statement'] = $userMetaData->user_meta_value;
        }        
    }
        return $userData;
    }
   
}
