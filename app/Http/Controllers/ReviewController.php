<?php

namespace App\Http\Controllers;

use App\User;
use Mail;
use DateTime;
use App\Reviews;
use Response;
use View;
use Auth;
use File;
use Illuminate\Http\Request;
use App\UserMetum;
use App\UserConnection;
use DB;
use App\UserFollow;
use App\Notification;
class ReviewController extends Controller
{

 public function __construct()
    {
        $this->middleware('auth');         
    }

     public function indexname(Request $request)
    { 
     if($request){
		
		$revmail='';
		$revname='';   
		$catss='';       
		$comment=\Request::get('comment');
		$overall=\Request::get('overall');
    $punctuality=\Request::get('punctuality');
    $knowledge=\Request::get('knowledge');
    $staff=\Request::get('staff');
		$uids=\Request::get('userid');
		$sendername=Auth::user()->name;
		$senderemail=Auth::user()->email;
		$checkreviews=Reviews::where([['user_id','=',$uids],['sender_id','=',Auth::user()->id]])->count();
		if($checkreviews==0){
		/****send mail to the receiver ****/
          $data = array(
		            'name' => $sendername ,
		            'email' => $senderemail,
		            'user_message' => $comment,
		            'overall' => $overall,
                'punctuality' => $punctuality,
                'knowledge' => $knowledge,
                'staff' => $staff
		        );
            $email = $request->get('email');

            Mail::send('emails.reviewsmail', $data, function($message) use ($email) {
            	$uids=\Request::get('userid');
            	
                $receiversdata=User::where('id', '=', $uids)->get();
                //print_r($receiversdata);
                foreach ($receiversdata as $receiversvalue) {
                    $revmail=$receiversvalue->email;
                    $revname=$receiversvalue->name;
                }
                $message->to($revmail,$revname)->subject(' Review ');
            });
         /*****insert record in review table ****/
        $timestamps = new DateTime();
        $addreview = new Reviews;
        $addreview->user_id = $uids;
        $addreview->sender_id = Auth::user()->id;
        $addreview->body = $comment;
        $addreview->overall = $overall;
        $addreview->punctuality = $punctuality;
        $addreview->knowledge = $knowledge;
        $addreview->staff = $staff;
        $addreview->status = '0';
        $addreview->save();
        $catss="added";
         }else{
         	$catss="Review Already Added";
         }
         return Response::json($catss);
          	
          }
    }
    /*****reviews confirmation**/
    public function index(Request $request)
    {
       
        /* Cover Image */
        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
        $data['userMetaObj'] = new UserMetum();
         
$data['rolename']=new RoleController();
           $data['userfollow']=new UserFollow();
         $uids = Auth::user()->id;
         $userid=$uids;
        $data['userid']='';
         if(Auth::check()){
                    $uid=Auth::user()->id;
                }else{
                     $uid=$data['userid'];
                     }
                          
        $userController = new UserController(); 
if(isset($request->profilepic)){

        $data['profile-image']= $userController->myProfileImage($request);

        }
        //$connectedUserArray = UserController::index($uid); 
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $userController->postCoverPhoto($request);
        }elseif($userController->getPhoto('cover',$uid)){
            $data['cover-image']= $userController->getPhoto('cover',$uid);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $userController->postProfilePhoto($request);
        }elseif($userController->getPhoto('profile',$uid)){
            $data['profile-image']= $userController->getPhoto('profile',$uid);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        } 
       $countrequest=0;
        $countrequest=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$userid],['status','=',0]])->count();
        if($countrequest>0){
            $data['friendrequest']=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$userid]])->get();
        }else{
            $data['friendrequest']="no";
        }
        /****receiver***/
       $data['countrequests']=UserConnection::where([['user_id', '=', $userid],['connect_user_id','=',$uid]])->count();
        if($data['countrequests']>0){
            $data['friendrequest']=UserConnection::where([['user_id', '=', $userid],['connect_user_id','=',$uid]])->get();
        }
print_r($data['profile-image']);
    $data['reviewss']='no';
        $uid=Auth::user()->id;
         $reviewscount=Reviews::where('user_id', '=', $uid)->count();
        if($reviewscount>0){

            $data['reviewss']=Reviews::where('user_id', '=', $uid)->get();
            foreach ($data['reviewss'] as $key => $reviews) {
                if ($reviews->is_reply) {
                   $data['review_comments'][$reviews->id] = $userController->getReviewComments($reviews->id);
                }
            }
        }else{
            $data['reviewss']='no';
        }
    
         $data['userAllMetaData']  = $userController->getUserInformation();
       
        /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
        

        /***Notification here***/

       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
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
        return view('user.reviewsconfrimation',compact('data','searchdropdown'));
    }
   
   
     /****reviews approve***/
     public function approvereviews(Request $request){
    $checkreviews='';
    $rid=$request->approved;
    if(isset($rid)){
    $checkreviews=Reviews::where('id','=',$rid)->count();

    $postupdatedd=Reviews::where('id','=',$rid)->update(  array(                    
                                'status' =>'1'
                    ));
    }else{
        /****review delete **/
        $rid=$request->delr;
     $postupdatedd=Reviews::where('id','=',$rid)->delete();
   }
   // print_r($rid);

   return Response::json($rid);
    }
    /* Reply on review */
    public function reviewComment(Request $request)
    {
        $drId = $request->drId;
        $senderId = $request->senderId;
        $reviewId = $request->reviewId;
        $replyComment = $request->comment;
        $reviewComment = DB::table('review_comments')->insert(array(
          'review_id'         => $reviewId,
          'comment_user_id'   => $senderId,          
          'comment'           => $replyComment,
        ));
        $commentId = DB::getPdo()->lastInsertId();
        DB::table('reviews')->where(['id' => $reviewId, 'is_reply' => 0])->update(['is_reply'=> '1']);
        $this->getUpdatedCommentOnReview($reviewId,$replyComment,$commentId,$drId);   
    }

    /* Update current comment */
    public function getUpdatedCommentOnReview($reviewId,$comment,$commentId,$postUserId)
    {
        $userObj = new User();
        $uid = Auth::user()->id;
        $userDataObj = $userObj->getUserData(['id' => $uid]);
        $html = '';
        foreach ($userDataObj as $key => $userData) {
            $userName = $userData->name;
            $userProf =  $userData->avatar;
        }
        echo view('user.review.review-comment-ajax',compact('uid','reviewId','comment','commentId','postUserId','userName','userProf'));
    }

    /* Mail to user on review comment reply */
    
}
